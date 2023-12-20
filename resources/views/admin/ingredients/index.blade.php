@extends('layouts.app')

@section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.admin.side_nav_bar')

                <main class=" order-1 w-100">
                    <div class="main-content">
                        <div class="section-page-title main-page-title mb-0">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <h1 class="page-title">ingredients</h1>
                                </div>
                                <div class="col text-end">
                                    <a class="btn btn-custom-yellow" href="{{ route('ingred.category.index') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             viewBox="0 0 20 20" fill="none">
                                            <circle cx="10" cy="10" r="10" fill="#292929"></circle>
                                            <path
                                                d="M11.0475 9.48672H14.7416V11.1306H11.0475V14.8616H9.4036V11.1306H5.71875V9.48672H9.4036V5.71875H11.0475V9.48672Z"
                                                fill="#FFC00B"></path>
                                        </svg>
                                        <span class="align-middle ms-3">Add New Ingredients Categories</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- start edit dish card section -->
                        <section class="custom-section">
                            <div class="card editdish-card ingredients-card">
                                <div class="card-header border-0 bg-white border-bottom-0">
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <nav class="page-breadcrumb" aria-label="breadcrumb">
                                                <ol class="breadcrumb">
                                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Menu</a>
                                                    </li>
                                                    <li class="breadcrumb-item active">ingredients</li>
                                                </ol>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-0">
                                    <form method="POST" name="addIngredientForm" id="addIngredientForm"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                                <div class="imageupload-box inline-imageupload-box">
                                                    <label for="ingredientsnameenglish" class="form-label">Image</label>
                                                    <label for="input-file" class="upload-file">
                                                        <input type="file" id="input-file" name="image">
                                                        <img src="{{ asset('images/blank-img.svg')}}" alt="blank image"
                                                             id="img-preview"
                                                             class="img-fluid">
                                                        <p class="mb-0" id="img-label">Upload Image of Item</p>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="ingredientsnameenglish" class="form-label">Ingredients
                                                        Name
                                                        <span class="text-custom-muted">(English)</span></label>
                                                    <input type="text" class="form-control" name="name_en"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="ingredientsnamedutch" class="form-label">Ingredients
                                                        Name
                                                        <span class="text-custom-muted">(Dutch)</span></label>
                                                    <input type="text" class="form-control" name="name_nl"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="dishcategory" class="form-label">Ingredients
                                                        categories</label>

                                                    <select class="form-control dropdown-toggle w-100"
                                                            type="button" name="category_id"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <option value="">Select Category</option>
                                                        @foreach ($ingredientCategory as $category)
                                                            <option
                                                                value="{{ $category->id }}">{{ (app()->getLocale() == 'en') ? $category->name_en : $category->name_nl }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="discountpercentage" class="form-label"></label>
                                                    <button type="submit"
                                                            class="btn btn-custom-yellow btn-default d-block w-130px mt-3">
                                                        <span class="align-middle">Add</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="add-edit-dish-table custom-table ingredients-table">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col" width="12%" class="text-center">Image</th>
                                                <th scope="col" class="text-center">Name <span
                                                        class="text-custom-muted font-regularcustom">(English)</span>
                                                <th scope="col" class="text-center">Name <span
                                                        class="text-custom-muted font-regularcustom">(Dutch)</span>
                                                </th>
                                                <th scope="col" class="text-center">Ingredients categories
                                                </th>
                                                <th scope="col" class="text-center" width="5%">Action</th>
                                                <th scope="col" class="text-center">Add For Individual dish<span
                                                        class="text-custom-muted font-regularcustom">(Free)</span></th>
                                                <th scope="col" class="text-center" width="10%">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($ingredients as $ingredient)
                                                <tr id="ingredient-tr{{ $ingredient->id }}">
                                                    <td scope="row" class="text-center">
                                                        <img
                                                            src="{{ $ingredient->image }}"
                                                            class="img-fluid" id="ing-exist-img{{ $ingredient->id }}"
                                                            alt="ingredient img 1"/>
                                                        <div class="imageupload-box inline-imageupload-box mb-0"
                                                             style="display: none" id="img-div{{ $ingredient->id }}">
                                                            <label for="input-file" class="upload-file">
                                                                <input type="file" id="ing-image{{ $ingredient->id }}">
                                                                <img src="{{ $ingredient->image }}"
                                                                     alt="tomatoes image"
                                                                     class="img-fluid" width="25" height="25">
                                                                <p class="mb-0 text-lowercase">{{ $ingredient->image }}</p>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center"><input type="text"
                                                                                   class="form-control text-center w-10r m-auto"
                                                                                   id="name_en{{ $ingredient->id }}"
                                                                                   value="{{ $ingredient->name_en }}"
                                                                                   readonly/></td>
                                                    <td class="text-center"><input type="text"
                                                                                   class="form-control text-center w-10r m-auto"
                                                                                   id="name_nl{{ $ingredient->id }}"
                                                                                   value="{{ $ingredient->name_nl }}"
                                                                                   readonly/></td>
                                                    <td>
                                                        <div class="dropdown buttondropdown category-dropdown">
                                                            <select class="form-control w-100" disabled
                                                                    id="catId{{$ingredient->id}}">
                                                                @foreach ($ingredientCategory as $category)
                                                                    <option
                                                                        value="{{ $category->id }}" {{ ($category->id == $ingredient->category_id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-group mb-0">
                                                            <div
                                                                class="form-check form-switch form-switch-sm custom-switch justify-content-center ps-0">
                                                                <input
                                                                    class="form-check-input green-check-input update-ing-status"
                                                                    value="{{ $ingredient->id }}"
                                                                    type="checkbox" role="switch"
                                                                    id="action" {{ ($ingredient->status == 1) ? 'checked' : ''  }}>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="table-add-dish-bar">
                                                            <select class="btn btn-light dropdown-toggle dish-dropdown"
                                                                    data-id="{{ $ingredient->id }}" type="button"
                                                                    id="dish-list{{ $ingredient->id }}" disabled>
                                                                <?php
                                                                $dishLists = \App\Models\Dish::doesnthave('freeIngredients', 'and', function ($query) use ($ingredient) {
                                                                    $query->where('ingredient_id', $ingredient->id);
                                                                })->get();
                                                                ?>
                                                                <option value="">Select Dish name</option>
                                                                @foreach($dishLists as $dish)
                                                                    <option value="{{ $dish->id }}"
                                                                            data-name="{{ $dish->name }}">{{ $dish->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="table-dish-name dish-tray{{ $ingredient->id }}">
                                                                <?php
                                                                $dishCount = 1;
                                                                ?>
                                                                @foreach ($ingredient->freeDishIngredient as $ingr)

                                                                    @if($dishCount > 2 )
                                                                        @if($dishCount == 3)
                                                                            <div class="moredishname-collapse collapse"
                                                                                 id="collapseDishRowTwo">
                                                                                @endif
                                                                                <div
                                                                                    class="card card-body bg-lightgray d-block py-2 px-0 border-0">
                                                                        <span class="badge text-bg-yellow">{{ $ingr->dish->name_en }}<a
                                                                                href="javascript:void(0);"><i
                                                                                    class="fa-solid fa-xmark align-middle"
                                                                                    data-id="{{ $ingredient->id }}"
                                                                                    data-name="{{ $ingr->dish->name_en }}"></i></a></span>
                                                                                </div>
                                                                                @else
                                                                                    <span class="badge text-bg-yellow">{{ $ingr->dish->name_en }}<a
                                                                                            href="javascript:void(0);"><i
                                                                                                class="fa-solid fa-xmark align-middle del-dish-icon"
                                                                                                data-id="{{ $ingredient->id }}"
                                                                                                data-name="{{ $ingr->dish->name_en }}"></i></a></span>
                                                                                @endif
                                                                                <?php
                                                                                $dishCount++
                                                                                ?>
                                                                                @endforeach
                                                                                @if($dishCount > 3)
                                                                            </div>
                                                                            <a class="text-more-sm float-end lh-30px"
                                                                               id="more-less-text{{ $ingredient->id }}"
                                                                               data-bs-toggle="collapse"
                                                                               href="#collapseDishRowTwo"
                                                                               role="button" aria-expanded="false"
                                                                               aria-controls="collapseDishRowTwo">+
                                                                                more</a>
                                                                        @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="">
                                                            <a class="btn btn-custom-yellow btn-icon edit-ing-btn"
                                                               tabindex="0" data-id="{{ $ingredient->id }}"
                                                               id="edit-btn{{ $ingredient->id }}">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                                            <a class="btn btn-custom-yellow btn-icon del-ing-btn"
                                                               data-id="{{ $ingredient->id }}"
                                                               id="del-btn{{ $ingredient->id }}">
                                                                <i class="fa-regular fa-trash-can"></i>
                                                            </a>
                                                            <a class="btn btn-custom-yellow btn-default save-edit-btn d-block"
                                                               id="save-btn{{ $ingredient->id }}"
                                                               style="display:none !important;"
                                                               data-id="{{ $ingredient->id }}">
                                                                <span class="align-middle">Save</span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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

    <!-- start add category Modal -->
    <div class="modal fade custom-modal" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModal"
         aria-hidden="true">
        <div class="modal-dialog custom-w-441px modal-dialog-centered">
            <div class="modal-content border-radius">
                <div class="modal-header border-0">
                    <h1 class="modal-title mb-0">Add Categories</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="imageupload-box">
                        <label for="input-file" class="upload-file">
                            <input type="file" id="input-file">
                            <img src="images/blank-img.svg" alt="blank image" class="img-fluid mb-2">
                            <p class="mb-0">Please upload image of <a href="javascript:void(0);"
                                                                      class="upload-link">Dish</a></p>
                        </label>
                    </div>
                    <form>
                        <div class="form-group">
                            <label for="dishnameenglish" class="form-label">Dish Category <span
                                    class="text-custom-muted">(English)</span></label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group mb-0">
                            <label for="dishnameenglish" class="form-label">Dish Category <span
                                    class="text-custom-muted">(Dutch)</span></label>
                            <input type="text" class="form-control">
                        </div>
                        <button type="button"
                                class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 mt-30px font-18">
                            Add
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end add category  Modal -->

    <!-- start delete Ingredients Modal -->
    <div class="modal fade custom-modal" id="deleteAlertModal" tabindex="-1"
         aria-labelledby="deleteAlertModal" aria-hidden="true">
        <div class="modal-dialog custom-w-441px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="hidden" value="" id="ingredientId">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="alert-text-1 mb-40px">Are you sure you want to
                                delete this Ingredient?</h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button"
                                class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px"
                                data-bs-dismiss="modal">Cancel
                        </button>
                        <button type="button" id="delete-ingredient-btn"
                                class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-160px">Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end delete Ingredients Modal -->

    <!-- start delete Ingredients Modal -->
    <div class="modal fade custom-modal" id="deleteAlertModalMsg" tabindex="-1"
         aria-labelledby="deleteAlertModalMsg" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="alert-text-1 mb-40px">There are dishes added to this ingredients. Please remove
                                them to delete this ingredient.</h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button"
                                class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-160px"
                                data-bs-dismiss="modal">Okay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end delete Ingredients Modal -->

@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js/ingredients.js')}}"></script>
@endsection
