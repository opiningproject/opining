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
                                    <h1 class="page-title">{{ trans('rest.menu.dish_option.dish_option_category') }}</h1>
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
                                                    <li class="breadcrumb-item"><a
                                                            href="{{ route('home') }}">{{ trans('rest.menu.title') }}</a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a
                                                            href="{{ route('dish-option.index')}}">{{ trans('rest.menu.dish_option.title') }}</a>
                                                    </li>
                                                    <li class="breadcrumb-item active"
                                                        aria-current="page">{{ trans('rest.menu.dish_option.dish_option_category') }}</li>
                                                </ol>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-0">
                                    <form method="POST" name="dishOptionCategoryForm" id="dishOptionCategoryForm">
                                        @csrf
                                        <div class="row dishOptionRow align-items-start">
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 dishOptionCol">
                                                <div class="form-group">
                                                    <label for="ingredientsnameenglish"
                                                           class="form-label">{{ trans('rest.menu.dish_option.dish_option_category_title') }}
                                                        <span class="text-custom-muted">(English)</span></label>
                                                    <input type="text" class="form-control" name="title_en"
                                                           maxlength="250" id="title_en"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 dishOptionCol">
                                                <div class="form-group">
                                                    <label for="ingredientsnameenglish"
                                                           class="form-label">{{ trans('rest.menu.dish_option.dish_option_category_title') }}
                                                        <span class="text-custom-muted">(Dutch)</span></label>
                                                    <input type="text" class="form-control" name="title_nl"
                                                           maxlength="250" id="title_nl"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 dishOptionCol">
                                                <div class="form-group">
                                                    <label for="ingredientsnameenglish"
                                                           class="form-label">{{ trans('rest.menu.dish_option.dish_option_category') }}
                                                        <span class="text-custom-muted">(English)</span></label>
                                                    <input type="text" class="form-control" name="name_en"
                                                           maxlength="250" id="name_en"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 dishOptionCol">
                                                <div class="form-group">
                                                    <label for="ingredientsnamedutch"
                                                           class="form-label">{{ trans('rest.menu.dish_option.dish_option_category') }}
                                                        <span class="text-custom-muted">(Dutch)</span>
                                                    </label>
                                                    <input type="text" class="form-control" name="name_nl"
                                                           maxlength="250" id="name_nl"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 dishBtnAddCol">
                                                <div class="form-group">
                                                    <label for="discountpercentage" class="form-label invisible">&nbsp;</label>
                                                    <button type="submit"
                                                            class="btn btn-site-theme btn-default d-block w-130px mt-0 save-ing-cat-div">
                                                        <span class="align-middle">{{ trans('rest.button.add') }}</span>
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
                                                <th scope="col"
                                                    class="text-center">{{ trans('rest.menu.dish_option.dish_option_category') }}
                                                    <span class="text-custom-muted font-regularcustom">(English)</span>
                                                </th>
                                                <th scope="col"
                                                    class="text-center">{{ trans('rest.menu.dish_option.dish_option_category') }}
                                                    <span class="text-custom-muted font-regularcustom">(Dutch)</span>
                                                </th>
                                                <th scope="col"
                                                    class="text-center">{{ trans('rest.menu.dish_option.dish_option_category_title') }}
                                                    <span class="text-custom-muted font-regularcustom">(English)</span>
                                                </th>
                                                <th scope="col"
                                                    class="text-center">{{ trans('rest.menu.dish_option.dish_option_category_title') }}
                                                    <span class="text-custom-muted font-regularcustom">(Dutch)</span>
                                                </th>

                                                <th scope="col"
                                                    class="text-center">{{ trans('rest.button.action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody id="ingredientCategoryTbody">
                                            @foreach ($dishOptionCategory as $category)
                                                {{--                                            <tr id="ing-tr{{ $category->id }}">--}}
                                                <tr id="ing-tr{{ $category->id }}" draggable="true"
                                                    class="ingredientCategoryRow" data-id="{{ $category->id }}">
                                                    <td class="text-center">
                                                        <input type="text" class="form-control text-center m-auto"
                                                               data-id="{{ $category->id }}"
                                                               value="{{ $category->title_en }}"
                                                               id="title_en{{ $category->id }}" readonly/>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" class="form-control text-center m-auto"
                                                               value="{{ $category->title_nl }}"
                                                               id="title_nl{{ $category->id }}" readonly/>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" class="form-control text-center m-auto"
                                                               data-id="{{ $category->id }}"
                                                               value="{{ $category->name_en }}"
                                                               id="name_en{{ $category->id }}" readonly/>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" class="form-control text-center m-auto"
                                                               value="{{ $category->name_nl }}"
                                                               id="name_nl{{ $category->id }}" readonly/>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex flex-nowrap gap-2 justify-content-center">
                                                            <a class="btn btn-site-theme btn-icon edit-cat-icon"
                                                               id="edit-btn{{ $category->id }}"
                                                               data-id="{{ $category->id }}" tabindex="0">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                                            <a class="btn btn-site-theme btn-icon del-cat-icon"
                                                               id="del-btn{{ $category->id }}"
                                                               data-id="{{ $category->id }}">
                                                                <i class="fa-regular fa-trash-can"></i>
                                                            </a>
                                                            <a class="btn btn-site-theme btn-default save-edit-btn d-block"
                                                               id="save-edit-btn{{ $category->id }}"
                                                               style="width: auto;margin-left: 0px; display: none!important;"
                                                               data-id="{{ $category->id }}">
                                                                <span
                                                                    class="align-middle">{{ trans('rest.button.save') }}</span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        {{ $dishOptionCategory->links() }}
                                        <div>
                                            <label>{{ trans('rest.button.rows_per_page') }}</label>
                                            <select id="per_page_dropdown" onchange="">
                                                @for($i=5; $i<=20; $i+=5)
                                                    <option
                                                        {{ $perPage == $i ? 'selected' : '' }} value="{{ Request::url().'?per_page=' }}{{ $i }}">
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
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
        <!-- start footer -->
        @include('layouts.admin.footer_design')
        <!-- end footer -->
    </div>
    <!-- start delete category Modal -->
    <div class="modal fade custom-modal" id="deleteAlertModal" tabindex="-1"
         aria-labelledby="dleteAlertModal" aria-hidden="true">
        <div class="modal-dialog custom-w-441px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="hidden" value="" id="catId">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="alert-text-1 mb-40px">{{ trans('rest.modal.ingred_category.delete_message') }}</h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button"
                                class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px"
                                data-bs-dismiss="modal">
                            {{ trans('rest.button.cancel') }}
                        </button>
                        <button type="button" id="delete-category-btn"
                                class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-160px">
                            {{ trans('rest.button.delete') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end delete category Modal -->

    <!-- start delete Ingredients Modal -->
    <div class="modal fade custom-modal" id="deleteAlertModalMsg" tabindex="-1"
         aria-labelledby="deleteAlertModalMsg" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="alert-text-1 mb-40px">{{ trans('rest.modal.ingred_category.alert_message') }}</h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-160px"
                                data-bs-dismiss="modal">
                            {{ trans('rest.button.ok') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end delete Ingredients Modal -->
@endsection
@section('script')
    <script>
        var dishValidation = {
            save_btn: '{{ trans('rest.button.save') }}',
        }
    </script>
    <script type="text/javascript" src="{{ asset('js/dish-option-category.js')}}"></script>
@endsection
