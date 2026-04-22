<style>
    .img-btn{
        opacity: 0 !important;
    }
    .img-btn:hover{
        opacity: 1 !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #1a2035 !important;
        margin-bottom: 5px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
        color: white;
    }


</style>
<?php if (isset($component)) { $__componentOriginal0eafdfbd4929ee0c58f5a7ec660b0f2f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0eafdfbd4929ee0c58f5a7ec660b0f2f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.admin.master.master-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.admin.master.master-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php if (isset($component)) { $__componentOriginal282d9cb825c54c1ba13d93fccf7c6be8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal282d9cb825c54c1ba13d93fccf7c6be8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.admin.header.breadcrumbs-main','data' => ['breadcrumbs' => $breadcrumbs]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.admin.header.breadcrumbs-main'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($breadcrumbs)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal282d9cb825c54c1ba13d93fccf7c6be8)): ?>
<?php $attributes = $__attributesOriginal282d9cb825c54c1ba13d93fccf7c6be8; ?>
<?php unset($__attributesOriginal282d9cb825c54c1ba13d93fccf7c6be8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal282d9cb825c54c1ba13d93fccf7c6be8)): ?>
<?php $component = $__componentOriginal282d9cb825c54c1ba13d93fccf7c6be8; ?>
<?php unset($__componentOriginal282d9cb825c54c1ba13d93fccf7c6be8); ?>
<?php endif; ?>
        <div class="col-md-12">
            <div class="card">
                <form action="<?php echo e(route('profile.update')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="card-action">
                        <div class="row">
                            <div class="col-lg-2 col-md-3 col-sm-12 d-flex justify-content-center align-items-center">
                                <div class="input-file input-file-image ">
                                    <div class="d-flex justify-content-center align-items-center">
                                            <?php if($user_detail->image): ?>
                                                <img class="img-upload-preview img-circle" id="previewImg" width="150" height="150" src="<?php echo e($user_detail->image); ?>" alt="preview">
                                            <?php else: ?>
                                                <img class="img-upload-preview img-circle" id="previewImg" width="150" height="150" src="<?php echo e(asset('assets/admin/img/jm_denis.jpg')); ?>" alt="preview">
                                            <?php endif; ?>
                                        <input type="file" class="d-none" id="uploadImg" accept="image/*" >
                                        <label for="uploadImg" class="btn btn-primary btn-sm  rounded-circle img-btn position-absolute" ><i class="fa fa-upload"></i></label>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-10 col-md-9 col-sm-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-12 py-1">
                                        <label for="name">Name <span>*</span></label>
                                        <input type="text" class="form-control" id="name" placeholder="Enter Name" value="<?php echo e($user_detail->name); ?>" name="name" required>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 py-1">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter Email" value="<?php echo e($user_detail->email); ?>" disabled>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 py-1">
                                        <label>Birthday <span>*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="datepicker" name="dob" value="<?php echo e($user_detail->dob); ?>"  required>
                                            <span class="input-group-text"><i class="fa fa-calendar-check"></i></span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12 py-1">
                                        <label for="phone">Phone <span>*</span></label>
                                        <input type="text" class="form-control" id="phone" placeholder="Enter Phone" value="<?php echo e($user_detail->phone); ?>" name="phone" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="row">
                            <div class="col-md-6 col-lg-4 py-3">
                                <label for="position">Position Role <span>*</span></label>
                                <input type="text" class="form-control" id="position" placeholder="Enter Position Role" value="<?php echo e($user_detail->role); ?>" name="role" required>
                            </div>
                            <div class="col-md-6 col-lg-4 py-3">
                                <label for="name">Address <span>*</span></label>
                                <input type="text" class="form-control" id="address" placeholder="Enter Address" value="<?php echo e($user_detail->address); ?>" name="address" required>
                            </div>
                            <div class="col-md-6 col-lg-4 py-3">
                                <label for="linkedinURL">LinkedIn URL <span>*</span></label>
                                <input type="text" class="form-control" id="linkedinURL" placeholder="Enter linkedIn URL" value="<?php echo e($user_detail->linkedIn_url); ?>" name="linkedIn_url" required>
                            </div>
                            <div class="col-md-12 col-lg-12 py-1">
                                <label>My Website URL</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="<?php echo e(url('/')."/".base64_encode($user_detail->id)); ?>" id="textToCopy" disabled>
                                    <button class="btn btn-black btn-border" id="copyBtn" type="button" >Copy</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <div class="card-title summertext" data-placeholder = "About Me...">About Me</div>
                        <textarea name="about" id="summernote" class="form-control"><?php echo $user_detail->about; ?></textarea>
                    </div>
                    <div class="card-action">
                        <button type = "submit" class="btn btn-dark">Edit</button>
                    </div>
                </form>
            </div>
        </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0eafdfbd4929ee0c58f5a7ec660b0f2f)): ?>
<?php $attributes = $__attributesOriginal0eafdfbd4929ee0c58f5a7ec660b0f2f; ?>
<?php unset($__attributesOriginal0eafdfbd4929ee0c58f5a7ec660b0f2f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0eafdfbd4929ee0c58f5a7ec660b0f2f)): ?>
<?php $component = $__componentOriginal0eafdfbd4929ee0c58f5a7ec660b0f2f; ?>
<?php unset($__componentOriginal0eafdfbd4929ee0c58f5a7ec660b0f2f); ?>
<?php endif; ?>

<script>
    $('.js-example-basic-single').select2({
        placeholder: 'Select Language'
    });

    $('#datepicker').datetimepicker('date', moment('<?php echo e($user_detail->dob); ?>'));

    // JavaScript
    $('#uploadImg').on('change', function () {
        let file = this.files[0];

        if (!file) return;

        let formData = new FormData();
        formData.append('uploadImg', file);
        formData.append('_token', '<?php echo e(csrf_token()); ?>');

        $.ajax({
            url: "<?php echo e(route('profile.upload')); ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.success)
                {
                    $('#previewImg').attr('src', res.url);
                    $.notify("Image uploaded successfully", "success");
                }
                else
                {
                    $.notify(res.message, "error");
                }
            },
            error: function(xhr) {
                let message = 'Upload failed';
                if (xhr.responseJSON && xhr.responseJSON.message)
                {
                    message = xhr.responseJSON.message;
                }
                else if (xhr.responseJSON && xhr.responseJSON.errors)
                {
                    message = Object.values(xhr.responseJSON.errors)[0][0];
                }
                $.notify(message, "error");
            }
        });
    });

    $(document).ready(function() {
        $("#copyBtn").click(function() {
            var text = $("#textToCopy").val();

            // Create temporary textarea
            var temp = $("<textarea>");
            $("body").append(temp);
            temp.val(text).select();

            // Copy text
            document.execCommand("copy");

            // Remove temp element
            temp.remove();

            alert("Copied!");
        });
    });

</script>

<?php /**PATH C:\laragon\www\SAPPM\resources\views/admin/template1/profile/index.blade.php ENDPATH**/ ?>