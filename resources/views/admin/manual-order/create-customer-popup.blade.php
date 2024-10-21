<div class="modal fade create-customer-popup" id="createCustomerModal" tabindex="-1"
     aria-labelledby="createCustomerModal" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" id="create-user-form">
                @csrf
                <div class="modal-header">
                    Create Customer
                    <button type="button" aria-label="Close" class="close">
                        <svg width="12" height="14" viewBox="0 0 12 14" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <line x1="11.6637" y1="12.37" x2="0.663664" y2="2.36997" stroke="black"/>
                            <path d="M11 2L0.884616 12.4231" stroke="black"/>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-md-6 mt-0">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="first_name" id="first_name"/>
                            </div>
                        </div>

                        <div class="col-md-6 mt-0">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name"/>
                            </div>
                        </div>

                        <div class="col-md-12 mt-0">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="email" class="form-control" name="email" id="email"/>
                            </div>
                        </div>

                        <div class="col-md-12 mt-0">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input check-input-secondary me-2" type="checkbox"
                                           id="marketing" checked/>
                                    <label class="form-check-label text-capitalize align-middle pt-1"
                                           for="marketing">Customer accepts e-mail marketing</label>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <h3>Shipping Address</h3>

                        <div class="col-md-12 mt-0">
                            <div class="form-group">
                                <label>Company</label>
                                <input type="text" class="form-control" name="company" id="company"/>
                            </div>
                        </div>
                        <div class="col-md-6 mt-0">
                            <div class="form-group">
                                <label>Street</label>
                                <input type="text" class="form-control" name="street" id="street"/>
                            </div>
                        </div>

                        <div class="col-md-6 mt-0">
                            <div class="form-group">
                                <label>House Number</label>
                                <input type="text" class="form-control house_number" name="house_number" id="house_number"/>
                            </div>
                        </div>

                        <div class="col-md-6 mt-0">
                            <div class="form-group">
                                <label>Postal code</label>
                                <input type="text" class="form-control" name="postal_code" id="postal_code"/>
                            </div>
                        </div>

                        <div class="col-md-6 mt-0">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" class="form-control" name="city" id="city"/>
                            </div>
                        </div>
                        <div class="col-md-12 mt-0">
{{--                            <div class="row">--}}
                            <div class="row form-group">
                                <label>Phone</label>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control text-center" value="+31" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="phone" id="phone"/>
                                    </div>
                                </div>
                            </div>
{{--                            </div>--}}
                        </div>
                    </div>
                    <hr/>

                    <h3>Billing Address</h3>

                    <div class="row g-2">
                        <div class="form-group">
                            <div class="col-md-12 mt-0">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input check-input-secondary me-2" type="checkbox"
                                               id="address" checked/>
                                        <label class="form-check-label text-capitalize align-middle pt-1"
                                               for="address">Same as shipping address</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" aria-label="Close" class="btn close">Cancel</button>
                    <button type="submit" class="btn btn-site-theme">Save Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>
