@extends('layouts.app')

@section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.admin.side_nav_bar')

                <main class="w-100">
                    <div class="main-content">
                        <div class="section-page-title main-page-title mb-0">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="">
                                        <h1 class="page-title">Menu</h1>
                                    </div>
                                </div>
                                <div class="col text-end">
                                    <div class="page-control">
                                        <div class="row justify-content-end align-items-center g-0">
                                            <div class="col-auto">
                                                <div class="form-group has-search position-relative searcheatbox mb-0">
                                                    <span class="form-control-feedback">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                             viewBox="0 0 32 32" fill="none">
                                                            <path
                                                                d="M23.5119 23.1552L19.281 18.9243C20.1552 17.6068 20.6668 16.0293 20.6668 14.3334C20.6668 9.73837 16.9285 6 12.3334 6C7.73837 6 4 9.73837 4 14.3334C4 18.9285 7.73837 22.6668 12.3334 22.6668C14.0293 22.6668 15.6068 22.1552 16.9243 21.281L21.1552 25.5119C21.8052 26.1627 22.8619 26.1627 23.5119 25.5119C24.1627 24.861 24.1627 23.806 23.5119 23.1552ZM6.50003 14.3334C6.50003 11.1167 9.11672 8.50003 12.3334 8.50003C15.5501 8.50003 18.1668 11.1167 18.1668 14.3334C18.1668 17.5501 15.5501 20.1668 12.3334 20.1668C9.11672 20.1668 6.50003 17.5501 6.50003 14.3334Z"
                                                                fill="#FFC00B"/>
                                                        </svg>
                                                    </span>
                                                    <input type="text" id="search-dish"
                                                           class="form-control text-transform-none"
                                                           placeholder="What do you want eat today..."/>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a class="btn btn-custom-yellow" data-bs-toggle="modal"
                                                   data-bs-target="#addCategoryModal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         viewBox="0 0 20 20" fill="none">
                                                        <circle cx="10" cy="10" r="10" fill="#292929"/>
                                                        <path
                                                            d="M11.0475 9.48672H14.7416V11.1306H11.0475V14.8616H9.4036V11.1306H5.71875V9.48672H9.4036V5.71875H11.0475V9.48672Z"
                                                            fill="#FFC00B"/>
                                                    </svg>
                                                    <span class="align-middle ms-3">Add New Category</span>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <a class="btn btn-custom-yellow"
                                                   href="{{ route('ingredients.index') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         viewBox="0 0 20 20" fill="none">
                                                        <circle cx="10" cy="10" r="10" fill="#292929"/>
                                                        <path
                                                            d="M11.0475 9.48672H14.7416V11.1306H11.0475V14.8616H9.4036V11.1306H5.71875V9.48672H9.4036V5.71875H11.0475V9.48672Z"
                                                            fill="#FFC00B"/>
                                                    </svg>
                                                    <span class="align-middle ms-3">Add New ingredients</span>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <a class="btn btn-custom-yellow" href="{{ route('addDish') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                         viewBox="0 0 20 20" fill="none">
                                                        <circle cx="10" cy="10" r="10" fill="#292929"/>
                                                        <path
                                                            d="M11.0475 9.48672H14.7416V11.1306H11.0475V14.8616H9.4036V11.1306H5.71875V9.48672H9.4036V5.71875H11.0475V9.48672Z"
                                                            fill="#FFC00B"/>
                                                    </svg>
                                                    <span class="align-middle ms-3">Add New Dish</span>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <div class="dropdown userlogin-dropdown custom-default-dropdown">
                                                    <button class="btn btn-light dropdown-toggle" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="images/user-img.png" alt="user image"
                                                             class="img-fluid">
                                                        <div class="d-inline-block text-start userdp-text">
                                                            <a href="javascript:void(0);"
                                                               class="text-yellow-2 d-block">{{Auth::user()->name}}</a>
                                                            <span>{{Auth::user()->email}}</span>
                                                        </div>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                                {{ __('Logout') }}
                                                            </a>

                                                            <form id="logout-form" action="{{ route('logout') }}"
                                                                  method="POST" class="d-none">
                                                                @csrf
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <!-- start category section -->
                        <section class=" custom-section category-section">
                            <div class="section-page-title">
                                <h1 class="section-title">Categories</h1>
                            </div>
                            <div class="swiper-container">
                                <div class="swiper category-swiper-slider">
                                    <div class="category-slider swiper-wrapper">
                                        @foreach ($categories as $category)
                                            <div class="category-element swiper-slide">
                                                <div class="card">
                                                <span class="dish-item-icon">
                                                    <img src="{{ $category->image }}" class="img-fluid" alt="bakery" style="height: 60px !important;">
                                                </span>
                                                    <p class="mb-0 category-item-name text-truncate w-100" title="{{ $category->name }}">{{ $category->name }}</p>
                                                    <div class="categoryfood-detail-card-btn">
                                                        <a class="btn btn-custom-yellow btn-icon category-edit-btn"
                                                           data-id="{{ $category->id }}" data-bs-toggle="modal"
                                                           data-bs-target="#editCategoryModel">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <a class="btn btn-custom-yellow btn-icon del-cat-icon"
                                                           data-bs-toggle="modal" data-id="{{ $category->id }}"
                                                           data-bs-target="#deleteCategoryAlertModal">
                                                            <i class="fa-regular fa-trash-can"></i>
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- end category section -->

                        <!-- start dishes list section -->
                        <section class="custom-section">
                            <div class="section-page-title">
                                <h1 class="section-title">Dishes</h1>
                                <a href="{{ route('dish.index') }}" type="button" class="viewall-btn">View all
                                    <span class="ms-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <g id="chevron-down">
                                                <path id="Vector"
                                                      d="M15.0002 11.9998C15.0009 12.1314 14.9757 12.2619 14.926 12.3837C14.8762 12.5056 14.8029 12.6164 14.7102 12.7098L10.7102 16.7098C10.5219 16.8981 10.2665 17.0039 10.0002 17.0039C9.73388 17.0039 9.47849 16.8981 9.29018 16.7098C9.10188 16.5215 8.99609 16.2661 8.99609 15.9998C8.99609 15.7335 9.10188 15.4781 9.29018 15.2898L12.5902 11.9998L9.30018 8.70982C9.13636 8.51851 9.05075 8.27244 9.06047 8.02076C9.07019 7.76909 9.17453 7.53035 9.35262 7.35225C9.53072 7.17416 9.76945 7.06983 10.0211 7.06011C10.2728 7.05038 10.5189 7.13599 10.7102 7.29982L14.7102 11.2998C14.8949 11.4861 14.9991 11.7375 15.0002 11.9998Z"
                                                      fill="#292929"/>
                                            </g>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                            <div class=" dish-details-div">
                                <div class="popular-item-grid">
                                    @foreach ($dishes as $dish)
                                        <div class="card food-detail-card">
                                            @if($dish->out_of_stock == '1')
                                                <p class="mb-0 inoutstock-badge text-bg-danger-1">Out of stock</p>
                                            @else
                                                <p class="mb-0 inoutstock-badge text-bg-success-1">In stock</p>
                                            @endif
                                            <div class="card-body p-0">
                                                <p class="quantity-text badge">Qty:{{ $dish->qty }}</p>
                                                <div class="food-image">
                                                    <img src="{{ $dish->image }}" alt="burger imag" class="img-fluid" style="height: 60px !important;"/>
                                                </div>
                                                <h4 class="food-name-text text-truncate w-100" title="{{ $dish->name }}">{{ $dish->name }}</h4>
                                                <p class="food-price">€{{ $dish->price }}</p>
                                                <div class="food-detail-card-btn">
                                                    <a href="{{ route('editDish', $dish->id) }}"
                                                       class="btn btn-custom-yellow btn-icon" data-id="{{ $dish->id }}">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <a class="btn btn-custom-yellow btn-icon del-dish-btn" data-bs-toggle="modal"
                                                       data-bs-target="#deleteDishAlertModal" data-id="{{ $dish->id }}">
                                                        <i class="fa-regular fa-trash-can"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                        <!-- end dishes list section -->


                        <!-- start Popluar item list section -->
                        <section class="custom-section ">
                            <div class="section-page-title">
                                <h1 class="section-title">Popular This Week</h1>
                                <a href="javascript:void(0);" type="button" class="viewall-btn">View all
                                    <span class="ms-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <g id="chevron-down">
                                                <path id="Vector"
                                                      d="M15.0002 11.9998C15.0009 12.1314 14.9757 12.2619 14.926 12.3837C14.8762 12.5056 14.8029 12.6164 14.7102 12.7098L10.7102 16.7098C10.5219 16.8981 10.2665 17.0039 10.0002 17.0039C9.73388 17.0039 9.47849 16.8981 9.29018 16.7098C9.10188 16.5215 8.99609 16.2661 8.99609 15.9998C8.99609 15.7335 9.10188 15.4781 9.29018 15.2898L12.5902 11.9998L9.30018 8.70982C9.13636 8.51851 9.05075 8.27244 9.06047 8.02076C9.07019 7.76909 9.17453 7.53035 9.35262 7.35225C9.53072 7.17416 9.76945 7.06983 10.0211 7.06011C10.2728 7.05038 10.5189 7.13599 10.7102 7.29982L14.7102 11.2998C14.8949 11.4861 14.9991 11.7375 15.0002 11.9998Z"
                                                      fill="#292929"/>
                                            </g>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                            <div class="bestselling-item-grid">
                                @foreach($popularDishes as $popularDish)
                                    <div class="card bestselling-detail-card">
                                        <div class="card-body p-0">
                                            <div class="food-image">
                                                <img src="{{ $popularDish->image }}" style="height: 60px !important;" alt="burger imag" class="img-fluid"/>
                                            </div>
                                            <div class="text-start">
                                                <h4 class="food-name-text text-start text-truncate w-100" title="{{ $popularDish->name }}">{{ $popularDish->name }}</h4>
                                                <p class="food-price d-inline-block">{{ $popularDish->price }}</p>
                                                <p
                                                    class="mb-0 sellingpercantage-count d-inline-flex align-items-center text-yellow-2">
                                                    +15%
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                                         viewBox="0 0 19 19" fill="none">
                                                        <path
                                                            d="M18.5 9.25C18.5 4.13167 14.3683 -1.80601e-07 9.25 -4.0433e-07C4.13167 -6.2806e-07 -1.80601e-07 4.13167 -4.0433e-07 9.25C-6.2806e-07 14.3683 4.13167 18.5 9.25 18.5C14.3683 18.5 18.5 14.3683 18.5 9.25ZM8.63333 13.0117L8.63333 7.33833L7.03 8.75667C6.66 9.065 6.16667 9.00333 5.85833 8.695C5.735 8.51 5.67333 8.325 5.67333 8.14C5.67333 7.89333 5.79667 7.64667 5.98167 7.52333L8.94167 4.93333C9.00333 4.87167 9.065 4.87167 9.12667 4.81C9.18833 4.81 9.18833 4.81 9.25 4.74833C9.31167 4.74833 9.31167 4.74833 9.37333 4.74833L9.435 4.74833C9.49667 4.74833 9.49667 4.74833 9.55833 4.74833L9.62 4.74833C9.68167 4.74833 9.68167 4.74833 9.74333 4.81C9.74333 4.81 9.805 4.81 9.805 4.87167L9.86667 4.93333C9.86667 4.93333 9.86667 4.93333 9.92833 4.995L12.5183 7.64667C12.8267 7.955 12.8267 8.51 12.5183 8.81833C12.21 9.12667 11.655 9.12667 11.3467 8.81833L10.175 7.585L10.175 13.0733C10.175 13.505 9.805 13.9367 9.31167 13.9367C9.00333 13.8133 8.63333 13.4433 8.63333 13.0117Z"
                                                            fill="#FFC00B"/>
                                                    </svg>
                                                </p>
                                                <p class="lead-1 mb-0">Sold 1k</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </section>
                        <!-- end Popluar item list section -->

                        <!-- start Best selling list section -->
                        <section class="custom-section">
                            <div class="section-page-title">
                                <h1 class="section-title">Best Seller</h1>
                                <a href="javascript:void(0);" type="button" class="viewall-btn">View all
                                    <span class="ms-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <g id="chevron-down">
                                                <path id="Vector"
                                                      d="M15.0002 11.9998C15.0009 12.1314 14.9757 12.2619 14.926 12.3837C14.8762 12.5056 14.8029 12.6164 14.7102 12.7098L10.7102 16.7098C10.5219 16.8981 10.2665 17.0039 10.0002 17.0039C9.73388 17.0039 9.47849 16.8981 9.29018 16.7098C9.10188 16.5215 8.99609 16.2661 8.99609 15.9998C8.99609 15.7335 9.10188 15.4781 9.29018 15.2898L12.5902 11.9998L9.30018 8.70982C9.13636 8.51851 9.05075 8.27244 9.06047 8.02076C9.07019 7.76909 9.17453 7.53035 9.35262 7.35225C9.53072 7.17416 9.76945 7.06983 10.0211 7.06011C10.2728 7.05038 10.5189 7.13599 10.7102 7.29982L14.7102 11.2998C14.8949 11.4861 14.9991 11.7375 15.0002 11.9998Z"
                                                      fill="#292929"/>
                                            </g>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                            <div class="bestselling-item-grid">
                                @foreach($bestSellerDishes as $bestSellerDish)
                                    <div class="card bestselling-detail-card">
                                        <div class="card-body p-0">
                                            <div class="food-image">
                                                <img src="{{ $bestSellerDish->image }}" style="height: 60px !important;" alt="burger imag" class="img-fluid"/>
                                            </div>
                                            <div class="text-start">
                                                <h4 class="food-name-text text-start text-truncate w-100" title="{{ $bestSellerDish->name }}">{{ $bestSellerDish->name }}</h4>
                                                <p class="food-price d-inline-block">{{ $bestSellerDish->price }}</p>
                                                <p
                                                    class="mb-0 sellingpercantage-count d-inline-flex align-items-center text-yellow-2">
                                                    +15%
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                                         viewBox="0 0 19 19" fill="none">
                                                        <path
                                                            d="M18.5 9.25C18.5 4.13167 14.3683 -1.80601e-07 9.25 -4.0433e-07C4.13167 -6.2806e-07 -1.80601e-07 4.13167 -4.0433e-07 9.25C-6.2806e-07 14.3683 4.13167 18.5 9.25 18.5C14.3683 18.5 18.5 14.3683 18.5 9.25ZM8.63333 13.0117L8.63333 7.33833L7.03 8.75667C6.66 9.065 6.16667 9.00333 5.85833 8.695C5.735 8.51 5.67333 8.325 5.67333 8.14C5.67333 7.89333 5.79667 7.64667 5.98167 7.52333L8.94167 4.93333C9.00333 4.87167 9.065 4.87167 9.12667 4.81C9.18833 4.81 9.18833 4.81 9.25 4.74833C9.31167 4.74833 9.31167 4.74833 9.37333 4.74833L9.435 4.74833C9.49667 4.74833 9.49667 4.74833 9.55833 4.74833L9.62 4.74833C9.68167 4.74833 9.68167 4.74833 9.74333 4.81C9.74333 4.81 9.805 4.81 9.805 4.87167L9.86667 4.93333C9.86667 4.93333 9.86667 4.93333 9.92833 4.995L12.5183 7.64667C12.8267 7.955 12.8267 8.51 12.5183 8.81833C12.21 9.12667 11.655 9.12667 11.3467 8.81833L10.175 7.585L10.175 13.0733C10.175 13.505 9.805 13.9367 9.31167 13.9367C9.00333 13.8133 8.63333 13.4433 8.63333 13.0117Z"
                                                            fill="#FFC00B"/>
                                                    </svg>
                                                </p>
                                                <p class="lead-1 mb-0">Sold 1k</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                        <!-- end Best selling list section -->
                    </div>
                </main>
            </div>
        </div>
        <!-- start footer -->
        @include('layouts.admin.footer_design')
        <!-- end footer -->
    </div>
    <!-- start add category Modal -->
    <div class="modal fade custom-modal" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModal"
         aria-hidden="true">
        <div class="modal-dialog custom-w-441px modal-dialog-centered">
            <div class="modal-content border-radius">
                <div class="modal-header border-0">
                    <h1 class="modal-title mb-0">Add Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <form method="POST" id="categoryForm" enctype="multipart/form-data">
                        <div class="imageupload-box">
                            <label for="input-file" class="upload-file">
                                <input type="file" id="input-file" name="image">
                                <img src="images/blank-img.svg" alt="blank image" id="img-preview"
                                     class="img-fluid mb-2">
                                <p class="mb-0" id="img-label">Please upload image of Category</p>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="dishnameenglish" class="form-label">Dish Category <span
                                    class="text-custom-muted">(English)</span></label>
                            <input type="text" name="name_en" id="name_en" class="form-control" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="dishnameenglish" class="form-label">Dish Category <span
                                    class="text-custom-muted">(Dutch)</span></label>
                            <input type="text" name="name_nl" id="name_nl" class="form-control" required>
                        </div>
                        <button type="submit"
                                class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 mt-30px font-18">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end add category  Modal -->

    <!-- start edit category Modal -->
    <div class="modal fade custom-modal" id="editCategoryModel" tabindex="-1" aria-labelledby="editCategoryModel"
         aria-hidden="true">
        <div class="modal-dialog custom-w-441px modal-dialog-centered">
            <div class="modal-content border-radius">
                <div class="modal-header border-0">
                    <h1 class="modal-title mb-0">Edit Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <form method="POST" id="editCategoryForm" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="editCatId">
                        <div class="imageupload-box">
                            <label for="edit-input-file" class="upload-file">
                                <input type="file" id="edit-input-file" name="image">
                                <img src="{{ asset('images/blank-img.svg')}}" alt="blank image" id="edit-img-preview" height="100px"
                                     class="img-fluid mb-2">
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="dishnameenglish" class="form-label">Dish Category <span
                                    class="text-custom-muted">(English)</span></label>
                            <input type="text" name="name_en" id="edit_name_en" class="form-control" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="dishnameenglish" class="form-label">Dish Category <span
                                    class="text-custom-muted">(Dutch)</span></label>
                            <input type="text" name="name_nl" id="edit_name_nl" class="form-control" required>
                        </div>
                        <button type="submit"
                                class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 mt-30px font-18">
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end edit category  Modal -->

    <!-- start delete category Modal -->
    <div class="modal fade custom-modal" id="deleteCategoryAlertModal" tabindex="-1"
         aria-labelledby="dleteAlertModal" aria-hidden="true">
        <div class="modal-dialog custom-w-441px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="hidden" value="" id="catId">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="alert-text-1 mb-40px">Are you sure you want to
                                delete this Category?</h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button"
                                class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px"
                                data-bs-dismiss="modal">Cancel
                        </button>
                        <button type="button" id="delete-category-btn"
                                class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-160px">Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end delete category Modal -->

    <!-- start delete dish Modal -->
    <div class="modal fade custom-modal" id="deleteDishAlertModal" tabindex="-1"
         aria-labelledby="deleteDishAlertModal" aria-hidden="true">
        <div class="modal-dialog custom-w-441px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="hidden" value="" id="dishId">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="alert-text-1 mb-40px">Are you sure you want to
                                delete this Dish?</h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button"
                                class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px"
                                data-bs-dismiss="modal">Cancel
                        </button>
                        <button type="button" id="delete-dish-btn"
                                class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-160px">Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end delete dish Modal -->

    {{--    </div>--}}
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/category.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/home.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/dish-home-operations.js')}}"></script>
@endsection
