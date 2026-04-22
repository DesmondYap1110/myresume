<?php $__env->startPush('title'); ?>
Dashboard
<?php $__env->stopPush(); ?>

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
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Dashboard</h3>
        </div>
    </div>
    <div class="row">
        <?php if (isset($component)) { $__componentOriginal7d12ff95845b800d7113bea16d8e4ef7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.admin.card.card','data' => ['icon' => 'fas fa-users','text' => 'Total Visitors','data' => $all_visit_log]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.admin.card.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'fas fa-users','text' => 'Total Visitors','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($all_visit_log)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7)): ?>
<?php $attributes = $__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7; ?>
<?php unset($__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7d12ff95845b800d7113bea16d8e4ef7)): ?>
<?php $component = $__componentOriginal7d12ff95845b800d7113bea16d8e4ef7; ?>
<?php unset($__componentOriginal7d12ff95845b800d7113bea16d8e4ef7); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal7d12ff95845b800d7113bea16d8e4ef7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.admin.card.card','data' => ['icon' => 'fas fa-user','text' => 'Visitors Today','data' => $visit_log]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.admin.card.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'fas fa-user','text' => 'Visitors Today','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($visit_log)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7)): ?>
<?php $attributes = $__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7; ?>
<?php unset($__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7d12ff95845b800d7113bea16d8e4ef7)): ?>
<?php $component = $__componentOriginal7d12ff95845b800d7113bea16d8e4ef7; ?>
<?php unset($__componentOriginal7d12ff95845b800d7113bea16d8e4ef7); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal7d12ff95845b800d7113bea16d8e4ef7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.template1.admin.card.card','data' => ['icon' => 'fas fa-envelope','text' => 'Inbox Messages','data' => $inbox]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('template1.admin.card.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'fas fa-envelope','text' => 'Inbox Messages','data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($inbox)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7)): ?>
<?php $attributes = $__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7; ?>
<?php unset($__attributesOriginal7d12ff95845b800d7113bea16d8e4ef7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7d12ff95845b800d7113bea16d8e4ef7)): ?>
<?php $component = $__componentOriginal7d12ff95845b800d7113bea16d8e4ef7; ?>
<?php unset($__componentOriginal7d12ff95845b800d7113bea16d8e4ef7); ?>
<?php endif; ?>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Visitor Statistics</div>
                        <?php if(!request()->header('User-Agent') || !Str::contains(request()->header('User-Agent'), ['Mobile', 'Android', 'iPhone'])): ?>
                        <div class="card-tools">
                            <a href="javascript:void(0);" class="btn btn-label-info btn-round btn-sm" onclick="printChart()">
                                <span class="btn-label"><i class="fa fa-print"></i></span>Print
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" id="print-area" style="min-height: 200px">
                        <canvas id="statisticsChart"></canvas>
                    </div>
                    <div id="myChartLegend"></div>
                </div>
            </div>
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
const ctx = document.getElementById('statisticsChart').getContext('2d');

const data_visit = <?php echo json_encode($data_visit, 15, 512) ?>;

// last 7 days labels
const period = Object.keys(data_visit);

// fake views data
const data = Object.values(data_visit);

new Chart(ctx, {
    type: 'line',
    data: {
        labels: period,
        datasets: [{
            label: 'Views (Last 7 Days)',
            data: data,
            borderWidth: 2,
            tension: 0.2,
            backgroundColor: 'rgba(255, 215, 0, 0.6)',
            borderColor: 'rgba(255, 215, 0, 1)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,

        scales: {

            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 2,
                    precision: 0
                }
            }
        }
    }
});

function printChart()
{
    window.print();
}
</script>

<?php /**PATH C:\laragon\www\SAPPM\resources\views/admin/template1/dashboard/index.blade.php ENDPATH**/ ?>