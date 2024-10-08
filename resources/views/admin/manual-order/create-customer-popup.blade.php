<div class="modal fade custom-modal create-customer-popup" id="createCustomerModal" tabindex="-1" aria-labelledby="createCustomerModal"  aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                Create Customer

                <button type="button" aria-label="Close" class="close">

                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <line x1="11.6637" y1="12.37" x2="0.663664" y2="2.36997" stroke="black" />
                        <path d="M11 2L0.884616 12.4231" stroke="black" />
                    </svg>

                </button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="row g-2">
                        <div class="col-md-6 mt-0">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" />
                            </div>
                        </div>

                        <div class="col-md-6 mt-0">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" />
                            </div>
                        </div>

                        <div class="col-md-12 mt-0">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="text" class="form-control" />
                            </div>
                        </div>

                        <div class="col-md-12 mt-0">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input check-input-secondary me-2" type="checkbox"
                                        id="marketing" checked />
                                    <label class="form-check-label text-capitalize align-middle pt-1"
                                        for="marketing">Customer accepts e-mail marketing</label>
                                </div>
                            </div>
                        </div>

                        <hr />

                        <h3>Shipping Address</h3>

                        <div class="col-md-12 mt-0">
                            <div class="form-group">
                                <label>Company</label>
                                <input type="text" class="form-control" />
                            </div>
                        </div>

                        <div class="col-md-12 mt-0">
                            <div class="form-group">
                                <label>Street and House Number</label>
                                <input type="text" class="form-control" />
                            </div>
                        </div>

                        <div class="col-md-6 mt-0">
                            <div class="form-group">
                                <label>Postal code</label>
                                <input type="text" class="form-control" />
                            </div>
                        </div>

                        <div class="col-md-6 mt-0">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" class="form-control" />
                            </div>
                        </div>



                    </div>

                    <div class="row g-2">
                        <div class="col-12">
                            <label>Phone</label>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" />
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="form-group">
                                <input type="text" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <hr />

                    <h3>Billing Adress</h3>

                    <div class="row g-2">
                        <div class="form-group">
                            <div class="col-md-12 mt-0">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input check-input-secondary me-2" type="checkbox"
                                            id="address" checked />
                                        <label class="form-check-label text-capitalize align-middle pt-1"
                                            for="address">Same as shipping address</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" aria-label="Close" class="btn close">Cancel</button>
                <button type="button" class="btn btn-site-theme">Save Customer</button>
            </div>
        </div>
    </div>
</div>
