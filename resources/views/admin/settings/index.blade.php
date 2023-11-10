@extends('layouts.app')

@section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout bg-light">
                @include('layouts.admin.side_nav_bar')

                <main class=" order-1 w-100">
                    <div class="main-content">
                        <div class="section-page-title mb-0">
                            <h1 class="page-title">Settings</h1>
                            <div class="form-group mb-0">
                                <div
                                    class="form-check form-switch custom-switch dark-theme-switch d-flex align-items-center justify-content-between ps-0">
                                    <label class="form-check-label form-label mb-0 text-muted-default"
                                           for="darkSwitch">Dark Theme</label>
                                    <input class="form-check-input" type="checkbox" role="switch" id="darkSwitch">
                                </div>
                            </div>
                        </div>

                        <!-- start Setting section -->
                        <section class=" custom-section">
                            <div class="customize-tab setting-tab">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="restaurantProfile-tab" data-bs-toggle="tab"
                                                data-bs-target="#restaurantProfile-tab-pane" type="button" role="tab"
                                                aria-controls="restaurantProfile-tab-pane" aria-selected="true">
                                            Restaurant
                                            Profile
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="paymentHistory-tab" data-bs-toggle="tab"
                                                data-bs-target="#paymentHistory-tab-pane" type="button" role="tab"
                                                aria-controls="paymentHistory-tab-pane" aria-selected="false">Payment
                                            History
                                        </button>
                                    </li>
                                    <li class="nav-item " role="presentation">
                                        <button class="nav-link" id="cmsPagesen-tab" data-bs-toggle="tab"
                                                data-bs-target="#cmsPagesen-tab-pane" type="button" role="tab"
                                                aria-controls="cmsPagesen-tab-pane" aria-selected="false">CMS
                                            Pages(English)
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="cmsPagesdutch-tab" data-bs-toggle="tab"
                                                data-bs-target="#cmsPagesdutch-tab-pane" type="button" role="tab"
                                                aria-controls="cmsPagesdutch-tab-pane" aria-selected="false">CMS
                                            Pages(dutch)
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="refundPayment-tab" data-bs-toggle="tab"
                                                data-bs-target="#refundPayment-tab-pane" type="button" role="tab"
                                                aria-controls="refundPayment-tab-pane" aria-selected="false">Refund
                                            Payment
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="zipCode-tab" data-bs-toggle="tab"
                                                data-bs-target="#zipCode-tab-pane" type="button" role="tab"
                                                aria-controls="zipCode-tab-pane" aria-selected="false">Zip Code
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content card editdish-card setting-tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="restaurantProfile-tab-pane"
                                         role="tabpanel" aria-labelledby="restaurantProfile-tab" tabindex="0">
                                        <div class="card-body">
                                            <nav class="page-breadcrumb" aria-label="breadcrumb">
                                                <ol class="breadcrumb">
                                                    <li class="breadcrumb-item"><a href="#">Settings</a></li>
                                                    <li class="breadcrumb-item"><a href="#">Restaurant Profile</a></li>
                                                    <li class="breadcrumb-item active">Edit Restaurant Profile</li>
                                                </ol>
                                            </nav>
                                            <div class="card-custom-body">
                                                <div class="row">
                                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label for="restaurantname" class="form-label">Restaurant
                                                                Name</label>
                                                            <input type="text" class="form-control" value="Barbacue"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label for="restaurantpermit" class="form-label">Restaurant
                                                                Permit
                                                                ID</label>
                                                            <input type="number" class="form-control" value="000000"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label for="restaurantpermit"
                                                                   class="form-label">Phone</label>
                                                            <div class="countrycode-phone-control position-relative">
                                                                <img src="images/netherlands-flag.svg"
                                                                     alt="netherlands Flag" class="img-fluid">
                                                                <input type="text" class="form-control" value="+31">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label for="ownername" class="form-label">Owner Name</label>
                                                            <input type="text" class="form-control"
                                                                   value="Jordan Nico"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="text" class="form-control"
                                                                   value="barbacue@gmail.com" readonly/>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label for="addressdetail" class="form-label">Address
                                                                Details</label>
                                                            <input type="text" class="form-control"
                                                                   value="Franklin Avenue Street New York, ABC 5562 testqqdq"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group ">
                                                            <label for="password" class="form-label">Password</label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control"
                                                                       value="12345678" readonly/>
                                                                <button
                                                                    class="input-group-btn btn btn-custom-yellow btn-icon h-50px"
                                                                    type="button" id="button-addon2"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#changePasswordModal"><i
                                                                        class="fa-solid fa-pen-to-square"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 my-auto">
                                                        <div class="form-group mb-0 mt-2">
                                                            <div
                                                                class="form-check form-switch custom-switch d-flex align-items-center justify-content-between ps-0">
                                                                <label class="form-check-label form-label mb-0">Online
                                                                    Order
                                                                    Acceptance</label>
                                                                <label
                                                                    class="text-yellow-2 float-end form-label mb-0 text-end">Active</label>
                                                                <!-- switch online order Acceptance -->
                                                                <!-- <input class="form-check-input" type="checkbox" role="switch" checked> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label for="servicecharge" class="form-label">Restaurant
                                                                Logo</label>
                                                            <div class="logowithtext-box">
                                                                <img src="images/restaurantlogo-img.svg"
                                                                     alt="Restaurant Logo" class="img-fluid"/>
                                                                <span class="lead-3 text-custom-muted">Lorem
                                                                    Ipsum.png</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label for="servicecharge" class="form-label">Company Permit
                                                                Document</label>
                                                            <div class="logowithtext-box">
                                                                <img src="images/restaurantlogo-img.svg"
                                                                     alt="Restaurant Logo" class="img-fluid"/>
                                                                <span class="lead-3 text-custom-muted">Lorem
                                                                    Ipsum.png</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label for="servicecharge" class="form-label">service
                                                                charge</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text"
                                                                      id="basic-addon1">€</span>
                                                                <input type="number" class="form-control" value="05"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                        <div class="form-group mb-0">
                                                            <label for="servicecharge" class="form-label">Restaurant
                                                                Opening
                                                                Hours</label>

                                                            <div
                                                                class="schedule-table bg-lightgray border-custom-1 rounded-custom-12">

                                                                <table class="table table-borderless mb-0">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>Monday</td>
                                                                        <td>
                                                                            <div class="time-day-name">
                                                                                <div class="form-group mb-0">
                                                                                    <input type="text"
                                                                                           class="timepicker form-control time-form-control"
                                                                                           value="12:00"/>
                                                                                </div>
                                                                                -
                                                                                <div class="form-group mb-0">
                                                                                    <input type="text"
                                                                                           class="timepicker form-control time-form-control"
                                                                                           value="22:00"/>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>Friday</td>
                                                                        <td class="text-end">
                                                                            <div class="time-day-name">
                                                                                <div class="form-group mb-0">
                                                                                    <input type="text"
                                                                                           class="timepicker form-control time-form-control"
                                                                                           value="12:00"/>
                                                                                </div>
                                                                                -
                                                                                <div class="form-group mb-0">
                                                                                    <input type="text"
                                                                                           class="timepicker form-control time-form-control"
                                                                                           value="22:00"/>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Tuesday</td>
                                                                        <td>
                                                                            <div class="time-day-name">
                                                                                <div class="form-group mb-0">
                                                                                    <input type="text"
                                                                                           class="timepicker form-control time-form-control"
                                                                                           value="12:00"/>
                                                                                </div>
                                                                                -
                                                                                <div class="form-group mb-0">
                                                                                    <input type="text"
                                                                                           class="timepicker form-control time-form-control"
                                                                                           value="22:00"/>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>Saturday</td>
                                                                        <td class="text-end">
                                                                            <div class="time-day-name">
                                                                                <div class="form-group mb-0">
                                                                                    <input type="text"
                                                                                           class="timepicker form-control time-form-control"
                                                                                           value="12:00"/>
                                                                                </div>
                                                                                -
                                                                                <div class="form-group mb-0">
                                                                                    <input type="text"
                                                                                           class="timepicker form-control time-form-control"
                                                                                           value="22:00"/>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Wednesday</td>
                                                                        <td>
                                                                            <div class="time-day-name">
                                                                                <div class="form-group mb-0">
                                                                                    <input type="text"
                                                                                           class="timepicker form-control time-form-control"
                                                                                           value="12:00"/>
                                                                                </div>
                                                                                -
                                                                                <div class="form-group mb-0">
                                                                                    <input type="text"
                                                                                           class="timepicker form-control time-form-control"
                                                                                           value="22:00"/>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>Sunday</td>
                                                                        <td class="text-end">
                                                                            <div class="time-day-name">
                                                                                <div class="form-group mb-0">
                                                                                    <input type="text"
                                                                                           class="timepicker form-control time-form-control"
                                                                                           value="12:00"/>
                                                                                </div>
                                                                                -
                                                                                <div class="form-group mb-0">
                                                                                    <input type="text"
                                                                                           class="timepicker form-control time-form-control"
                                                                                           value="22:00"/>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="pb-0">Thursday</td>
                                                                        <td class="pb-0">
                                                                            <div class="time-day-name">
                                                                                <div class="form-group mb-0">
                                                                                    <input type="text"
                                                                                           class="timepicker form-control time-form-control"
                                                                                           value="12:00"/>
                                                                                </div>
                                                                                -
                                                                                <div class="form-group mb-0">
                                                                                    <input type="text"
                                                                                           class="timepicker form-control time-form-control"
                                                                                           value="22:00"/>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td></td>
                                                                        <td class="text-end pb-0">
                                                                            <div class="time-day-name">

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
                                        </div>
                                        <div class="card-footer bg-white border-0">
                                            <div class="row">
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                    <a class="btn btn-outline-custom-yellow btn-default d-block">
                                                        <span class="align-middle">Cancel</span>
                                                    </a>
                                                </div>
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                    <a class="btn btn-custom-yellow btn-default d-block">
                                                        <span class="align-middle">Save</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="paymentHistory-tab-pane" role="tabpanel"
                                         aria-labelledby="paymentHistory-tab" tabindex="0">
                                        <h2>Payment History Tab</h2>
                                    </div>
                                    <div class="tab-pane fade" id="cmsPagesen-tab-pane" role="tabpanel"
                                         aria-labelledby="cmsPagesen-tab" tabindex="0">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h3 class="text-custom-muted mb-0 tab-title">This is Privacy Policy page
                                                </h3>
                                                <div class="btn-group" role="group"
                                                     aria-label="Basic radio toggle button group">
                                                    <input type="radio" class="btn-check" name="btnradioenglish"
                                                           id="btnradio1" autocomplete="off" checked>
                                                    <label
                                                        class="btn btn-sm btn-outline-custom-yellow text-muted-default"
                                                        for="btnradio1">Privacy
                                                        Policy</label>

                                                    <input type="radio" class="btn-check" name="btnradioenglish"
                                                           id="btnradio2" autocomplete="off">
                                                    <label
                                                        class="btn btn-sm btn-outline-custom-yellow text-muted-default"
                                                        for="btnradio2">Terms & Condition</label>
                                                </div>
                                            </div>
                                            <div class="custom-editor-box">
                                                <textarea name="" id="editorcmdpagesen">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                    </textarea>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-0">
                                            <div class="row">
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                    <a class="btn btn-custom-yellow btn-default d-block">
                                                        <span class="align-middle">Save</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="cmsPagesdutch-tab-pane" role="tabpanel"
                                         aria-labelledby="cmsPagesdutch-tab" tabindex="0">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h3 class="text-custom-muted mb-0 tab-title">This is Privacy Policy page
                                                </h3>
                                                <div class="btn-group" role="group"
                                                     aria-label="Basic radio toggle button group">
                                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio3"
                                                           autocomplete="off" checked>
                                                    <label
                                                        class="btn btn-sm btn-outline-custom-yellow text-muted-default"
                                                        for="btnradio3">Privacy
                                                        Policy</label>

                                                    <input type="radio" class="btn-check" name="btnradio" id="btnradio4"
                                                           autocomplete="off">
                                                    <label
                                                        class="btn btn-sm btn-outline-custom-yellow text-muted-default"
                                                        for="btnradio4">Terms & Condition</label>
                                                </div>
                                            </div>
                                            <div class="custom-editor-box">
                                                <textarea name="" id="editorcmdpagesdutch">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                    </textarea>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-0">
                                            <div class="row">
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                    <a class="btn btn-custom-yellow btn-default d-block">
                                                        <span class="align-middle">Save</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="refundPayment-tab-pane" role="tabpanel"
                                         aria-labelledby="refundPayment-tab" tabindex="0">
                                        <h2>Refund Payment</h2>
                                    </div>
                                    <div class="tab-pane fade" id="zipCode-tab-pane" role="tabpanel"
                                         aria-labelledby="zipCode-tab" tabindex="0">
                                        <div class="card-body">
                                            <div class="zipcode-card-body rounded-custom-12 border-custom-1 py-3">
                                                <div class="zipcode-table custom-table">
                                                    <table class="table mb-0">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col" class="text-center">Zip Code</th>
                                                            <th scope="col" class="text-center">Minimum Order Price
                                                            </th>
                                                            <th scope="col" class="text-center">Delivery Charges
                                                            </th>
                                                            <th scope="col" class="text-center" width="20%">Status
                                                            </th>
                                                            <th scope="col" class="text-center" width="13%">Action
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td><input type="number"
                                                                       class="form-control text-center w-10r m-auto"
                                                                       value="3950012"/>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-group w-5r m-auto">
                                                                        <span class="input-group-text"
                                                                              id="basic-addon1">€</span>
                                                                    <input type="number" class="form-control m-auto"
                                                                           value="25"/>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-group w-5r m-auto">
                                                                        <span class="input-group-text"
                                                                              id="basic-addon1">€</span>
                                                                    <input type="number" class="form-control m-auto"
                                                                           value="05"/>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div
                                                                    class="form-check form-switch custom-switch justify-content-center ps-0">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           role="switch">
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <a
                                                                    class="btn btn-custom-yellow btn-default d-block">
                                                                    <span class="align-middle">Edit</span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="number"
                                                                       class="form-control text-center w-10r m-auto"
                                                                       value="3950009" readonly/>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-group w-5r m-auto">
                                                                        <span class="input-group-text"
                                                                              id="basic-addon1">€</span>
                                                                    <input type="number" class="form-control m-auto"
                                                                           value="25" readonly/>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-group w-5r m-auto">
                                                                        <span class="input-group-text"
                                                                              id="basic-addon1">€</span>
                                                                    <input type="number" class="form-control m-auto"
                                                                           value="05" readonly/>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div
                                                                    class="form-check form-switch custom-switch justify-content-center ps-0">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           role="switch" checked>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <a
                                                                    class="btn btn-custom-yellow btn-default d-block">
                                                                    <span class="align-middle">Save</span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="number"
                                                                       class="form-control text-center w-10r m-auto"
                                                                       value="3950009" readonly/>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-group w-5r m-auto">
                                                                        <span class="input-group-text"
                                                                              id="basic-addon1">€</span>
                                                                    <input type="number" class="form-control m-auto"
                                                                           value="25" readonly/>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-group w-5r m-auto">
                                                                        <span class="input-group-text"
                                                                              id="basic-addon1">€</span>
                                                                    <input type="number" class="form-control m-auto"
                                                                           value="05" readonly/>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div
                                                                    class="form-check form-switch custom-switch justify-content-center ps-0">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           role="switch">
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <a class="btn btn-custom-yellow btn-icon me-2"
                                                                   tabindex="0" href="javascript:void(0);">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                                <a class="btn btn-custom-yellow btn-icon"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#deleteAlertModal">
                                                                    <i class="fa-regular fa-trash-can"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="number"
                                                                       class="form-control text-center w-10r m-auto"
                                                                       value="3950009" readonly/>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-group w-5r m-auto">
                                                                        <span class="input-group-text"
                                                                              id="basic-addon1">€</span>
                                                                    <input type="number" class="form-control m-auto"
                                                                           value="25" readonly/>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-group w-5r m-auto">
                                                                        <span class="input-group-text"
                                                                              id="basic-addon1">€</span>
                                                                    <input type="number" class="form-control m-auto"
                                                                           value="05" readonly/>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div
                                                                    class="form-check form-switch custom-switch justify-content-center ps-0">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           role="switch" checked>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <a class="btn btn-custom-yellow btn-icon me-2"
                                                                   tabindex="0" href="javascript:void(0);">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                                <a class="btn btn-custom-yellow btn-icon"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#deleteAlertModal">
                                                                    <i class="fa-regular fa-trash-can"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="number"
                                                                       class="form-control text-center w-10r m-auto"
                                                                       value="3950009" readonly/>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-group w-5r m-auto">
                                                                        <span class="input-group-text"
                                                                              id="basic-addon1">€</span>
                                                                    <input type="number" class="form-control m-auto"
                                                                           value="25" readonly/>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-group w-5r m-auto">
                                                                        <span class="input-group-text"
                                                                              id="basic-addon1">€</span>
                                                                    <input type="number" class="form-control m-auto"
                                                                           value="05" readonly/>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div
                                                                    class="form-check form-switch custom-switch justify-content-center ps-0">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           role="switch">
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <a class="btn btn-custom-yellow btn-icon me-2"
                                                                   tabindex="0" href="javascript:void(0);">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                                <a class="btn btn-custom-yellow btn-icon"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#deleteAlertModal">
                                                                    <i class="fa-regular fa-trash-can"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="number"
                                                                       class="form-control text-center w-10r m-auto"
                                                                       value="3950009" readonly/>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-group w-5r m-auto">
                                                                        <span class="input-group-text"
                                                                              id="basic-addon1">€</span>
                                                                    <input type="number" class="form-control m-auto"
                                                                           value="25" readonly/>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-group w-5r m-auto">
                                                                        <span class="input-group-text"
                                                                              id="basic-addon1">€</span>
                                                                    <input type="number" class="form-control m-auto"
                                                                           value="05" readonly/>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div
                                                                    class="form-check form-switch custom-switch justify-content-center ps-0">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           role="switch" checked>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <a class="btn btn-custom-yellow btn-icon me-2"
                                                                   tabindex="0" href="javascript:void(0);">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                                <a class="btn btn-custom-yellow btn-icon"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#deleteAlertModal">
                                                                    <i class="fa-regular fa-trash-can"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="number"
                                                                       class="form-control text-center w-10r m-auto"
                                                                       value="3950009" readonly/>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-group w-5r m-auto">
                                                                        <span class="input-group-text"
                                                                              id="basic-addon1">€</span>
                                                                    <input type="number" class="form-control m-auto"
                                                                           value="25" readonly/>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-group w-5r m-auto">
                                                                        <span class="input-group-text"
                                                                              id="basic-addon1">€</span>
                                                                    <input type="number" class="form-control m-auto"
                                                                           value="05" readonly/>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div
                                                                    class="form-check form-switch custom-switch justify-content-center ps-0">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           role="switch" checked>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <a class="btn btn-custom-yellow btn-icon me-2"
                                                                   tabindex="0" href="javascript:void(0);">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                                <a class="btn btn-custom-yellow btn-icon"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#deleteAlertModal">
                                                                    <i class="fa-regular fa-trash-can"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><input type="number"
                                                                       class="form-control text-center w-10r m-auto"
                                                                       value="3950012" readonly/>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-group w-5r m-auto">
                                                                        <span class="input-group-text"
                                                                              id="basic-addon1">€</span>
                                                                    <input type="number" class="form-control m-auto"
                                                                           value="25" readonly/>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="input-group w-5r m-auto">
                                                                        <span class="input-group-text"
                                                                              id="basic-addon1">€</span>
                                                                    <input type="number" class="form-control m-auto"
                                                                           value="05" readonly/>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div
                                                                    class="form-check form-switch custom-switch justify-content-center ps-0">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           role="switch" checked>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <a class="btn btn-custom-yellow btn-icon me-2"
                                                                   tabindex="0" href="javascript:void(0);">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                                <a class="btn btn-custom-yellow btn-icon"
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#deleteAlertModal">
                                                                    <i class="fa-regular fa-trash-can"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- end Setting section -->
                    </div>
                </main>
            </div>
        </div>
    </div>


    <!-- start change password Modal -->
    <div class="modal fade custom-modal" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModal"
         aria-hidden="true">
        <div class="modal-dialog custom-w-441px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h1 class="modal-title mb-0">Change Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <form>
                        <div class="form-group">
                            <label for="newpassword" class="form-label">Old Password</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="newpassword" class="form-label">New Password</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group mb-0">
                            <label for="newpassword" class="form-label">Confirm New Password</label>
                            <input type="text" class="form-control">
                        </div>
                        <button type="button"
                                class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 mt-30px">Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end change password  Modal -->
@endsection


@section('script')
    <script type="text/javascript">
        $('.timepicker').timepicker({
            timeFormat: 'h:mm',
            interval: 60,
            minTime: '10',
            maxTime: '6:00pm',
            defaultTime: '11',
            startTime: '10:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

        CKEDITOR.replace('editorcmdpagesen', {
            skin: 'moono',
            height: '40vh',
            enterMode: CKEDITOR.ENTER_BR,
            shiftEnterMode: CKEDITOR.ENTER_P,
            toolbar: [{ name: 'basicstyles', groups: ['basicstyles'], items: ['Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor'] },
                { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                { name: 'scripts', items: ['Subscript', 'Superscript'] },
                { name: 'justify', groups: ['blocks', 'align'], items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                { name: 'paragraph', groups: ['list', 'indent'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
                { name: 'links', items: ['Link', 'Unlink'] },
                { name: 'insert', items: ['Image'] },
                { name: 'spell', items: ['jQuerySpellChecker'] },
                { name: 'table', items: ['Table'] }
            ],
        });
        CKEDITOR.replace('editorcmdpagesdutch', {
            skin: 'moono',
            height: '40vh',
            enterMode: CKEDITOR.ENTER_BR,
            shiftEnterMode: CKEDITOR.ENTER_P,
            toolbar: [{ name: 'basicstyles', groups: ['basicstyles'], items: ['Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor'] },
                { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                { name: 'scripts', items: ['Subscript', 'Superscript'] },
                { name: 'justify', groups: ['blocks', 'align'], items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                { name: 'paragraph', groups: ['list', 'indent'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
                { name: 'links', items: ['Link', 'Unlink'] },
                { name: 'insert', items: ['Image'] },
                { name: 'spell', items: ['jQuerySpellChecker'] },
                { name: 'table', items: ['Table'] }
            ],
        });

    </script>
@endsection
