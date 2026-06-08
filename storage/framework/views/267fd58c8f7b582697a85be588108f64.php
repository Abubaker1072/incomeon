<?php
    $loginHero = get_setting('admin_login_page_image')
        ? uploaded_asset(get_setting('admin_login_page_image'))
        : static_asset('assets/img/auth/login-hero.png');
?>

<div class="auth-page">
    <div class="auth-card">
        <div class="auth-card__row">
            
            <div class="auth-card__hero">
                <img src="<?php echo e($loginHero); ?>" alt="<?php echo e(translate('Login')); ?>">
            </div>

            
            <div class="auth-card__form">
                <div class="auth-card__logo">
                    <img src="<?php echo e(uploaded_asset(get_setting('site_icon'))); ?>" alt="<?php echo e(translate('Site Icon')); ?>">
                </div>

                <h1 class="auth-card__title"><?php echo e(translate('Welcome to')); ?> <?php echo e(env('APP_NAME')); ?></h1>
                <p class="auth-card__sub"><?php echo e(translate('Login to your account.')); ?></p>

                <form action="<?php echo e(route('login')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="form-group">
                        <label for="email" class="fs-12 fw-700 text-muted"><?php echo e(translate('Email')); ?></label>
                        <input type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>"
                            value="<?php echo e(old('email')); ?>" placeholder="<?php echo e(translate('johndoe@example.com')); ?>"
                            name="email" id="email" autocomplete="email" autofocus>
                        <?php if($errors->has('email')): ?>
                            <span class="invalid-feedback d-block"><strong><?php echo e($errors->first('email')); ?></strong></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="password" class="fs-12 fw-700 text-muted"><?php echo e(translate('Password')); ?></label>
                        <div class="position-relative">
                            <input type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>"
                                placeholder="<?php echo e(translate('Password')); ?>" name="password" id="password" autocomplete="current-password">
                            <i class="password-toggle las la-eye"></i>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <label class="mb-0 d-flex align-items-center gap-1" style="gap:0.4rem;font-size:0.875rem;">
                            <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                            <?php echo e(translate('Remember Me')); ?>

                        </label>
                        <a href="<?php echo e(route('password.request')); ?>" class="text-primary" style="font-size:0.875rem;"><?php echo e(translate('Forgot password?')); ?></a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block"><?php echo e(translate('Login')); ?></button>
                </form>

                <?php if(env('DEMO_MODE') == 'On'): ?>
                    <div class="mt-4">
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <td>admin@example.com</td>
                                    <td>123456</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info btn-sm" onclick="autoFillAdmin()"><?php echo e(translate('Copy')); ?></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="auth-back">
            <a href="<?php echo e(url()->previous()); ?>"><i class="las la-arrow-left"></i> <?php echo e(translate('Back to Previous Page')); ?></a>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\Incomeon_ecomm\resources\views/auth/boxed/admin_login.blade.php ENDPATH**/ ?>