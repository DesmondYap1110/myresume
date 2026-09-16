<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(["presets", "activePreset", "current", "editable", "login", "loginImages", "loginUploaded", "loginOverlay"]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(["presets", "activePreset", "current", "editable", "login", "loginImages", "loginUploaded", "loginOverlay"]); ?>
<?php foreach (array_filter((["presets", "activePreset", "current", "editable", "login", "loginImages", "loginUploaded", "loginOverlay"]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php
    $currentImage = (string) ($login['image'] ?? '');
    $selectedImage = old('login_image', match (true) {
        $currentImage === '' => 'none',
        $loginUploaded !== null && $currentImage === $loginUploaded => 'uploaded',
        in_array($currentImage, $loginImages, true) => $currentImage,
        default => $loginImages[0],
    });
    $loginColor = strtoupper(old('login_color', $login['colour'] ?? '#000000'));
    $overlay = (int) old('login_overlay', $loginOverlay);
?>



    <style>
        .theme-presets { display: flex; flex-wrap: wrap; gap: 12px; }
        .theme-preset input { display: none; }
        .theme-preset-card { display: block; width: 150px; border: 2px solid #e9ecef; border-radius: 8px; padding: 8px; cursor: pointer; }
        .theme-preset input:checked + .theme-preset-card { border-color: var(--brand-primary); box-shadow: 0 0 0 3px rgba(0,0,0,.08); }
        .theme-preset-swatches { display: flex; height: 36px; border-radius: 4px; overflow: hidden; }
        .theme-preset-swatches span { flex: 1; }
        .theme-preset-name { display: block; margin-top: 6px; font-weight: 600; text-align: center; }
        .theme-color-row { display: flex; gap: 6px; align-items: center; }
        .theme-color-row input[type=color] { width: 42px; height: 38px; padding: 2px; border: 1px solid #ebedf2; border-radius: 4px; }
        .login-bg-options { display: flex; flex-wrap: wrap; gap: 10px; }
        .login-bg-option input { display: none; }
        .login-bg-thumb { display: flex; flex-direction: column; align-items: center; justify-content: center; width: 96px; height: 60px; border: 2px solid #e9ecef; border-radius: 6px; background: #f5f5f5 center/cover no-repeat; cursor: pointer; font-size: 12px; color: #555; }
        .login-bg-thumb em { font-style: normal; background: rgba(255,255,255,.8); padding: 0 4px; border-radius: 3px; }
        .login-bg-option input:checked + .login-bg-thumb { border-color: var(--brand-primary); box-shadow: 0 0 0 3px rgba(0,0,0,.12); }
        .login-preview { position: relative; height: 220px; border-radius: 8px; overflow: hidden; background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; }
        .login-preview-overlay { position: absolute; inset: 0; }
        .login-preview-card { position: relative; width: 45%; background: #fff; border-radius: 6px; padding: 14px; display: flex; flex-direction: column; gap: 8px; }
        .login-preview-card span { display: block; height: 10px; background: #e9ecef; border-radius: 3px; }
        .login-preview-card .btn-bar { height: 14px; background: var(--brand-primary); }
    </style>

    <form action="<?php echo e(route('theme.update')); ?>" method="post" id="theme-form" enctype="multipart/form-data" data-presets='<?php echo json_encode($presets->keyBy('key')->map(fn ($p) => $p['colors']), 15, 512) ?>'>
        <?php echo csrf_field(); ?>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Theme Color</div>
                <div class="card-category">Pick a preset. This page previews your choice; everything changes once you save.</div>
            </div>
            <div class="card-body">
                <div class="theme-presets">
                    <?php $__currentLoopData = $presets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="theme-preset">
                            <input type="radio" name="preset" value="<?php echo e($preset['key']); ?>" <?php if(old('preset', $activePreset) === $preset['key']): echo 'checked'; endif; ?>>
                            <span class="theme-preset-card">
                                <span class="theme-preset-swatches">
                                    <?php $__currentLoopData = ['logo-header', 'sidebar', 'primary', 'accent', 'background']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $token): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span style="background: <?php echo e($preset['colors'][$token] ?? '#ccc'); ?>"></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </span>
                                <span class="theme-preset-name"><?php echo e($preset['label']); ?></span>
                            </span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <h4 class="mt-4 mb-3">Colours</h4>
                <div class="row">
                    <?php $__currentLoopData = $editable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $token => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $value = strtoupper(old("colors.$token", $current[$token] ?? '#000000')); ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label for="theme-<?php echo e($token); ?>"><?php echo e($label); ?></label>
                                <div class="theme-color-row">
                                    <input type="color" id="theme-<?php echo e($token); ?>" class="theme-color-picker" value="<?php echo e(strtolower($value)); ?>" data-token="<?php echo e($token); ?>">
                                    <input type="text" class="form-control theme-color-hex" name="colors[<?php echo e($token); ?>]" value="<?php echo e($value); ?>" maxlength="7" pattern="#[0-9A-Fa-f]{6}" data-token="<?php echo e($token); ?>">
                                    <button type="button" class="btn btn-sm btn-light theme-color-reset" data-token="<?php echo e($token); ?>" title="Use the preset's colour">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Login Page Background</div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-7">
                        <label class="mb-2">Background image</label>
                        <div class="login-bg-options">
                            <?php $__currentLoopData = $loginImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="login-bg-option">
                                    <input type="radio" name="login_image" value="<?php echo e($image); ?>" data-src="<?php echo e(asset($image)); ?>" <?php if($selectedImage === $image): echo 'checked'; endif; ?>>
                                    <span class="login-bg-thumb" style="background-image: url('<?php echo e(asset($image)); ?>')"></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($loginUploaded): ?>
                                <label class="login-bg-option">
                                    <input type="radio" name="login_image" value="uploaded" data-src="<?php echo e(asset($loginUploaded)); ?>" <?php if($selectedImage === 'uploaded'): echo 'checked'; endif; ?>>
                                    <span class="login-bg-thumb" style="background-image: url('<?php echo e(asset($loginUploaded)); ?>')"><em>Uploaded</em></span>
                                </label>
                            <?php endif; ?>
                            <label class="login-bg-option">
                                <input type="radio" name="login_image" value="upload" <?php if($selectedImage === 'upload'): echo 'checked'; endif; ?>>
                                <span class="login-bg-thumb"><i class="fas fa-upload"></i><em>Upload</em></span>
                            </label>
                            <label class="login-bg-option">
                                <input type="radio" name="login_image" value="none" <?php if($selectedImage === 'none'): echo 'checked'; endif; ?>>
                                <span class="login-bg-thumb"><i class="fas fa-fill-drip"></i><em>Colour only</em></span>
                            </label>
                        </div>

                        <div class="form-group px-0" data-upload-field <?php if($selectedImage !== 'upload'): ?> hidden <?php endif; ?>>
                            <input type="file" class="form-control" name="login_upload" accept="image/jpeg,image/png,image/webp">
                            <small class="form-text text-muted">JPG, PNG or WebP, up to 4 MB. A wide photo (1920 x 1080) looks best.</small>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group px-0">
                                    <label for="login-color">Background colour</label>
                                    <div class="theme-color-row">
                                        <input type="color" id="login-color" value="<?php echo e(strtolower($loginColor)); ?>" data-login-color>
                                        <input type="text" class="form-control" name="login_color" value="<?php echo e($loginColor); ?>" maxlength="7" pattern="#[0-9A-Fa-f]{6}" data-login-color-hex>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group px-0">
                                    <label for="login-overlay">Darken image <span data-overlay-value><?php echo e($overlay); ?>%</span></label>
                                    <input type="range" id="login-overlay" class="form-range" name="login_overlay" min="0" max="80" step="5" value="<?php echo e($overlay); ?>" data-login-overlay>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <label class="mb-2">Preview</label>
                        <div class="login-preview" data-login-preview style="background-color: <?php echo e($loginColor); ?>;">
                            <span class="login-preview-overlay" data-login-preview-overlay style="background: rgba(0,0,0,<?php echo e($overlay / 100); ?>)"></span>
                            <span class="login-preview-card">
                                <span></span><span></span><span class="btn-bar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-action">
                <button type="submit" class="btn btn-primary">Save Theme</button>
                <a href="<?php echo e(route('setting.view')); ?>" class="btn btn-light">Discard Changes</a>
                <button type="submit" form="theme-reset-form" class="btn btn-danger float-end" onclick="return confirm('Reset theme and login background to default?')">Reset to Default</button>
            </div>
        </div>
    </form>

    <form method="POST" action="<?php echo e(route('theme.reset')); ?>" id="theme-reset-form">
        <?php echo csrf_field(); ?>
    </form>

<script>
<script>
    (function () {
        'use strict';

        var form = document.getElementById('theme-form');
        var presets = JSON.parse(form.getAttribute('data-presets'));
        var root = document.documentElement.style;
        var isHex = function (v) { return /^#[0-9A-Fa-f]{6}$/.test(v); };

        function darken(hex, percent) {
            var f = 1 - percent / 100;
            return '#' + hex.replace('#', '').match(/../g).map(function (p) {
                return ('0' + Math.round(parseInt(p, 16) * f).toString(16)).slice(-2);
            }).join('');
        }

        // Same follower as Branding::expandCustomColors().
        function apply(token, value) {
            if (!isHex(value)) return;
            root.setProperty('--brand-' + token, value);
            if (token === 'primary') root.setProperty('--brand-primary-hover', darken(value, 15));
        }

        function presetColors() {
            var picked = form.querySelector('input[name="preset"]:checked');
            return presets[picked ? picked.value : 'default'] || {};
        }

        function setField(token, value) {
            form.querySelector('.theme-color-picker[data-token="' + token + '"]').value = value.toLowerCase();
            form.querySelector('.theme-color-hex[data-token="' + token + '"]').value = value.toUpperCase();
            apply(token, value);
        }

        form.querySelectorAll('input[name="preset"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                var colors = presetColors();
                Object.keys(colors).forEach(function (token) { root.setProperty('--brand-' + token, colors[token]); });
                form.querySelectorAll('.theme-color-hex').forEach(function (input) {
                    var token = input.getAttribute('data-token');
                    if (colors[token]) setField(token, colors[token]);
                });
            });
        });

        form.addEventListener('input', function (event) {
            var el = event.target;
            var token = el.getAttribute('data-token');
            if (!token) return;
            if (el.classList.contains('theme-color-picker')) setField(token, el.value);
            if (el.classList.contains('theme-color-hex') && isHex(el.value)) {
                form.querySelector('.theme-color-picker[data-token="' + token + '"]').value = el.value.toLowerCase();
                apply(token, el.value);
            }
        });

        form.addEventListener('click', function (event) {
            var button = event.target.closest('.theme-color-reset');
            if (!button) return;
            var token = button.getAttribute('data-token');
            var colors = presetColors();
            if (colors[token]) setField(token, colors[token]);
        });

        // Login background preview.
        var preview = form.querySelector('[data-login-preview]');
        var previewOverlay = form.querySelector('[data-login-preview-overlay]');
        var uploadField = form.querySelector('[data-upload-field]');
        var fileInput = form.querySelector('input[name="login_upload"]');
        var uploadUrl = null;

        function paintLogin() {
            var picked = form.querySelector('input[name="login_image"]:checked');
            var value = picked ? picked.value : 'none';
            uploadField.hidden = value !== 'upload';
            var src = value === 'upload' ? uploadUrl : (value === 'none' ? null : picked.getAttribute('data-src'));
            preview.style.backgroundImage = src ? 'url("' + src + '")' : 'none';
        }

        form.querySelectorAll('input[name="login_image"]').forEach(function (r) { r.addEventListener('change', paintLogin); });
        fileInput.addEventListener('change', function () {
            if (uploadUrl) URL.revokeObjectURL(uploadUrl);
            uploadUrl = fileInput.files[0] ? URL.createObjectURL(fileInput.files[0]) : null;
            paintLogin();
        });

        var colorPicker = form.querySelector('[data-login-color]');
        var colorHex = form.querySelector('[data-login-color-hex]');
        colorPicker.addEventListener('input', function () {
            colorHex.value = colorPicker.value.toUpperCase();
            preview.style.backgroundColor = colorPicker.value;
        });
        colorHex.addEventListener('input', function () {
            if (isHex(colorHex.value)) {
                colorPicker.value = colorHex.value.toLowerCase();
                preview.style.backgroundColor = colorHex.value;
            }
        });

        var overlay = form.querySelector('[data-login-overlay]');
        overlay.addEventListener('input', function () {
            previewOverlay.style.background = 'rgba(0,0,0,' + (overlay.value / 100) + ')';
            form.querySelector('[data-overlay-value]').textContent = overlay.value + '%';
        });

        paintLogin();
    })();
</script>
</script>
<?php /**PATH C:\laragon\www\myresume\resources\views/components/template1/admin/setting/theme-panel.blade.php ENDPATH**/ ?>