 <?php $__env->startSection('content'); ?> <div class="main">
  <div class="main-view">
    <div class="container-fluid bd-gutter bd-layout"> <?php echo $__env->make('layouts.user.side_nav_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <main class="bd-main order-1">
        <div class="main-content">
          <div class="section-page-title main-page-title mb-0">
            <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
              <h1 class="page-title">Privacy Policy</h1>
            </div>
          </div>
          <section class="custom-section informativeterms-section h-100">
            <div class="card custom-card h-100">
              <div class="card-body pb-0 custom-single-text">
                <?= $privacy_policy ?>
              </div>
            </div>
          </section>
        </div>
      </main>
    </div>
  </div>
</div> <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.user-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/go-meal/resources/views/user/cms/privacy-policy.blade.php ENDPATH**/ ?>