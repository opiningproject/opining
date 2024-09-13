<div class="tab-pane fade" id="zipCode-tab-pane" role="tabpanel" aria-labelledby="zipCode-tab" tabindex="0">
    <div class="card-body">
        <div class="zipcode-card-body rounded-custom-12">
            <div class="zipcode-table custom-table mb-3">
                <form method="POST" id="zipcode-form">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center"><?php echo e(trans('rest.settings.zipcode.title')); ?></th>
                            <th scope="col" class="text-center"><?php echo e(trans('rest.settings.zipcode.min_order_price')); ?></th>
                            <th scope="col" class="text-center"><?php echo e(trans('rest.settings.zipcode.delivery_charges')); ?></th>
                            <th scope="col" class="text-center" width="20%"><?php echo e(trans('rest.settings.zipcode.status')); ?></th>
                            <th scope="col" class="text-center" width="13%"><?php echo e(trans('rest.button.action')); ?></th>
                        </tr>
                        </thead>
                        <tbody id="est">
                        <tr class="zipcode-row-0">
                            <td>
                                <input type="text" class="form-control text-center w-10r m-auto zipcode-text" id="zipcode_0" name="zipcode"/>
                            </td>
                            <td class="text-center">
                                <div class="input-group w-5r m-auto">
                                    <span class="input-group-text" id="basic-addon1">€</span>
                                    <input type="number" class="form-control m-auto" min="0" id="min_order_price_0" name="min_order_price"/>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="input-group w-5r m-auto">
                                    <span class="input-group-text" id="basic-addon1">€</span>
                                    <input type="number" class="form-control m-auto" min="0" id="delivery_charge_0" name="delivery_charge"/>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch custom-switch justify-content-center ps-0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="status_0" checked>
                                </div>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-site-theme text-uppercase font-sebibold w-100" id="zipcode-save-btn-0" onclick="saveZipcode(0)">
                                    <?php echo e(trans('rest.button.save')); ?>

                                </button>
                                <input type="hidden" id="id" value="">
                            </td>
                        </tr>
                        <?php $__currentLoopData = $zipcodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $zipcode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="zipcode-row-<?php echo e($zipcode['id']); ?>">
                                <td>
                                    <input type="text" class="form-control text-center w-10r m-auto zipcode-text" value="<?php echo e($zipcode['zipcode']); ?>" id="zipcode_<?php echo e($zipcode['id']); ?>" readonly/>
                                </td>
                                <td class="text-center">
                                    <div class="input-group w-5r m-auto">
                                        <span class="input-group-text" id="basic-addon1">€</span>
                                        <input type="number" class="form-control m-auto" value="<?php echo e($zipcode['min_order_price']); ?>" id="min_order_price_<?php echo e($zipcode['id']); ?>" readonly/>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="input-group w-5r m-auto">
                                        <span class="input-group-text" id="basic-addon1">€</span>
                                        <input type="number" class="form-control m-auto" value="<?php echo e($zipcode['delivery_charge']); ?>" id="delivery_charge_<?php echo e($zipcode['id']); ?>" readonly/>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-switch custom-switch justify-content-center ps-0">
                                        <input class="form-check-input" type="checkbox" role="switch" id="status_<?php echo e($zipcode['id']); ?>"
                                               <?php echo e($zipcode["status"] ? "checked":""); ?> onchange="changeStatus(<?php echo e($zipcode['id']); ?>)">
                                    </div>
                                </td>
                                <td class="">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a class="btn btn-site-theme btn-icon" tabindex="0" href="javascript:void(0);" id="zipcode-edit-btn-<?php echo e($zipcode['id']); ?>"
                                           onclick="editZipcode(<?php echo e($zipcode['id']); ?>)">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a class="btn btn-site-theme btn-icon" id="zipcode-remove-btn-<?php echo e($zipcode['id']); ?>" onclick="deleteZipcode(<?php echo e($zipcode['id']); ?>)">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </a>

                                        <button type="button" class="btn btn-site-theme text-uppercase font-sebibold w-100" id="zipcode-save-btn-<?php echo e($zipcode['id']); ?>" style="display: none;"
                                                onclick="saveZipcode(<?php echo e($zipcode['id']); ?>)"><?php echo e(trans('rest.button.save')); ?>

                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="d-flex justify-content-between align-items-center" style="padding: 0 20px 0 20px;">
                <?php echo e($zipcodes->links()); ?>

                <div class="ms-auto d-flex align-items-center custom-pagination justify-content-end w-100">
                    <label class="text-nowrap"><?php echo e(trans('rest.button.rows_per_page')); ?></label>
                    <select id="per_page_dropdown" onchange="" class="form-control bg-white ms-2">
                        <?php for($i=5; $i<=20; $i+=5): ?>
                        <option <?php echo e($perPage == $i ? 'selected' : ''); ?> value="<?php echo e(Request::url().'?per_page='); ?><?php echo e($i); ?>">
                            <?php echo e($i); ?>

                        </option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade custom-modal" id="deleteZipcodeModal" tabindex="-1" aria-labelledby="dleteAlertModal" aria-hidden="true">
    <div class="modal-dialog custom-w-441px modal-dialog-centered">
        <div>
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="alert-text-1 mb-40px"><?php echo e(trans('rest.modal.zipcode.delete_message')); ?></h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button"
                                class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px"
                                data-bs-dismiss="modal"><?php echo e(trans('rest.button.cancel')); ?>

                        </button>
                        <button type="button" class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-160px"
                                id="zipcode-delete-btn"><?php echo e(trans('rest.button.delete')); ?>

                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH E:\wamp\www\go-meal\resources\views/admin/settings/zipcode.blade.php ENDPATH**/ ?>