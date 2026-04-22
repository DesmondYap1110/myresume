<?php $__env->startPush('title'); ?>
<?php echo e($user->name); ?>

<?php $__env->stopPush(); ?>
<?php if (isset($component)) { $__componentOriginalc69a1bf0770d897473b1c7be8a1d6196 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc69a1bf0770d897473b1c7be8a1d6196 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.website.master.master-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.website.master.master-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php if (isset($component)) { $__componentOriginal89c05c7ffd82842ca0e4f9fb8d3999ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal89c05c7ffd82842ca0e4f9fb8d3999ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.website.navbar.navbar','data' => ['user' => $user,'education' => $education,'experience' => $experience,'project' => $project,'blog' => $blog]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.website.navbar.navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user),'education' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($education),'experience' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($experience),'project' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($project),'blog' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($blog)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal89c05c7ffd82842ca0e4f9fb8d3999ee)): ?>
<?php $attributes = $__attributesOriginal89c05c7ffd82842ca0e4f9fb8d3999ee; ?>
<?php unset($__attributesOriginal89c05c7ffd82842ca0e4f9fb8d3999ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal89c05c7ffd82842ca0e4f9fb8d3999ee)): ?>
<?php $component = $__componentOriginal89c05c7ffd82842ca0e4f9fb8d3999ee; ?>
<?php unset($__componentOriginal89c05c7ffd82842ca0e4f9fb8d3999ee); ?>
<?php endif; ?>

    <div class="container-fluid p-0">

        <!--====================================================
                            ABOUT
        ======================================================-->
        <?php if (isset($component)) { $__componentOriginalcc5fb91dd612c7a5293c90c9d6a17793 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcc5fb91dd612c7a5293c90c9d6a17793 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.website.body.about','data' => ['user' => $user]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.website.body.about'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcc5fb91dd612c7a5293c90c9d6a17793)): ?>
<?php $attributes = $__attributesOriginalcc5fb91dd612c7a5293c90c9d6a17793; ?>
<?php unset($__attributesOriginalcc5fb91dd612c7a5293c90c9d6a17793); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcc5fb91dd612c7a5293c90c9d6a17793)): ?>
<?php $component = $__componentOriginalcc5fb91dd612c7a5293c90c9d6a17793; ?>
<?php unset($__componentOriginalcc5fb91dd612c7a5293c90c9d6a17793); ?>
<?php endif; ?>

        <!--====================================================
                            Education
        ======================================================-->
        <?php if(count($education)!=0): ?>
        <?php if (isset($component)) { $__componentOriginalbe565ad16fd89feb56d510cf7fa93fec = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbe565ad16fd89feb56d510cf7fa93fec = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.website.body.education','data' => ['education' => $education]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.website.body.education'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['education' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($education)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbe565ad16fd89feb56d510cf7fa93fec)): ?>
<?php $attributes = $__attributesOriginalbe565ad16fd89feb56d510cf7fa93fec; ?>
<?php unset($__attributesOriginalbe565ad16fd89feb56d510cf7fa93fec); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbe565ad16fd89feb56d510cf7fa93fec)): ?>
<?php $component = $__componentOriginalbe565ad16fd89feb56d510cf7fa93fec; ?>
<?php unset($__componentOriginalbe565ad16fd89feb56d510cf7fa93fec); ?>
<?php endif; ?>
        <?php endif; ?>


        <!--====================================================
                            Experience
        ======================================================-->
        <?php if(count($experience)!=0): ?>
        <?php if (isset($component)) { $__componentOriginalfadc90e75606a61dbfbe1f46a2f7c726 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfadc90e75606a61dbfbe1f46a2f7c726 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.website.body.experience','data' => ['experience' => $experience]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.website.body.experience'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['experience' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($experience)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfadc90e75606a61dbfbe1f46a2f7c726)): ?>
<?php $attributes = $__attributesOriginalfadc90e75606a61dbfbe1f46a2f7c726; ?>
<?php unset($__attributesOriginalfadc90e75606a61dbfbe1f46a2f7c726); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfadc90e75606a61dbfbe1f46a2f7c726)): ?>
<?php $component = $__componentOriginalfadc90e75606a61dbfbe1f46a2f7c726; ?>
<?php unset($__componentOriginalfadc90e75606a61dbfbe1f46a2f7c726); ?>
<?php endif; ?>
        <?php endif; ?>


        <!--====================================================
                            Project
        ======================================================-->
        <?php if(count($project)!=0): ?>
        <?php if (isset($component)) { $__componentOriginala6d3031f4d51cf0d9b286983775b788e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala6d3031f4d51cf0d9b286983775b788e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.website.body.project','data' => ['project' => $project]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.website.body.project'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['project' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($project)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala6d3031f4d51cf0d9b286983775b788e)): ?>
<?php $attributes = $__attributesOriginala6d3031f4d51cf0d9b286983775b788e; ?>
<?php unset($__attributesOriginala6d3031f4d51cf0d9b286983775b788e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala6d3031f4d51cf0d9b286983775b788e)): ?>
<?php $component = $__componentOriginala6d3031f4d51cf0d9b286983775b788e; ?>
<?php unset($__componentOriginala6d3031f4d51cf0d9b286983775b788e); ?>
<?php endif; ?>
        <?php endif; ?>

        <!--====================================================
                            Blog
        ======================================================-->
        <?php if(count($blog)!=0): ?>
        <?php if (isset($component)) { $__componentOriginal2933a8cede5e46a854c3e923e573e9ca = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2933a8cede5e46a854c3e923e573e9ca = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.website.body.blog','data' => ['blog' => $blog]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.website.body.blog'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['blog' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($blog)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2933a8cede5e46a854c3e923e573e9ca)): ?>
<?php $attributes = $__attributesOriginal2933a8cede5e46a854c3e923e573e9ca; ?>
<?php unset($__attributesOriginal2933a8cede5e46a854c3e923e573e9ca); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2933a8cede5e46a854c3e923e573e9ca)): ?>
<?php $component = $__componentOriginal2933a8cede5e46a854c3e923e573e9ca; ?>
<?php unset($__componentOriginal2933a8cede5e46a854c3e923e573e9ca); ?>
<?php endif; ?>
        <?php endif; ?>

        <!--====================================================
                            CONTACT
        ======================================================-->
        <?php if (isset($component)) { $__componentOriginal26f44f526c08f9d3ac47137f94ab1cc1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26f44f526c08f9d3ac47137f94ab1cc1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.website.body.contact','data' => ['user' => $user]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.website.body.contact'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal26f44f526c08f9d3ac47137f94ab1cc1)): ?>
<?php $attributes = $__attributesOriginal26f44f526c08f9d3ac47137f94ab1cc1; ?>
<?php unset($__attributesOriginal26f44f526c08f9d3ac47137f94ab1cc1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal26f44f526c08f9d3ac47137f94ab1cc1)): ?>
<?php $component = $__componentOriginal26f44f526c08f9d3ac47137f94ab1cc1; ?>
<?php unset($__componentOriginal26f44f526c08f9d3ac47137f94ab1cc1); ?>
<?php endif; ?>
    </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc69a1bf0770d897473b1c7be8a1d6196)): ?>
<?php $attributes = $__attributesOriginalc69a1bf0770d897473b1c7be8a1d6196; ?>
<?php unset($__attributesOriginalc69a1bf0770d897473b1c7be8a1d6196); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc69a1bf0770d897473b1c7be8a1d6196)): ?>
<?php $component = $__componentOriginalc69a1bf0770d897473b1c7be8a1d6196; ?>
<?php unset($__componentOriginalc69a1bf0770d897473b1c7be8a1d6196); ?>
<?php endif; ?>


<?php /**PATH C:\laragon\www\SAPPM\resources\views/website/template1/index.blade.php ENDPATH**/ ?>