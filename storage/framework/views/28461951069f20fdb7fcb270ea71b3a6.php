<?php $__env->startSection('content'); ?>
<div class="main">
    <div class="main-view">
        <div class="container-fluid bd-gutter bd-layout bg-light">
            <?php echo $__env->make('layouts.admin.side_nav_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <main class="order-1 w-100">
                <div class="main-content">
                    <div class="section-page-title mb-0">
                        <h1 class="page-title"><?php echo e(trans('rest.my_website.title')); ?></h1>
                    </div>

                    <!-- start Setting section -->
                    <section class="custom-section">
                        <div class="customize-tab setting-tab horizontal_tab_setting">
                            <ul class="nav nav-tabs flex-wrap" id="myTab" role="tablist">
                                <li class="empty_space"></li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="banner-tab" data-bs-toggle="tab" data-bs-target="#banner-tab-pane" type="button" role="tab" aria-controls="banner-tab-pane" aria-selected="false">
                                        <?php echo e(trans('rest.my_website.banners.title')); ?>

                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content card editdish-card setting-tab-content" id="myTabContent">
                                <?php echo $__env->make('admin.my-website.banners.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </section>
                    <!-- end Setting section -->
                </div>
            </main>
        </div>
    </div>
    <!-- start footer -->
    <?php echo $__env->make('layouts.admin.footer_design', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- end footer -->
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/banners.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\wamp\www\go-meal\resources\views/admin/my-website/index.blade.php ENDPATH**/ ?>