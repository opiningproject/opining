<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Enums\RefundStatus;

?>

<div class="tab-pane fade plan-bill-tab" id="plansBills-tab-pane" role="tabpanel" aria-labelledby="plansBills-tab"
    tabindex="0">
    <h2 class="content-title">Plans and Bills</h2>


    <div class="plan-bills-section">
        <div class="row g-3">
            <!-- Current Plan Summary -->
            <div class="col-md-6">
                <div class="card p-3 h-100">
                    <div class="card-head d-flex justify-content-between align-items-center gap-1">
                        <h6 class="mb-0">Current Plan Summary</h6>
                        <button class="btn btn-site-theme">Upgrade</button>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex align-items-center justify-content-between details-row">
                            <p class="mb-1 d-flex flex-column"><label>Plan Name</label> Basic Plan</p>
                            <p class="mb-1 d-flex flex-column"><label>Billing Cycle</label> Monthly</p>
                            <p class="mb-1 d-flex flex-column"><label>Plan Cost</label> $29</p>
                        </div>
                        <p class="text-muted mt-3 mb-0"><span>Card rates from</span> 1.9% + $0.25 EUR | 2% extern
                            payment provider
                        </p>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="col-md-6">
                <div class="card p-3 h-100">
                    <div class="card-head d-flex justify-content-between align-items-center gap-1">
                        <h6 class="mb-0">Payment method</h6>
                        <button class="btn btn-site-theme">Change</button>
                    </div>
                    <div class="mt-3 d-flex align-items-center payment-method-box mb-2">
                        <div class="payment-icon">
                            <img src="https://img.icons8.com/color/48/000000/mastercard-logo.png" alt="Mastercard" />
                        </div>
                        <div class="ms-3">
                            <p class="mb-0">Mastercard ending in 7105</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoices Section -->
        <div class="card mt-4 p-0 table-card">
            <div class="table-header">
                <h6 class="mb-0">Invoices</h6>

                <div class="btn-group">
                    <button type="button" class="btn-dots" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-three-dots" viewBox="0 0 16 16">
                            <path
                                d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                        </svg>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end p-0 overflow-hidden">
                        <li><button class="dropdown-item" type="button">Action</button></li>
                        <li><button class="dropdown-item" type="button">Another action</button></li>
                        <li><button class="dropdown-item" type="button">Something else here</button></li>
                    </ul>
                </div>

            </div>


            <div class="card-table-body">

                <div class="table-responsive mt-0">
                    <table class="table table-borderless align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Invoice ID</th>
                                <th>Billing Date</th>
                                <th>Plan</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#23456</td>
                                <td>22 Jan 2023</td>
                                <td>Basic Plan</td>
                                <td>$29</td>
                                <td><span class="badge bg-success">Paid</span></td>
                                <td>
                                    <div class="tab-dropdown">
                                        <button type="button" class="btn-dots" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                <path
                                                    d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end p-0 overflow-hidden">
                                            <li><button class="dropdown-item" type="button">Action</button></li>
                                            <li><button class="dropdown-item" type="button">Another action</button>
                                            </li>
                                            <li><button class="dropdown-item" type="button">Something else
                                                    here</button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#23456</td>
                                <td>22 Jan 2023</td>
                                <td>Basic Plan</td>
                                <td>$29</td>
                                <td><span class="badge bg-success">Paid</span></td>
                                <td>
                                    <div class="tab-dropdown">
                                        <button type="button" class="btn-dots" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                <path
                                                    d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end p-0 overflow-hidden">
                                            <li><button class="dropdown-item" type="button">Action</button></li>
                                            <li><button class="dropdown-item" type="button">Another action</button>
                                            </li>
                                            <li><button class="dropdown-item" type="button">Something else
                                                    here</button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#23456</td>
                                <td>22 Jan 2023</td>
                                <td>Basic Plan</td>
                                <td>$29</td>
                                <td><span class="badge bg-success">Paid</span></td>
                                <td>
                                    <div class="tab-dropdown">
                                        <button type="button" class="btn-dots" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                <path
                                                    d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end p-0 overflow-hidden">
                                            <li><button class="dropdown-item" type="button">Action</button></li>
                                            <li><button class="dropdown-item" type="button">Another action</button>
                                            </li>
                                            <li><button class="dropdown-item" type="button">Something else
                                                    here</button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#23456</td>
                                <td>22 Jan 2023</td>
                                <td>Basic Plan</td>
                                <td>$29</td>
                                <td><span class="badge bg-success">Paid</span></td>
                                <td>
                                    <div class="tab-dropdown">
                                        <button type="button" class="btn-dots" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                                <path
                                                    d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end p-0 overflow-hidden">
                                            <li><button class="dropdown-item" type="button">Action</button></li>
                                            <li><button class="dropdown-item" type="button">Another action</button>
                                            </li>
                                            <li><button class="dropdown-item" type="button">Something else
                                                    here</button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
