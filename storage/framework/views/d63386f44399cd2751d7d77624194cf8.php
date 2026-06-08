<?php $__env->startSection('auth_title', translate('Sign In')); ?>

<?php $__env->startSection('auth_content'); ?>
    <h1 class="auth-card__title" style="text-transform:uppercase;"><?php echo e(translate('Welcome to')); ?> <?php echo e(get_setting('site_name')); ?></h1>
    <p class="auth-card__sub"><?php echo e(translate('Login to your account.')); ?></p>

    <form method="POST" action="<?php echo e(route('login')); ?>" data-auth-form>
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="email" class="fs-12 fw-700 text-muted"><?php echo e(translate('Email')); ?></label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="<?php echo e(translate('johndoe@example.com')); ?>" required autofocus>
        </div>
        <div class="form-group">
            <label for="password" class="fs-12 fw-700 text-muted"><?php echo e(translate('Password')); ?></label>
            <div class="position-relative">
                <input type="password" class="form-control" id="password" name="password" placeholder="<?php echo e(translate('Password')); ?>" required>
                <i class="password-toggle las la-eye"></i>
            </div>
        </div>
        <div class="acc-field" style="display:flex;align-items:center;justify-content:space-between;gap:0.5rem;">
            <label style="display:flex;align-items:center;gap:0.4rem;font-weight:400;margin:0;">
                <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                <?php echo e(translate('Remember Me')); ?>

            </label>
            <a href="<?php echo e(route('password.request')); ?>" class="auth-link" data-auth-nav><?php echo e(translate('Forgot Password?')); ?></a>
        </div>
        <button type="submit" class="auth-btn auth-btn--primary auth-btn--block">
            <i class="las la-sign-in-alt"></i> <?php echo e(translate('Login')); ?>

        </button>
    </form>

    <div class="auth-actions">
        <p class="auth-actions__label"><?php echo e(translate('Dont have an account?')); ?></p>
        <div class="auth-actions__buttons auth-actions__buttons--single">
            <a href="<?php echo e(route('user.registration')); ?>" class="auth-btn auth-btn--outline" data-auth-nav>
                <i class="las la-user-plus"></i> <?php echo e(translate('Register')); ?>

            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('modules.account.layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views/modules/account/pages/auth/login.blade.php ENDPATH**/ ?>