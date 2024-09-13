<?php $__env->startSection('content'); ?>
<div class="main">
    <div class="main-view">
        <div class="container-fluid bd-gutter bd-layout">
            <?php echo $__env->make('layouts.admin.side_nav_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <main class=" order-1 w-100">
                <div class="main-content">
                    <div class="section-page-title mb-0">
                        <h1 class="page-title"><?php echo e(trans('rest.coupons.title')); ?></h1>
                        <div class="col text-end">
                            <div class="form-group mb-0">
                                <a class="btn btn-outline-secondary border-light btn-default me-4"
                                   href="<?php echo e(route('claimHistoryLog')); ?>">
                                    <img class="svg" src="<?php echo e(asset('images/claim-history.svg')); ?>" alt="" height="20" width="20">
                                    <span class="align-middle ms-3"><?php echo e(trans('rest.coupons.claim_history')); ?></span>
                                </a>
                                <a class="btn btn-site-theme btn-default btn-box-shadow" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addCouponModal">
                                    <img src="<?php echo e(asset('images/add-up-white.svg')); ?>" alt="" height="20" width="20" class="svg">
                                    <span class="align-middle ms-2"><?php echo e(trans('rest.coupons.add')); ?></span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- start coupons card section -->
                    <section class="custom-section">
                        <div class="coupon-card-grid">
                            <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" id="id" value="<?php echo e($coupon->id); ?>">
                            <div class="card editdish-card coupons-card">
                                <div class="card-body pb-0">
                                    <div class="card-custom-header d-flex align-items-center justify-content-between">
                                        <div class="form-check form-switch custom-switch justify-content-center ps-0">
                                            <input class="form-check-input" type="checkbox" role="switch" <?php echo e($coupon->status ? 'checked':''); ?>>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a class="btn btn-site-theme btn-icon me-2" tabindex="0" href="javascript:void(0);" id="coupon-edit-btn" onclick="editCoupon(<?php echo e($coupon->id); ?>)">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a class="btn btn-site-theme btn-icon" data-bs-toggle="modal" data-bs-target="#deleteCouponModal" onclick="deleteCoupon(<?php echo e($coupon->id); ?>)">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="inner-card">
                                        <div class="inner-card-body">
                                            <h3><?php echo e($coupon->percentage_off); ?><sup>%</sup><sub><?php echo e(trans('rest.coupons.off')); ?></sub></h3>
                                            <h6><?php echo e(trans('rest.coupons.per_off')); ?></h6>
                                            <div class="dotted-divider"></div>
                                            <p class="valid-date mb-0"><?php echo e(trans('rest.coupons.valid_until')); ?> <?php echo e($coupon->end_expiry_date); ?></p>
                                        </div>
                                        <div class="promocode-box">
                                            <p class="mb-0 d-inline-block"><?php echo e(trans('rest.coupons.promo_code')); ?></p>
                                            <span class="badge text-bg-white d-inline-block"><?php echo e($coupon->promo_code); ?></span>
                                        </div>
                                        <div class="circle1"></div>
                                        <div class="circle2"></div>
                                    </div>

                                </div>
                                <div class="card-footer bg-white border-0">
                                    <p class="mb-0 text-center coupons-card-footer-text text-truncate"><?php echo e($coupon->description); ?></p>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </section>
                    <!-- start coupons card section -->
                </div>
            </main>
        </div>
    </div>
    <!-- start footer -->
    <?php echo $__env->make('layouts.admin.footer_design', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- end footer -->
</div>


<!-- start add coupon Modal -->
<div class="modal fade custom-modal" id="addCouponModal" tabindex="-1" aria-labelledby="addCouponModal" aria-hidden="true">
    <div class="modal-dialog custom-w-441px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title mb-0"><?php echo e(trans('rest.coupons.add')); ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="coupon-form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="points" class="form-label"><?php echo e(trans('rest.coupons.points')); ?></label>
                                <input type="number" class="form-control" id="points" name="points" min="0" max="1000">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price" class="form-label"><?php echo e(trans('rest.coupons.min_order_price')); ?></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">€</span>
                                    <input type="text" class="form-control" id="price" min="0" name="price"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="promocode" class="form-label"><?php echo e(trans('rest.coupons.promo_code')); ?></label>
                                <input type="text" class="form-control" id="promo_code" name="promo_code" maxlength="20" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="percentageofoff" class="form-label"><?php echo e(trans('rest.coupons.per_off')); ?></label>
                                <input type="number" class="form-control" id="percentage_off" name="percentage_off" min="1" max="100" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="percentageofoff" class="form-label"><?php echo e(trans('rest.coupons.validity_date')); ?></label>
                                <div class="input-group dateselect-group date">
                                    <span class="input-group-text" id="basic-addon1">
                                         <img class="svg" src="<?php echo e(asset('images/calender-icon-up.svg')); ?>" height="20" width="20">
                                    </span>
                                    <input type="text" class="form-control" id="expiry_date" aria-label="dateofbirth" aria-describedby="basic-addon1" name="expiry_date" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <label for="newpassword" class="form-label"><?php echo e(trans('rest.coupons.description')); ?></label>
                                <textarea class="form-control" rows="3" id="description" name="description" maxlength="200" required></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="id" value="">
                    <button type="submit" class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-100 mt-30px" id="coupon-save-btn"><?php echo e(trans('rest.button.save')); ?>

                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end add coupon  Modal -->

<div class="modal fade custom-modal" id="deleteCouponModal" tabindex="-1" aria-labelledby="dleteAlertModal" aria-hidden="true">
    <div class="modal-dialog custom-w-441px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h4 class="alert-text-1 mb-40px"><?php echo e(trans('rest.modal.coupon.delete_message')); ?></h4>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px" data-bs-dismiss="modal">
                    <?php echo e(trans('rest.button.cancel')); ?></button>
                    <button type="button" class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-160px" id="coupon-delete-btn"><?php echo e(trans('rest.button.delete')); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/coupons.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\wamp\www\go-meal\resources\views/admin/coupons/index.blade.php ENDPATH**/ ?>