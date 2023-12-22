<div class="tab-pane fade" id="zipCode-tab-pane" role="tabpanel" aria-labelledby="zipCode-tab" tabindex="0">
    <div class="card-body">
        <div class="zipcode-card-body rounded-custom-12 border-custom-1 py-3">
            <div class="zipcode-table custom-table">
                <form method="POST" id="zipcode-form">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center">Zip Code</th>
                            <th scope="col" class="text-center">Minimum Order Price</th>
                            <th scope="col" class="text-center">Delivery Charges</th>
                            <th scope="col" class="text-center" width="20%">Status</th>
                            <th scope="col" class="text-center" width="13%">Action</th>
                        </tr>
                        </thead>
                        <tbody id="est">
                        <tr class="zipcode-row-0">
                            <td>
                                <input type="text" class="form-control text-center w-10r m-auto" id="zipcode_0"
                                       name="zipcode"/>
                            </td>
                            <td class="text-center">
                                <div class="input-group w-5r m-auto">
                                    <span class="input-group-text" id="basic-addon1">€</span>
                                    <input type="number" class="form-control m-auto" id="min_order_price_0"
                                           name="min_order_price"/>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="input-group w-5r m-auto">
                                    <span class="input-group-text" id="basic-addon1">€</span>
                                    <input type="number" class="form-control m-auto" id="delivery_charge_0"
                                           name="delivery_charge"/>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch custom-switch justify-content-center ps-0">
                                    <input class="form-check-input" type="checkbox" role="switch" id="status_0" checked>
                                </div>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-custom-yellow text-uppercase font-sebibold w-100"
                                        id="zipcode-save-btn-0" onclick="saveZipcode(0)">Save
                                </button>
                                <input type="hidden" id="id" value="">
                            </td>
                        </tr>
                        @foreach($zipcodes as $key => $zipcode)
                            <tr class="zipcode-row-{{ $zipcode['id'] }}">
                                <td>
                                    <input type="text" class="form-control text-center w-10r m-auto"
                                           value="{{ $zipcode['zipcode'] }}" id="zipcode_{{ $zipcode['id'] }}"
                                           readonly/>
                                </td>
                                <td class="text-center">
                                    <div class="input-group w-5r m-auto">
                                        <span class="input-group-text" id="basic-addon1">€</span>
                                        <input type="number" class="form-control m-auto"
                                               value="{{ $zipcode['min_order_price'] }}"
                                               id="min_order_price_{{ $zipcode['id'] }}" readonly/>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="input-group w-5r m-auto">
                                        <span class="input-group-text" id="basic-addon1">€</span>
                                        <input type="number" class="form-control m-auto"
                                               value="{{ $zipcode['delivery_charge'] }}"
                                               id="delivery_charge_{{ $zipcode['id'] }}" readonly/>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-switch custom-switch justify-content-center ps-0">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                               id="status_{{ $zipcode['id'] }}"
                                               {{ $zipcode["status"] ? "checked":"" }} onchange="changeStatus({{ $zipcode['id'] }})">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-custom-yellow btn-icon me-2" tabindex="0"
                                       href="javascript:void(0);" id="zipcode-edit-btn-{{ $zipcode['id'] }}"
                                       onclick="editZipcode({{ $zipcode['id'] }})">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a class="btn btn-custom-yellow btn-icon"
                                       id="zipcode-remove-btn-{{ $zipcode['id'] }}"
                                       onclick="deleteZipcode({{ $zipcode['id'] }})">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>

                                    <button type="button"
                                            class="btn btn-custom-yellow text-uppercase font-sebibold w-100"
                                            id="zipcode-save-btn-{{ $zipcode['id'] }}" style="display: none;"
                                            onclick="saveZipcode({{ $zipcode['id'] }})">Save
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="d-flex justify-content-between align-items-center" style="padding: 0 20px 0 20px;">
                {{ $zipcodes->links() }}
                <div>
                    <label>Rows per Page</label>
                    <select id="per_page_dropdown" onchange="">
                        <option
                            {{ $perPage == 5 ? 'selected' : '' }} value="{{ Request::url().'?per_page=5' }}">
                            5
                        </option>
                        <option
                            {{ $perPage == 10 ? 'selected' : '' }} value="{{ Request::url().'?per_page=10' }}">
                            10
                        </option>
                        <option
                            {{ $perPage == 15 ? 'selected' : '' }} value="{{ Request::url().'?per_page=15' }}">
                            15
                        </option>
                        <option
                            {{ $perPage == 20 ? 'selected' : '' }} value="{{ Request::url().'?per_page=20' }}">
                            20
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade custom-modal" id="deleteZipcodeModal" tabindex="-1" aria-labelledby="dleteAlertModal"
     aria-hidden="true">
    <div class="modal-dialog custom-w-441px modal-dialog-centered">
        <div>
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="alert-text-1 mb-40px">Are you sure you want to delete this zipcode?</h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button"
                                class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px"
                                data-bs-dismiss="modal">Cancel
                        </button>
                        <button type="button" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-160px"
                                id="zipcode-delete-btn">Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
