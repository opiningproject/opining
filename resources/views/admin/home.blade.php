@extends('layouts.app') @section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.admin.side_nav_bar')
                <main class="w-100">
                    <div class="main-content">
                        <div class="section-page-title main-page-title mb-0">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="pt-2">
                                        <h1 class="page-title">{{ trans('rest.menu.title') }}</h1>
                                    </div>
                                </div>
                                <div class="col text-end">
                                    <div class="page-control">
                                        <div class="d-flex flex-wrap gap-3 justify-content-end align-items-center">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="d-flex align-items-center form-control bg-white border-0 h-100 new-searchbar">
                                                    <div class="image">
                                                        <img src="{{ asset('images/search-icon-up.svg') }}" alt="" class="svg"
                                                             height="18" width="18">
                                                    </div>
                                                    <input type="text" id="search-dish"
                                                           class="form-control border-0 outline-0 text-truncate bg-transparent"
                                                           placeholder="{{ trans('rest.menu.search') }}"/>
                                                </div>
                                            </div>
                                            {{-- cr aug --}}
                                            <div class="flex-shrink-0">
                                                <a class="btn btn-site-theme"
                                                   href="{{ route('dish-option.index') }}">
                                                    <img src="{{ asset('images/add-up-white.svg') }}" alt="" class="svg"
                                                         height="20" width="20">
                                                    <span
                                                        class="align-middle ms-1">{{ trans('rest.menu.dish_options') }}</span>
                                                </a>
                                            </div>
                                            {{-- cr aug --}}
                                            <div class="flex-shrink-0">
                                                <a class="btn btn-site-theme" data-bs-toggle="modal"
                                                   data-bs-target="#addCategoryModal">
                                                    <img src="{{ asset('images/add-up-white.svg') }}" alt="" class="svg"
                                                         height="20" width="20">
                                                    <span
                                                        class="align-middle ms-1">{{ trans('rest.menu.add_category') }}</span>
                                                </a>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <a class="btn btn-site-theme"
                                                   href="{{ route('ingredients.index') }}">
                                                    <img src="{{ asset('images/add-up-white.svg') }}" alt="" class="svg"
                                                         height="20" width="20">
                                                    <span
                                                        class="align-middle ms-1">{{ trans('rest.menu.add_ingred') }}</span>
                                                </a>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <a class="btn btn-site-theme" href="{{ route('addDish') }}">
                                                    <img src="{{ asset('images/add-up-white.svg') }}" alt="" class="svg"
                                                         height="20" width="20">
                                                    <span
                                                        class="align-middle ms-1">{{ trans('rest.menu.add_dish') }}</span>
                                                </a>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="dropdown userlogin-dropdown custom-default-dropdown">
                                                    <button class="btn btn-light dropdown-toggle" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img src="{{ getRestaurantDetail()->restaurant_logo }}"
                                                             alt="user image" class="img-fluid">
                                                        <div class="d-inline-block text-start userdp-text">
                                                            <a href="javascript:void(0);"
                                                               class="d-block">{{ Auth::user()->name }}</a>
                                                            <span>{{ Auth::user()->email }}</span>
                                                        </div>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                                {{ trans('rest.settings.profile.logout') }}
                                                            </a>
                                                            <form id="logout-form" action="{{ route('logout') }}"
                                                                  method="POST" class="d-none"> @csrf </form>
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
                                <h1 class="section-title">{{ trans('rest.menu.categories') }}</h1>
                            </div>
                            <div class="swiper-container">
                                <div class="swiper category-swiper-slider categoryslide-setion">
                                    <div class="category-slider swiper-wrapper">
                                        @if (count($categories) > 0)
                                            @foreach ($categories as $key => $category)
                                                    <?php
                                                    $selected = '';

                                                    if (isset($_GET['cat_id'])) {
                                                        if ($_GET['cat_id'] == $category->id)
                                                            $selected = 'swiper-slide-admin-cart-active';
                                                    } else {
                                                        if ($key == 0)
                                                            $selected = 'swiper-slide-admin-cart-active';
                                                    }
                                                    ?>
                                                <div class="category-element swiper-slide {{ $selected }} "
                                                     data-id="{{ $category->id }}"
                                                     data-sort-order="{{ $category->sort_order }}">
                                                    <div class="card">
                                                        <div class="category-slide-btns">
                                                            <a class="btn btn-site-theme btn-icon" id="prev-cat">
                                                                <i class="fa fa-arrow-left"></i>
                                                            </a>
                                                            <a class="btn btn-site-theme btn-icon" id="next-cat">
                                                                <i class="fa fa-arrow-right"></i>
                                                            </a>
                                                        </div>
                                                        <span class="dish-item-icon">
                                                    <img src="{{ $category->image }}" class="img-fluid svg" alt="bakery"
                                                         style="height: 45px !important;">
                                                </span>
                                                        <p class="mb-0 category-item-name text-truncate w-100"
                                                           title="{{ $category->name }}">{{ $category->name }}</p>
                                                        <div class="categoryfood-detail-card-btn">
                                                            <a class="btn btn-site-theme btn-icon category-edit-btn"
                                                               data-id="{{ $category->id }}" data-bs-toggle="modal"
                                                               data-bs-target="#editCategoryModel">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                                            <a class="btn btn-site-theme btn-icon del-cat-icon"
                                                               data-id="{{ $category->id }}">
                                                                <i class="fa-regular fa-trash-can"></i>
                                                            </a>
                                                        </div>
                                                        <a href="{{ route('home',['cat_id' => $category->id]) }}"
                                                           class="link-abs"></a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            {{ trans('rest.menu.no_category') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- end category section -->
                        <!-- start dishes list section -->
                        <section class="custom-section">
                            <div class="section-page-title">
                                <h1 class="section-title">{{ trans('rest.menu.dishes') }}</h1>
                                <!--                                <a href="{{ route('dish.index') }}" type="button"
                                   class="viewall-btn">{{ trans('rest.button.view_all') }}
                                <span class="ms-2">
                                    <img src="{{ asset('images/view.svg') }}" alt="" class="svg" height="24"
                                             width="24">
                                    </span>
                                </a>-->
                            </div>
                            <div class="dish-details-div">
                                <div class="popular-item-grid">
                                    @if (count($dishes) > 0)
                                        @foreach ($dishes as $dish)
                                            <div class="card food-detail-card shadow-mobile">
                                                @if ($dish->out_of_stock == '1' || $dish->qty <= 0)
                                                    <p class="mb-0 inoutstock-badge text-bg-danger-1">{{ trans('rest.menu.dish.out_of_stock') }}</p>
                                                @else
                                                    <p class="mb-0 inoutstock-badge text-bg-success-1">{{ trans('rest.menu.dish.in_stock') }}</p>
                                                @endif
                                                <div class="card-body p-0">
                                                    <!--                                                    <p class="quantity-text badge">{{ trans('rest.menu.dish.qty') }}
                                                    :{{ $dish->qty }}</p>-->
                                                    <div class="food-image">
                                                        <img src="{{ $dish->image }}" alt="burger imag"
                                                             class="img-fluid"/>
                                                    </div>
                                                    <h4 class="food-name-text text-truncate w-100"
                                                        title="{{ $dish->name }}">{{ $dish->name }}</h4>
                                                    <p class="food-price">€{{ $dish->price }}</p>
                                                    <div class="food-detail-card-btn">
                                                        <a href="{{ route('editDish', $dish->id) }}"
                                                           class="btn btn-site-theme btn-icon"
                                                           data-id="{{ $dish->id }}">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <a class="btn btn-site-theme btn-icon del-dish-btn"
                                                           data-bs-toggle="modal" data-bs-target="#deleteDishAlertModal"
                                                           data-id="{{ $dish->id }}">
                                                            <i class="fa-regular fa-trash-can"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div> {{ trans('rest.menu.no_dish') }} </div>
                                    @endif
                                </div>
                            </div>
                        </section>
                        <!-- end dishes list section -->
                        <!-- start Popular item list section -->
                        <section class="custom-section ">
                            <div class="section-page-title">
                                <h1 class="section-title">{{ trans('rest.menu.popular_week') }}</h1>
                                <a href="{{ route('dish.popular') }}" type="button" target="_blank"
                                   class="viewall-btn">{{ trans('rest.button.view_all') }}
                                    <span class="ms-2">
                                        <img src="{{ asset('images/view.svg') }}" alt="" class="svg" height="24"
                                             width="24">
                                    </span>
                                </a>
                            </div>
                            <div class="bestselling-item-grid">
                                @if(count($popularDishes) > 0)
                                    @foreach ($popularDishes as $dish_id => $order)
                                        @php
                                            $dish = App\Models\Dish::find($dish_id);
                                        @endphp
                                        <div class="card bestselling-detail-card">
                                            <div class="card-body p-0">
                                                <div class="food-image">
                                                    <img src="{{ $dish->image }}" alt="burger imag" class="img-fluid"/>
                                                </div>
                                                <div class="text-start flex-fill">
                                                    <h4 class="food-name-text text-start text-truncate w-100">{{ $dish->name }}</h4>
                                                    <p class="food-price d-inline-block">€{{ $dish->price }}</p>
                                                    <p class="mb-0 sellingpercantage-count d-inline-flex align-items-center">
                                                        @if($order['percentage'] < 0)
                                                            {{ $order['percentage'] }}%
                                                            <img src="{{ asset('images/down-arrow.svg') }}" alt=""
                                                                 class="svg" height="19" width="19">
                                                        @else
                                                            +{{ $order['percentage'] }}%
                                                            <img src="{{ asset('images/up-arrow.svg') }}" alt=""
                                                                 class="svg"
                                                                 height="19" width="19">
                                                        @endif
                                                    </p>
                                                    <p class="lead-1 mb-0">{{ trans('rest.menu.sold_dishes',['sold_qty' => $order['total_orders']]) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    {{ trans('rest.menu.dish.no_popular') }}
                                @endif
                            </div>
                        </section>
                        <!-- end Popluar item list section -->
                        <!-- start Best selling list section -->
                        <section class="custom-section">
                            <div class="section-page-title">
                                <h1 class="section-title">{{ trans('rest.menu.best_seller') }}</h1>
                                <a href="{{ route('dish.bestseller') }}" type="button" target="_blank"
                                   class="viewall-btn">{{ trans('rest.button.view_all') }}
                                    <span class="ms-2">
                                        <img src="{{ asset('images/view.svg') }}" alt="" class="svg" height="24"
                                             width="24">
                                    </span>
                                </a>
                            </div>
                            <div class="bestselling-item-grid">
                                @if(count($bestSellerDishes) > 0)
                                    @foreach ($bestSellerDishes as $bestSellerDish)
                                        <div class="card bestselling-detail-card">
                                            <div class="card-body p-0">
                                                <div class="food-image">
                                                    <img src="{{ $bestSellerDish->dish->image }}" alt="burger imag"
                                                         class="img-fluid"/>
                                                </div>
                                                <div class="text-start flex-fill">
                                                    <h4 class="food-name-text text-start text-truncate w-100"
                                                        title="{{ $bestSellerDish->name }}">{{ $bestSellerDish->dish->name }}</h4>
                                                    <p class="food-price d-inline-block">
                                                        €{{ $bestSellerDish->dish->price }}</p>
                                                    <p class="lead-1 mb-0">{{ trans('rest.menu.sold_dishes',['sold_qty' => $bestSellerDish->total_orders]) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    {{ trans('rest.menu.dish.no_bestseller') }}
                                @endif
                            </div>
                        </section>
                        <!-- end Best selling list section -->
                    </div>
                </main>
            </div>
        </div>
        <!-- start footer --> @include('layouts.admin.footer_design')
        <!-- end footer -->
    </div>
    <!-- start add category Modal -->
    <div class="modal fade custom-modal" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModal"
         aria-hidden="true">
        <div class="modal-dialog custom-w-441px modal-dialog-centered">
            <div class="modal-content border-radius">
                <div class="modal-header border-0">
                    <h1 class="modal-title mb-0">{{ trans('rest.modal.category.add') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <form method="POST" id="categoryForm" enctype="multipart/form-data">
                        <div class="imageupload-box">
                            <label for="input-file" class="upload-file">
                                <img src="{{ asset('images/blank-img.svg') }}" alt="blank image" id="img-preview"
                                     class="img-fluid mb-2" width="35" height="27">
                                <p class="mb-0" id="img-label">{{ trans('rest.modal.category.image') }}</p>
                            </label>
                            <input type="file" id="input-file" class="d-none" name="image">
                        </div>
                        <div class="form-group">
                            <label for="dishnameenglish" class="form-label">{{ trans('rest.modal.category.category') }}
                                <span class="text-custom-muted">(English)</span>
                            </label>
                            <input type="text" name="name_en" id="name_en" class="form-control" maxlength="250">
                        </div>
                        <div class="form-group mb-0">
                            <label for="dishnameenglish" class="form-label">{{ trans('rest.modal.category.category') }}
                                <span class="text-custom-muted">(Dutch)</span>
                            </label>
                            <input type="text" name="name_nl" id="name_nl" class="form-control" maxlength="250">
                        </div>
                        <button type="submit"
                                class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-100 mt-30px font-18">{{ trans('rest.button.save') }}
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
                    <h1 class="modal-title mb-0">{{ trans('rest.modal.category.edit') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <form method="POST" id="editCategoryForm" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="editCatId">
                        <div class="imageupload-box">
                            <label for="edit-input-file" class="upload-file">
                                <input type="file" id="edit-input-file" name="image">
                                <img src="{{ asset('images/blank-img.svg') }}" alt="blank image" id="edit-img-preview"
                                     width="35" height="27" class="img-fluid mb-2@">
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="dishnameenglish" class="form-label">{{ trans('rest.modal.category.category') }}
                                <span class="text-custom-muted">(English)</span>
                            </label>
                            <input type="text" name="name_en" id="edit_name_en" class="form-control"
                                   maxlength="250">
                        </div>
                        <div class="form-group mb-0">
                            <label for="dishnameenglish" class="form-label">{{ trans('rest.modal.category.category') }}
                                <span class="text-custom-muted">(Dutch)</span>
                            </label>
                            <input type="text" name="name_nl" id="edit_name_nl" class="form-control"
                                   maxlength="250">
                        </div>
                        <button type="submit"
                                class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-100 mt-30px font-18">{{ trans('rest.button.update') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end edit category  Modal -->
    <!-- start delete category Modal -->
    <div class="modal fade custom-modal" id="deleteCategoryAlertModal" tabindex="-1" aria-labelledby="dleteAlertModal"
         aria-hidden="true">
        <div class="modal-dialog custom-w-441px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="hidden" value="" id="catId">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="alert-text-1 mb-40px">{{ trans('rest.modal.category.delete_message') }}</h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button"
                                class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px"
                                data-bs-dismiss="modal">{{ trans('rest.button.cancel') }}</button>
                        <button type="button" id="delete-category-btn"
                                class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-160px">{{ trans('rest.button.delete') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end delete category Modal -->
    <!-- start delete dish Modal -->
    <div class="modal fade custom-modal" id="deleteDishAlertModal" tabindex="-1" aria-labelledby="deleteDishAlertModal"
         aria-hidden="true">
        <div class="modal-dialog custom-w-441px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="hidden" value="" id="dishId">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="alert-text-1 mb-40px">{{ trans('rest.modal.dish.delete_message') }}</h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button"
                                class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px"
                                data-bs-dismiss="modal">{{ trans('rest.button.cancel') }}</button>
                        <button type="button" id="delete-dish-btn"
                                class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-160px">{{ trans('rest.button.delete') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end delete dish Modal -->
    <!-- start delete Ingredients Modal -->
    <div class="modal fade custom-modal" id="deleteAlertModalMsg" tabindex="-1" aria-labelledby="deleteAlertModalMsg"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="alert-text-1 mb-40px">{{ trans('rest.modal.dish.alert_message') }}</h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-160px"
                                data-bs-dismiss="modal">{{ trans('rest.button.ok') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end delete Ingredients Modal -->
    {{-- </div> --}}

    <!-- start order category Modal -->
    {{-- <div class="order-modal-div" id="order-modal-div"> --}}
<!--        <div class="modal fade custom-modal" id="newOrderModal" tabindex="-1" aria-labelledby="newOrderModal"
             aria-hidden="true">
        </div>-->
    {{-- </div> --}}
    <!-- end order category  Modal -->

@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/category.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dish-home-operations.js') }}"></script>
@endsection
