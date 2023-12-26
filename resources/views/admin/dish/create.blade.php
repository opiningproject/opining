@extends('layouts.app')

@section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.admin.side_nav_bar')

                <main class="w-100">
                    <div class="main-content">
                        <div class="section-page-title main-page-title mb-0">
                            <div class="">
                                <h1 class="page-title">Add Dish</h1>
                            </div>
                        </div>

                        <!-- start edit dish card section -->
                        <section class="custom-section">
                            <div class="card editdish-card">
                                <form id="addDishForm" method="POST" action="{{ route('dish.store') }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-header border-0 bg-white border-bottom-0">
                                        <div class="row">
                                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                <nav class="page-breadcrumb" aria-label="breadcrumb">
                                                    <ol class="breadcrumb">
                                                        <li class="breadcrumb-item"><a
                                                                href="{{ route('home') }}">Menu</a></li>
                                                        <li class="breadcrumb-item active">Add Dish</li>
                                                    </ol>
                                                </nav>
                                            </div>
                                            <div
                                                class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 text-end float-end">
                                                <div class="form-group mb-0 mt-2">
                                                    <div
                                                        class="form-check form-switch custom-switch d-flex align-items-center justify-content-end ps-0">
                                                        <label class="form-check-label form-label mb-0 me-2"
                                                               for="outofstock">Out
                                                            of
                                                            stock</label>
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                               name="out_of_stock"
                                                               id="outofstock" value="1">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body py-0">
                                        <div class="row">
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="form-group imageupload-box inline-imageupload-box">
                                                    <label for="dishimage" class="form-label">Dish Image</label>
                                                    <label for="input-file" class="upload-file justify-content-center">
                                                        <img src="{{ asset('images/blank-img.svg')}}" alt="blank image"
                                                             class="img-fluid" id="img-preview">
                                                        <p class="mb-0" id="img-label">Upload Image of Item</p>
                                                    </label>
                                                    <input type="file" id="input-file" name="image" class="d-none">
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="dishnameenglish" class="form-label">Dish Name <span
                                                            class="text-custom-muted">(English)</span></label>
                                                    <input type="text" class="form-control" name="name_en" maxlength="250"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="dishnamedutch" class="form-label">Dish Name <span
                                                            class="text-custom-muted">(Dutch)</span></label>
                                                    <input type="text" class="form-control" name="name_nl" maxlength="250"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="form-group ">
                                                    <label for="dishcategory" class="form-label">Dish Category <span
                                                            class="text-custom-muted">(English)</span></label>
                                                    <select class="form-control w-100"
                                                            type="button" name="category_id">
                                                        <option value="">Select Category</option>
                                                        @foreach($categories as $category)
                                                            <option
                                                                value="{{ $category->id }}">{{$category->name_en}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="discountpercentage" class="form-label">Discount
                                                        Percentage</label>
                                                    <input type="number" class="form-control" name="percentage_off" min="1" max="100"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="quantity" class="form-label">Quantity</label>
                                                    <input type="number" class="form-control" name="qty"  min="0"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="dishprice" class="form-label">Dish Price</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="basic-addon1">€</span>
                                                        <input type="number" class="form-control" name="price" min="0"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="discountpercentage" class="form-label">Dish description
                                                        <span class="text-custom-muted">(English)</span></label>
                                                    <input type="text" class="form-control" name="desc_en"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="discountpercentage" class="form-label">Dish description
                                                        <span class="text-custom-muted">(Dutch)</span></label>
                                                    <input type="text" class="form-control" name="desc_nl"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <button type="submit"
                                                        class="btn btn-custom-yellow btn-default d-block w-130px mt-3">
                                                    <span class="align-middle">Add</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </section>
                        <!-- end edit dish card section -->
                    </div>
                </main>
            </div>
        </div>
        <!-- start footer -->
        @include('layouts.admin.footer_design')
        <!-- end footer -->
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js/dish.js')}}"></script>
@endsection
