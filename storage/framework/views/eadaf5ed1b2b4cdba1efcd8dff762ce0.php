<?php $__env->startSection('auth_title', translate('Create Account')); ?>

<?php $__env->startSection('auth_content'); ?>
    <h1 class="auth-card__title"><?php echo e(translate('Create Account')); ?></h1>
    <p class="acc-auth__sub"><?php echo e(translate('Join us and start shopping today.')); ?></p>

    <form method="POST" action="<?php echo e(route('register')); ?>" id="register-form" data-auth-form>
        <?php echo csrf_field(); ?>
        <input type="hidden" name="account_type" id="account_type" value="<?php echo e(old('account_type', 'customer')); ?>">

        <div class="acc-field">
            <label><?php echo e(translate('Register as')); ?> <span class="text-danger">*</span></label>
            <div class="acc-role-toggle" role="group" aria-label="<?php echo e(translate('Account type')); ?>">
                <button type="button" class="acc-role-btn <?php echo e(old('account_type', 'customer') === 'customer' ? 'is-active' : ''); ?>" data-role="customer">
                    <span class="acc-role-btn__bulb" aria-hidden="true"></span>
                    <i class="las la-user"></i>
                    <span><?php echo e(translate('Customer')); ?></span>
                </button>
                <button type="button" class="acc-role-btn <?php echo e(old('account_type') === 'vendor' ? 'is-active' : ''); ?>" data-role="vendor">
                    <span class="acc-role-btn__bulb" aria-hidden="true"></span>
                    <i class="las la-store"></i>
                    <span><?php echo e(translate('Vendor')); ?></span>
                </button>
            </div>
            <?php $__errorArgs = ['account_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="acc-field-error"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="acc-field">
            <label for="name"><?php echo e(translate('Full Name')); ?> <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" required>
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="acc-field-error"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="acc-field">
            <label for="email"><?php echo e(translate('Email')); ?> <span class="text-danger">*</span></label>
            <input type="email" id="email" name="email" value="<?php echo e(old('email', $email ?? '')); ?>" required>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="acc-field-error"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="acc-field">
            <label for="password"><?php echo e(translate('Password')); ?> <span class="text-danger">*</span></label>
            <input type="password" id="password" name="password" required>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="acc-field-error"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="acc-field">
            <label for="password_confirmation"><?php echo e(translate('Confirm Password')); ?> <span class="text-danger">*</span></label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div id="vendor-fields" class="acc-vendor-collapse <?php echo e(old('account_type') === 'vendor' ? 'is-open' : ''); ?>">
            <div class="acc-vendor-fields">
                <p class="acc-vendor-fields__title">
                    <i class="las la-store"></i> <?php echo e(translate('Vendor / Brand Details')); ?>

                </p>
                <div class="acc-field">
                    <label for="shop_name"><?php echo e(translate('Brand Name')); ?> <span class="text-danger">*</span></label>
                    <input type="text" id="shop_name" name="shop_name" value="<?php echo e(old('shop_name')); ?>">
                    <?php $__errorArgs = ['shop_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="acc-field-error"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="acc-field">
                    <label for="address"><?php echo e(translate('Brand Address')); ?> <span class="text-danger">*</span></label>
                    <textarea id="address" name="address" rows="3"><?php echo e(old('address')); ?></textarea>
                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="acc-field-error"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="acc-field">
                    <label for="phone"><?php echo e(translate('Brand Phone Number')); ?> <span class="text-danger">*</span></label>
                    <input type="text" id="phone" name="phone" value="<?php echo e(old('phone', $phone ?? '')); ?>">
                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="acc-field-error"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>

        <?php if(get_setting('google_recaptcha') == 1): ?>
            <div class="acc-field">
                <div class="g-recaptcha" data-sitekey="<?php echo e(env('RECAPTCHA_SITE_KEY')); ?>"></div>
                <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="acc-field-error"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        <?php endif; ?>

        <button type="submit" class="auth-btn auth-btn--primary auth-btn--block" id="register-submit">
            <i class="las la-user-check"></i> <?php echo e(translate('Register as Customer')); ?>

        </button>
    </form>

    <div class="auth-actions">
        <p class="auth-actions__label"><?php echo e(translate('Already have an account?')); ?></p>
        <div class="auth-actions__buttons auth-actions__buttons--single">
            <a href="<?php echo e(route('user.login')); ?>" class="auth-btn auth-btn--outline" data-auth-nav>
                <i class="las la-sign-in-alt"></i> <?php echo e(translate('Sign In')); ?>

            </a>
        </div>
    </div>

    <?php if(get_setting('google_recaptcha') == 1): ?>
        <?php $__env->startPush('scripts'); ?>
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <?php $__env->stopPush(); ?>
    <?php endif; ?>

    <?php $__env->startPush('scripts'); ?>
        <script>
            (function () {
                var typeInput = document.getElementById('account_type');
                var vendorFields = document.getElementById('vendor-fields');
                var submitBtn = document.getElementById('register-submit');
                var shopName = document.getElementById('shop_name');
                var phone = document.getElementById('phone');
                var address = document.getElementById('address');

                function setVendorRequired(isVendor) {
                    [shopName, phone, address].forEach(function (el) {
                        if (!el) return;
                        el.required = isVendor;
                    });
                }

                function setRole(role) {
                    typeInput.value = role;
                    document.querySelectorAll('.acc-role-btn').forEach(function (btn) {
                        btn.classList.toggle('is-active', btn.getAttribute('data-role') === role);
                    });

                    var isVendor = role === 'vendor';
                    vendorFields.classList.toggle('is-open', isVendor);
                    setVendorRequired(isVendor);

                    var label = isVendor
                        ? <?php echo json_encode(translate('Register as Vendor'), 15, 512) ?>
                        : <?php echo json_encode(translate('Register as Customer'), 15, 512) ?>;
                    submitBtn.innerHTML = '<i class="las la-user-check"></i> ' + label;
                }

                document.querySelectorAll('.acc-role-btn').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        setRole(btn.getAttribute('data-role'));
                    });
                });

                setRole(typeInput.value || 'customer');
            })();
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('modules.account.layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views/modules/account/pages/auth/register.blade.php ENDPATH**/ ?>