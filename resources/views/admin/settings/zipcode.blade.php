<div class="tab-pane fade" id="zipCode-tab-pane" role="tabpanel" aria-labelledby="zipCode-tab" tabindex="0">
    <div class="card-body">
        <div class="zipcode-card-body rounded-custom-12">
            <div class="zipcode-table custom-table mb-3">
                <form method="POST" id="zipcode-form">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center">{{ trans('rest.settings.zipcode.title') }}</th>
                            <th scope="col" class="text-center">{{ trans('rest.settings.zipcode.min_order_price') }}</th>
                            <th scope="col" class="text-center">{{ trans('rest.settings.zipcode.delivery_charges') }}</th>
                            <th scope="col" class="text-center" width="20%">{{ trans('rest.settings.zipcode.status') }}</th>
                            <th scope="col" class="text-center" width="13%">{{ trans('rest.button.action') }}</th>
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
                                    {{ trans('rest.button.save') }}
                                </button>
                                <input type="hidden" id="id" value="">
                            </td>
                        </tr>
                        @foreach($zipcodes as $key => $zipcode)
                            <tr class="zipcode-row-{{ $zipcode['id'] }}">
                                <td>
                                    <input type="text" class="form-control text-center w-10r m-auto zipcode-text" value="{{ $zipcode['zipcode'] }}" id="zipcode_{{ $zipcode['id'] }}" readonly/>
                                </td>
                                <td class="text-center">
                                    <div class="input-group w-5r m-auto">
                                        <span class="input-group-text" id="basic-addon1">€</span>
                                        <input type="number" class="form-control m-auto" value="{{ $zipcode['min_order_price'] }}" id="min_order_price_{{ $zipcode['id'] }}" readonly/>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="input-group w-5r m-auto">
                                        <span class="input-group-text" id="basic-addon1">€</span>
                                        <input type="number" class="form-control m-auto" value="{{ $zipcode['delivery_charge'] }}" id="delivery_charge_{{ $zipcode['id'] }}" readonly/>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-switch custom-switch justify-content-center ps-0">
                                        <input class="form-check-input" type="checkbox" role="switch" id="status_{{ $zipcode['id'] }}"
                                               {{ $zipcode["status"] ? "checked":"" }} onchange="changeStatus({{ $zipcode['id'] }})">
                                    </div>
                                </td>
                                <td class="">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a class="btn btn-site-theme btn-icon" tabindex="0" href="javascript:void(0);" id="zipcode-edit-btn-{{ $zipcode['id'] }}"
                                           onclick="editZipcode({{ $zipcode['id'] }})">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a class="btn btn-site-theme btn-icon" id="zipcode-remove-btn-{{ $zipcode['id'] }}" onclick="deleteZipcode({{ $zipcode['id'] }})">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </a>

                                        <button type="button" class="btn btn-site-theme text-uppercase font-sebibold w-100" id="zipcode-save-btn-{{ $zipcode['id'] }}" style="display: none;"
                                                onclick="saveZipcode({{ $zipcode['id'] }})">{{ trans('rest.button.save') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="d-flex justify-content-between align-items-center" style="padding: 0 20px 0 20px;">
                {{ $zipcodes->links() }}
                <div class="ms-auto d-flex align-items-center custom-pagination justify-content-end w-100">
                    <label class="text-nowrap">{{ trans('rest.button.rows_per_page') }}</label>
                    <select id="per_page_dropdown" onchange="" class="form-control bg-white ms-2">
                        @for($i=5; $i<=20; $i+=5)
                        <option {{ $perPage == $i ? 'selected' : '' }} value="{{ Request::url().'?per_page=' }}{{ $i }}">
                            {{ $i }}
                        </option>
                        @endfor
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
                            <h4 class="alert-text-1 mb-40px">{{ trans('rest.modal.zipcode.delete_message') }}</h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button"
                                class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px"
                                data-bs-dismiss="modal">{{ trans('rest.button.cancel') }}
                        </button>
                        <button type="button" class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-160px"
                                id="zipcode-delete-btn">{{ trans('rest.button.delete') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
