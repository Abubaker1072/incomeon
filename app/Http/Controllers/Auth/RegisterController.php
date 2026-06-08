<?php

namespace App\Http\Controllers\Auth;

use Cookie;
use Session;
use App\Models\Cart;
use App\Models\Shop;
use App\Models\User;
use App\Rules\Recaptcha;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\OTPVerificationController;
use App\Utility\EmailUtility;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'account_type' => 'required|in:customer,vendor',
            'g-recaptcha-response' => [
                Rule::when(get_setting('google_recaptcha') == 1, ['required', new Recaptcha()], ['sometimes'])
            ],
        ];

        if (($data['account_type'] ?? '') === 'vendor') {
            $rules['shop_name'] = 'required|string|max:255';
            $rules['phone'] = 'required|string|max:20';
            $rules['address'] = 'required|string|max:500';
        }

        $messages = [
            'account_type.required' => translate('Please select Customer or Vendor.'),
            'account_type.in' => translate('Please select Customer or Vendor.'),
            'email.required' => translate('Email is required'),
            'email.unique' => translate('Email already exists.'),
            'shop_name.required' => translate('Brand name is required'),
            'phone.required' => translate('Phone number is required'),
            'address.required' => translate('Brand address is required'),
        ];

        return Validator::make($data, $rules, $messages);
    }

    protected function create(array $data)
    {
        $isVendor = ($data['account_type'] ?? 'customer') === 'vendor';

        if ($isVendor) {
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->phone = $data['phone'];
            $user->password = Hash::make($data['password']);
            $user->user_type = 'seller';
            $user->email_verified_at = now();
            $user->save();

            $shop = new Shop();
            $shop->user_id = $user->id;
            $shop->name = $data['shop_name'];
            $shop->address = $data['address'];
            $shop->slug = preg_replace('/\s+/', '-', str_replace('/', ' ', $data['shop_name'])) . '-' . $user->id;
            $shop->save();
        } elseif (isset($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->user_type = 'customer';
            $user->save();
        } else {
            if (addon_is_activated('otp_system')) {
                $user = new User();
                $user->name = $data['name'];
                $user->phone = '+' . $data['country_code'] . $data['phone'];
                $user->password = Hash::make($data['password']);
                $user->user_type = 'customer';
                $user->verification_code = rand(100000, 999999);
                $user->save();

                if (get_setting('customer_registration_verify') != '1') {
                    $otpController = new OTPVerificationController;
                    $otpController->send_code($user);
                }
            } else {
                throw new \RuntimeException('Email is required for registration.');
            }
        }

        if (Cookie::has('referral_code')) {
            $referral_code = Cookie::get('referral_code');
            $referred_by_user = User::where('referral_code', $referral_code)->first();
            if ($referred_by_user != null) {
                $user->referred_by = $referred_by_user->id;
                $user->save();
            }
        }

        return $user;
    }

    public function register(Request $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if (User::where('email', $request->email)->first() != null) {
                flash(translate('Email already exists.'))->error();
                return back()->withInput();
            }
        } elseif (User::where('phone', '+' . $request->country_code . $request->phone)->first() != null) {
            flash(translate('Phone already exists.'))->error();
            return back()->withInput();
        }

        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        $this->guard()->login($user);

        if (session('temp_user_id') != null) {
            if ($user->user_type == 'customer') {
                Cart::where('temp_user_id', session('temp_user_id'))
                    ->update([
                        'user_id' => $user->id,
                        'temp_user_id' => null
                    ]);
            } else {
                Cart::where('temp_user_id', session('temp_user_id'))->delete();
            }
            Session::forget('temp_user_id');
        }

        if ($user->user_type === 'seller') {
            if (get_email_template_data('registration_email_to_seller', 'status') == 1) {
                try {
                    EmailUtility::selelr_registration_email('registration_email_to_seller', $user, null);
                } catch (\Exception $e) {}
            }
            if (get_email_template_data('seller_reg_email_to_admin', 'status') == 1) {
                try {
                    EmailUtility::selelr_registration_email('seller_reg_email_to_admin', $user, null);
                } catch (\Exception $e) {}
            }
            flash(translate('Vendor registration successful! Welcome to your dashboard.'))->success();
            return redirect()->route('seller.dashboard');
        }

        if ($user->email != null) {
            if (BusinessSetting::where('type', 'email_verification')->first()->value != 1 || get_setting('customer_registration_verify') === '1') {
                $user->email_verified_at = date('Y-m-d H:m:s');
                $user->save();
                offerUserWelcomeCoupon();
                flash(translate('Registration successful.'))->success();
            } else {
                try {
                    EmailUtility::email_verification($user, 'customer');
                    flash(translate('Registration successful. Please verify your email.'))->success();
                } catch (\Throwable $e) {
                    $user->delete();
                    flash(translate('Registration failed. Please try again later.'))->error();
                    return back()->withInput();
                }
            }

            if ($user != null && (get_email_template_data('registration_email_to_customer', 'status') == 1)) {
                try {
                    EmailUtility::customer_registration_email('registration_email_to_customer', $user, null);
                } catch (\Exception $e) {}
            }
        }

        if ($user != null && (get_email_template_data('customer_reg_email_to_admin', 'status') == 1)) {
            try {
                EmailUtility::customer_registration_email('customer_reg_email_to_admin', $user, null);
            } catch (\Exception $e) {}
        }

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    protected function registered(Request $request, $user)
    {
        if ($user->user_type === 'seller') {
            return redirect()->route('seller.dashboard');
        }

        if ($user->email == null) {
            return redirect()->route('verification');
        }

        if (session('link') != null) {
            return redirect(session('link'));
        }

        return redirect()->route('dashboard');
    }
}
