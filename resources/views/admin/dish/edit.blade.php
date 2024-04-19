@extends('layouts.app') @section('content') 
<div class="main">
    <div class="main-view">
        <div class="container-fluid bd-gutter bd-layout"> @include('layouts.admin.side_nav_bar') 
            <main class="w-100">
                <div class="main-content">
                    <div class="section-page-title main-page-title mb-0">
                        <div class="">
                            <h1 class="page-title">{{ trans('rest.menu.dish.edit') }}</h1>
                        </div>
                    </div>
                    <!-- start edit dish card section -->
                    <section class="custom-section">
                        <div class="card editdish-card">
                            <form id="editDishForm" enctype="multipart/form-data"> @csrf 
                                <div class="card-header border-0 bg-white border-bottom-0">
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                            <nav class="page-breadcrumb" aria-label="breadcrumb">
                                                <ol class="breadcrumb">
                                                    <li class="breadcrumb-item">
                                                        <a href="{{ route('home') }}">{{ trans('rest.menu.title') }}</a>
                                                    </li>
                                                    <li class="breadcrumb-item active">{{ trans('rest.menu.dish.edit') }}</li>
                                                </ol>
                                            </nav>
                                        </div>
                                        <div
                                            class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 text-end float-end">
                                            <div class="form-group mb-0 mt-2">
                                                <div
                                                    class="form-check form-switch custom-switch d-flex align-items-center justify-content-end ps-0">
                                                    <label class="form-check-label form-label mb-0 me-2"
                                                        for="outofstock">{{ trans('rest.menu.dish.out_of_stock') }}</label>
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        name="out_of_stock" value="1"
                                                        {{ $dish->out_of_stock == 1 ? 'checked' : '' }} id="outofstock">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-0">
                                    <div class="row">
                                        <input type="hidden" value="{{ $dish->id }}" id="dishId">
                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <div class="form-group imageupload-box inline-imageupload-box">
                                                <label for="dishimage" class="form-label">{{ trans('rest.menu.dish.dish_image') }}</label>
                                                <label for="input-file" class="upload-file justify-content-center">
                                                    <input type="file" id="input-file" name="image">
                                                    <img src="{{ $dish->image }}" style="height: 40px"
                                                        alt="blank image" id="img-preview" class="img-fluid">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('rest.menu.dish.dish_name') }} 
                                                    <span class="text-custom-muted">(English)</span>
                                                </label>
                                                <input type="text" class="form-control" name="name_en" value="{{ $dish->name_en }}" />
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="dishnamedutch" class="form-label">{{ trans('rest.menu.dish.dish_name') }} 
                                                    <span class="text-custom-muted">(Dutch)</span>
                                                </label>
                                                <input type="text" class="form-control" name="name_nl"
                                                    value="{{ $dish->name_nl }}" />
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <div class="form-group ">
                                                <label for="dishcategory" class="form-label">{{ trans('rest.menu.dish.category') }}</label>
                                                <select class="form-control dropdown-toggle w-100" type="button"
                                                    data-bs-toggle="dropdown" name="category_id" aria-expanded="false">
                                                    <option value="">{{ trans('rest.menu.dish.select_category') }}</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $category->id == $dish->category_id ? 'selected' : '' }}>
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('rest.menu.dish.discount_per') }}</label>
                                                <input type="number" class="form-control" value="{{ $dish->percentage_off }}" id="percentage_off" name="percentage_off" />
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="quantity" class="form-label">{{ trans('rest.menu.dish.quantity') }}</label>
                                                <input type="number" class="form-control" value="{{ $dish->qty }}"
                                                    name="qty" id="qty" />
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="dishprice" class="form-label">{{ trans('rest.menu.dish.dish_price') }}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1">€</span>
                                                    <input type="text" class="form-control" value="{{ $dish->price }}" id="price" name="price" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="discountpercentage" class="form-label">{{ trans('rest.menu.dish.description') }}
                                                    <span class="text-custom-muted">(English)</span>
                                                </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $dish->desc_en }}" id="desc_en" name="desc_en" />
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="discountpercentage" class="form-label">{{ trans('rest.menu.dish.description') }}
                                                    <span class="text-custom-muted">(Dutch)</span>
                                                </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $dish->desc_nl }}" id="desc_nl" name="desc_nl" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12" style="float: left;margin-right: 10px;">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="password" class="form-label">{{ trans('rest.menu.dish.option') }} 
                                                    <span class="text-custom-muted">(English)</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="option_name_en" id="option_name_en">
                                                    <button class="input-group-btn btn btn-custom-yellow btn-icon h-50px" type="button" id="addOptionBtn">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <label for="password" class="form-label">{{ trans('rest.menu.dish.option') }} 
                                                    <span class="text-custom-muted">(Dutch)</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="option_name_nl" id="option_name_nl">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="dish-option-div">
                                        @foreach ($dish->option as $option)
                                            <div class="row col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 addedOptionDiv"
                                                style="float:left;margin-right: 10px;">
                                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <input type="hidden" value="{{ $option->id }}"
                                                            class="id">
                                                        <label for="password" class="form-label">{{ trans('rest.menu.dish.option') }}  
                                                            <span class="text-custom-muted">(English)</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control name_en"
                                                                value="{{ $option->option_en }}">
                                                            <button
                                                                class="input-group-btn btn btn-custom-gray btn-icon h-50px del-added-option-btn"
                                                                type="button" id="{{ $option->id }}">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="password" class="form-label">{{ trans('rest.menu.dish.option') }}  
                                                            <span class="text-custom-muted">(Dutch)</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control name_nl"
                                                                value="{{ $option->option_nl }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <button type="submit"
                                                class="btn btn-custom-yellow btn-default d-block w-130px mt-3">
                                                <span class="align-middle">{{ trans('rest.button.update') }}</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr class="my-0" />
                            <div class="card-body">
                                <div class="addedit-table-row">
                                    <div class="row">
                                        <div class="col-auto mt-4">
                                            <h1 class="section-title">{{ trans('rest.menu.dish.free_ingred') }}</h1>
                                        </div>
                                        <div class="col">
                                            <form id="freeIngredientForm" name="freeIngredientForm" method="post">
                                                <div class="row justify-content-end">
                                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <strong>{{ trans('rest.menu.dish.ingred_categories') }}</strong>
                                                            </label>
                                                            <div class="input-group w-100">
                                                                <div class="dropdown w-100 ingredientslist-dp custom-default-dropdown">
                                                                    <select
                                                                        class="form-control bg-white dropdown-toggle d-flex align-items-center justify-content-between w-100"
                                                                        data-bs-toggle="dropdown" name="freeIngredientCategory" id="freeIngredientCategory">
                                                                        <option value=""> {{ trans('rest.menu.dish.select_ingred_category') }}</option>
                                                                        @foreach ($ingredientCategories as $ingredientCategory)
                                                                            <option value="{{ $ingredientCategory->id }}">
                                                                                {{ $ingredientCategory->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label for="ingredientslist" class="form-label">
                                                                <strong>{{ trans('rest.menu.dish.ingred_list') }}</strong>
                                                            </label>
                                                            <div class="input-group w-100">
                                                                <div class="dropdown w-100 ingredientslist-dp custom-default-dropdown">
                                                                    <select
                                                                        class="form-control bg-white dropdown-toggle d-flex align-items-center justify-content-between w-100"
                                                                        type="button" name="ingredient_id"
                                                                        id="freeIngredient">
                                                                        <option value="">{{ trans('rest.menu.dish.select_ingred') }}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="form-group">
                                                            <label for="discountpercentage"
                                                                class="form-label"></label>
                                                            <button type="submit"
                                                                class="btn btn-custom-yellow btn-default d-block w-130px mt-3">
                                                                <span class="align-middle">{{ trans('rest.button.add') }}</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="add-edit-dish-table custom-table">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center" width="12%">{{ trans('rest.menu.dish.image') }}</th>
                                                    <th scope="col" class="text-center">{{ trans('rest.menu.dish.name') }}</th>
                                                    <th scope="col" class="text-center">{{ trans('rest.menu.dish.ingred_categories') }}</th>
                                                    <th scope="col" class="text-center" width="11%">{{ trans('rest.button.action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="freeIngredientTbody">
                                                @if (count($dish->freeIngredients) > 0)
                                                    @foreach ($dish->freeIngredients as $freeIngredient)
                                                        <tr id="dishIngredient{{ $freeIngredient->id }}">
                                                            <td class="text-center">
                                                                <img src="{{ $freeIngredient->ingredient->image }}" class="img-fluid me-15px" style="height: 50px" />
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="text" class="form-control text-center w-10r m-auto"
                                                                    value="{{ $freeIngredient->ingredient->name }}" readonly />
                                                            <td class="text-center">
                                                                <input type="text" class="form-control text-center w-10r m-auto"
                                                                    value="{{ $freeIngredient->ingredient->category->name }}" readonly />
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="">
                                                                    <a class="btn btn-custom-yellow btn-icon free-ingredient-btn del-dish-ingredient"
                                                                        data-bs-toggle="modal" data-id="{{ $freeIngredient->id }}" data-bs-target="#deleteAlertModal">
                                                                        <i class="fa-regular fa-trash-can"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr id="free-paid-ing-tr">
                                                        <td colspan="5">{{ trans('rest.menu.dish.no_ingred') }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="addedit-table-row">
                                    <div class="row">
                                        <div class="col-auto mt-4">
                                            <h1 class="section-title">{{ trans('rest.menu.dish.extra_ingred') }}</h1>
                                        </div>
                                        <div class="col">
                                            <form id="paidIngredientForm" name="paidIngredientForm" method="post">
                                                <div class="row justify-content-end">
                                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                <strong>{{ trans('rest.menu.dish.ingred_categories') }}</strong>
                                                            </label>
                                                            <div class="input-group w-100">
                                                                <div
                                                                    class="dropdown w-100 ingredientslist-dp custom-default-dropdown">
                                                                    <select
                                                                        class="form-control bg-white dropdown-toggle d-flex align-items-center justify-content-between w-100"
                                                                        type="button" name="paidIngredientCategory"
                                                                        id="paidIngredientCategory">
                                                                        <option value="">{{ trans('rest.menu.dish.select_ingred_category') }}</option>
                                                                        @foreach ($ingredientCategories as $ingredientCategory)
                                                                            <option value="{{ $ingredientCategory->id }}">
                                                                                {{ $ingredientCategory->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label for="ingredientslist" class="form-label">
                                                                <strong>{{ trans('rest.menu.dish.ingred_list') }}</strong>
                                                            </label>
                                                            <div class="input-group w-100">
                                                                <div
                                                                    class="dropdown w-100 ingredientslist-dp custom-default-dropdown">
                                                                    <select
                                                                        class="form-control bg-white dropdown-toggle d-flex align-items-center justify-content-between w-100"
                                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false" id="paidIngredient"
                                                                        name="ingredient_id">
                                                                        <option value="">{{ trans('rest.menu.dish.select_ingred') }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-2 col-xl-1 col-lg-3 col-md-4 col-sm-6 col-12">
                                                        <div class="form-group">
                                                            <label for="discountpercentage" class="form-label">
                                                                <strong>{{ trans('rest.menu.dish.price') }}</strong>
                                                            </label>
                                                            <div class="input-group">
                                                                <span class="input-group-text" id="basic-addon1">€</span>
                                                                <input type="number" class="form-control" name="price" id="paid-price" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="form-group">
                                                            <label for="discountpercentage" class="form-label"></label>
                                                            <button type="submit" class="btn btn-custom-yellow btn-default d-block w-130px mt-3">
                                                                <span class="align-middle">{{ trans('rest.button.add') }}</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="add-edit-dish-table custom-table">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center" width="12%">{{ trans('rest.menu.dish.image') }}</th>
                                                    <th scope="col" class="text-center">{{ trans('rest.menu.dish.name') }} </th>
                                                    <th scope="col" class="text-center">{{ trans('rest.menu.dish.ingred_categories') }}</th>
                                                    <th scope="col" class="text-center">{{ trans('rest.menu.dish.price') }} </th>
                                                    <th scope="col" class="text-center" width="11%">{{ trans('rest.button.action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="paidIngredientTbody">
                                                @if (count($dish->paidIngredients) > 0)
                                                    @foreach ($dish->paidIngredients as $paidIngredient)
                                                        <tr id="dishIngredient{{ $paidIngredient->id }}">
                                                            <td class="text-center">
                                                                <img src="{{ $paidIngredient->ingredient->image }}" class="img-fluid me-15px" alt="ingredient img 1"
                                                                    style="height: 50px" />
                                                            </td>
                                                            <td class="text-center">
                                                                <input type="text" class="form-control text-center w-10r m-auto" value="{{ $paidIngredient->ingredient->name }}"
                                                                    readonly />
                                                            <td class="text-center">
                                                                <input type="text" class="form-control text-center w-10r m-auto" value="{{ $paidIngredient->ingredient->category->name }}" readonly>
                                                            </td>
                                                            <td class="text-custom-muted-1 text-center">
                                                                <div class="input-group w-5r m-auto">
                                                                    <span class="input-group-text" id="basic-addon1">€</span>
                                                                    <input type="number" class="form-control m-auto" id="price{{ $paidIngredient->id }}"
                                                                        value="{{ $paidIngredient->price }}" readonly>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="d-flex align-items-center justify-content-center">
                                                                    <a class="btn btn-custom-yellow btn-icon me-4 paid-ingredient-edit-btn"
                                                                        id="paid-ingredient-edit{{ $paidIngredient->id }}" data-id="{{ $paidIngredient->id }}"
                                                                        tabindex="0" href="javascript:void(0);">
                                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                                    </a>
                                                                    <a class="btn btn-custom-yellow btn-icon paid-ingredient-del-btn del-dish-ingredient"
                                                                        id="paid-ingredient-delete{{ $paidIngredient->id }}"
                                                                        data-bs-toggle="modal" data-id="{{ $paidIngredient->id }}"
                                                                        data-bs-target="#deleteAlertModal">
                                                                        <i class="fa-regular fa-trash-can"></i>
                                                                    </a>
                                                                    <a class="btn btn-custom-yellow btn-default d-block paid-ingredient-save-btn"
                                                                        style="display: none !important;" id="paid-ingredient-save{{ $paidIngredient->id }}"
                                                                        data-id="{{ $paidIngredient->id }}">
                                                                        <span class="align-middle">{{ trans('rest.button.save') }}</span>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr id="no-paid-ing-tr">
                                                        <td colspan="5">{{ trans('rest.menu.dish.no_ingred') }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- end edit dish card section -->
                </div>
            </main>
        </div>
    </div>
    <!-- start footer --> @include('layouts.admin.footer_design')
    <!-- end footer -->
</div>
    
<!-- start delete Ingredients Modal -->
<div class="modal fade custom-modal" id="deleteAlertModal" tabindex="-1" aria-labelledby="deleteAlertModal" aria-hidden="true">
    <div class="modal-dialog custom-w-441px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <input type="hidden" value="" id="ingredientId">
                <div class="row">
                    <div class="col-12">
                        <h4 class="alert-text-1 mb-40px">{{ trans('rest.modal.ingred.delete_message') }}</h4>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button"
                        class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px"
                        data-bs-dismiss="modal">{{ trans('rest.button.cancel') }} </button>
                    <button type="button" id="delete-dish-ingredient-btn"
                        class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-160px">{{ trans('rest.button.delete') }} </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end delete Ingredients Modal --> @endsection @section('script')
<script type="text/javascript" src="{{ asset('js/dish.js') }}"></script>
@endsection
