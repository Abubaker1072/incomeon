<?php

namespace App\Http\Controllers;

use App\Mail\ContactMailManager;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:view_all_contacts'])->only('index');
        $this->middleware(['permission:reply_to_contact'])->only('reply_modal');
    }

    public function index()
    {
        $contacts = Contact::orderBy('id', 'desc')->paginate(20);
        return view('backend.support.contact.contacts', compact('contacts'));
    }

    public function query_modal(Request $request)
    {
        $contact = Contact::findOrFail($request->id);
        return view('backend.support.contact.query_modal', compact('contact'));
    }

    public function reply_modal(Request $request)
    {
        $contact = Contact::findOrFail($request->id);
        return view('backend.support.contact.reply_modal', compact('contact'));
    }

    public function reply(Request $request)
    {
        $contact = Contact::findOrFail($request->contact_id);
        $admin = get_admin();

        $array['name'] = $admin->name;
        $array['email'] = $admin->email;
        $array['phone'] = $admin->phone;
        $array['content'] = str_replace("\n", "<br>", $request->reply);
        $array['subject'] = translate('Query Contact Reply');
        $array['from'] = $admin->email;

        try {
            Mail::to($contact->email)->queue(new ContactMailManager($array));
            $contact->update([
                'reply' => $request->reply,
            ]);
        } catch (\Exception $e) {
            flash(translate('Something Went wrong'))->error();
            return back();
        }
        flash(translate('Reply has been sent successfully'))->success();
        return back();
    }

    public function contact(Request $request)
    {
         $gRecaptchaResponse = $request->input('g-recaptcha-response');
         $secretKey = env('RECAPTCHA_SECRET_KEY');

         $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $gRecaptchaResponse,
         ]);

        $verify = $response->json();
        
        $success = $verify['success'] ?? false;
        if (!$success) {
            return back()->withErrors(['captcha' => 'Captcha verification failed.'])->withInput();
        }
        
       // Check if the honeypot field was filled
       if ($request->filled('website_url')) {
           // It's a bot, silently ignore the submission or return a generic error
           return back()->with('error', 'Something went wrong.');
       }
       
        $submittedAt = now()->timestamp;
        $formLoadedAt = $request->input('form_timestamp');
        $timeTaken = $submittedAt - $formLoadedAt;

       // Reject if the form was submitted too quickly (e.g., less than 5 seconds)
       if ($timeTaken < 5) {
         return back()->with('error', 'Something went wrong.');
       }
        $admin = get_admin();

        $array['name'] = $request->name;
        $array['email'] = $request->email;
        $array['phone'] = $request->phone;
        $array['content'] = str_replace("\n", "<br>", $request->content);
        $array['subject'] = translate('Query Contact');
        $array['from'] = $request->email;

        try {
            Mail::to($admin->email)->queue(new ContactMailManager($array));
            Contact::insert([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'content' => $request->content,
            ]);
        } catch (\Exception $e) {
            flash(translate('Something Went wrong'))->error();
            return back();
        }
        flash(translate('Query has been sent successfully'))->success();
        return back();
    }
}
