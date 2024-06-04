<!-- start refund modal -->
<div class="modal fade custom-modal customisable-modal" id="refundModal" tabindex="-1" aria-labelledby="addressChangeModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-radius">
            <div class="modal-header border-0 align-items-center justify-content-between mb-0">
                <h1 class="modal-title mb-0 font-sebinomedium">{{ trans('modal.refund_req.title') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="refund-form" method="POST">
                    <div class="row">
                        <div class="col-12">
                                <label for="" class="mb-3">{{ trans('modal.refund_req.description') }}</label>
                                <textarea class="form-control" name="description" id="description" required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100">{{ trans('modal.button.send') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end refund modal -->