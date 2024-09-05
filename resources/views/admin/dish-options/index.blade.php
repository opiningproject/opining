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
                                    <h1 class="page-title">{{ trans('rest.menu.dish_option.title') }}</h1>
                                </div>
                                <div class="col text-end">
                                    <a class="btn btn-custom-yellow" href="{{ route('dishOption.category.index') }}">
                                        <img src="{{ asset('images/add-up.svg')}}" alt="" class="svg" height="20"
                                             width="20">
                                        <span
                                            class="align-middle ms-3">{{ trans('rest.menu.dish_option.add_option_category') }}</span>
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
                                                    <li class="breadcrumb-item"><a
                                                            href="{{ route('home') }}">{{ trans('rest.menu.title') }}</a>
                                                    </li>
                                                    <li class="breadcrumb-item active">{{ trans('rest.menu.dish_option.title') }}</li>
                                                </ol>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-0">
                                    <form method="POST" name="addDishOptionForm" id="addDishOptionForm"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="ingredientsnameenglish"
                                                           class="form-label">{{ trans('rest.menu.dish_option.name') }}
                                                        <span class="text-custom-muted">(English)</span></label>
                                                    <input type="text" class="form-control" name="name_en"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="ingredientsnamedutch"
                                                           class="form-label">{{ trans('rest.menu.dish_option.name') }}
                                                        <span class="text-custom-muted">(Dutch)</span></label>
                                                    <input type="text" class="form-control" name="name_nl"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="price"
                                                           class="form-label">{{ trans('rest.menu.dish_option.price') }}
                                                    </label>
                                                    <input type="number" class="form-control" name="price"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="category_id"
                                                           class="form-label">{{ trans('rest.menu.dish_option.dish_option_category') }}</label>
                                                    <select class="form-control w-100" type="button" name="category_id">
                                                        <option
                                                            value="">{{ trans('rest.menu.dish_option.select_category') }}</option>

                                                        @foreach ($dishOptionCategory as $category)
                                                            <option
                                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                                <div class="form-group">
                                                    <label for="discountpercentage"
                                                           class="form-label invisible">{{ trans('rest.menu.dish_option.dish_option_category') }}</label>
                                                    <button type="submit"
                                                            class="btn btn-custom-yellow btn-default d-block w-130px">
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
                                                    class="text-center">{{ trans('rest.menu.dish_option.name') }}
                                                    <span class="text-custom-muted font-regularcustom">(English)</span>
                                                </th>
                                                <th scope="col"
                                                    class="text-center">{{ trans('rest.menu.dish_option.name') }}
                                                    <span class="text-custom-muted font-regularcustom">(Dutch)</span>
                                                </th>
                                                <th scope="col"
                                                    class="text-center">{{ trans('rest.menu.dish_option.price') }}
                                                </th>
                                                <th scope="col"
                                                    class="text-center">{{ trans('rest.menu.dish_option.dish_option_category') }}
                                                </th>
                                                <th scope="col" class="text-center"
                                                    width="5%">{{ trans('rest.button.action') }}</th>
                                                <th scope="col"
                                                    class="text-center">{{ trans('rest.menu.dish_option.individual_dish') }}
<!--                                                    <span
                                                        class="text-custom-muted font-regularcustom">{{ trans('rest.menu.dish_option.free') }}</span>-->
                                                </th>
                                                <th scope="col" class="text-center"
                                                    width="10%">{{ trans('rest.button.action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody id="ingredientTbody">
                                            @foreach ($optionCategory as $ingredient)
                                                <tr id="ingredient-tr{{ $ingredient->id }}" class="ingredientRow"
                                                    data-id="{{ $ingredient->id }}">
                                                    <td class="text-center">
                                                        <input type="text" class="form-control text-center w-10r m-auto"
                                                               id="name_en{{ $ingredient->id }}"
                                                               value="{{ $ingredient->name_en }}" readonly/>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" class="form-control text-center w-10r m-auto"
                                                               id="name_nl{{ $ingredient->id }}"
                                                               value="{{ $ingredient->name_nl }}" readonly/>
                                                    </td>

                                                    <td class="text-center">
                                                        <input type="text" class="form-control text-center w-10r m-auto"
                                                               id="price{{ $ingredient->id }}"
                                                               value="{{ $ingredient->price }}" readonly/>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown buttondropdown category-dropdown">
                                                            <select class="form-control w-100 sm read-only" disabled
                                                                    id="catId{{$ingredient->id}}">
                                                                @foreach ($dishOptionCategory as $category)
                                                                    <option
                                                                        value="{{ $category->id }}" {{ ($category->id == $ingredient->cat_id) ? 'selected' : '' }}>
                                                                        {{ $category->name }}</option>
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
                                                        <div class="table-add-dish-bar align-items-center">
                                                            <select class="btn btn-light dropdown-toggle dish-dropdown"
                                                                    data-id="{{ $ingredient->id }}" type="button"
                                                                    id="dish-list{{ $ingredient->id }}" disabled>
                                                                    <?php
                                                                $excludedDishIds = $ingredient->dishOptions->pluck('dish_id')->toArray();
                                                                // Use whereDoesntHave with whereIn to exclude those dishes
                                                                $dishLists = \App\Models\Dish::whereDoesntHave('dishOption', function ($query) use ($excludedDishIds) {
                                                                    $query->whereIn('dish_id', $excludedDishIds);
                                                                })->get();
                                                                    ?>
                                                                <option value="">Select Dish name</option>
                                                                @foreach($dishLists as $dish)
                                                                    <option value="{{ $dish->id }}"
                                                                            data-name="{{ $dish->name }}">{{ $dish->name }}</option>
                                                                @endforeach
                                                            </select>

                                                            <div
                                                                class="table-dish-name table-dish-badge-wrap align-items-start dish-tray{{ $ingredient->id }}">
                                                                <div class="table-dish-name-wrp">
                                                                    <div class="table-dish-name-inner">
                                                                        <?php
                                                                        $dishCount = 1;
                                                                        ?>
                                                                        @foreach ($ingredient->dishOptions as $ingr)

                                                                            @if($dishCount > 2 )

                                                                                @if($dishCount == 3)
                                                                    </div>
                                                                    <div class="moredishname-collapse collapse "
                                                                         id="collapseDishRowTwo">
                                                                        <div
                                                                            class="card card-body bg-lightgray d-block py-2 px-0 pb-0 border-0">
                                                                            @endif
                                                                                <span class="badge text-bg-yellow mt-1">
                                                                                  {{ $ingr->dish->name }}
                                                                                  <a href="javascript:void(0);">
                                                                                    <i class="fa-solid fa-xmark align-middle del-dish-icon existing-dish"
                                                                                       data-dish-ing-id="{{ $ingr->id }}"
                                                                                       data-dish-id="{{ $ingr->dish->id }}"
                                                                                       data-id="{{ $ingredient->id }}"
                                                                                       data-name="{{ $ingr->dish->name }}"></i>
                                                                                  </a>
                                                                                </span>
                                                                            @else
                                                                                <span class="badge text-bg-yellow mt-1">
                                                                                  {{ $ingr->dish->name }}
                                                                                  <a href="javascript:void(0);">
                                                                                    <i class="fa-solid fa-xmark align-middle del-dish-icon existing-dish"
                                                                                       data-dish-ing-id="{{ $ingr->id }}"
                                                                                       data-dish-id="{{ $ingr->dish->id }}"
                                                                                       data-id="{{ $ingredient->id }}"
                                                                                       data-name="{{ $ingr->dish->name }}">
                                                                                    </i>
                                                                                  </a>
                                                                                </span>
                                                                            @endif
                                                                            <?php
                                                                            $dishCount++
                                                                            ?>
                                                                            @endforeach
                                                                            @if($dishCount > 3)
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <a class="text-more-sm align-self-end float-end lh-base text-center pt-2 more-less-text"
                                                                   id="more-less-text{{ $ingredient->id }}"
                                                                   data-bs-toggle="collapse" href="#collapseDishRowTwo"
                                                                   role="button" aria-expanded="false"
                                                                   aria-controls="collapseDishRowTwo">+ {{ trans('rest.menu.dish_option.more') }}</a>
                                                                @endif

                                                            </div>

                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between gap-1">
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
                                                            <input type="hidden" id="deleted-dish{{ $ingredient->id }}">
                                                            <input type="hidden" id="is_edited{{ $ingredient->id }}"
                                                                   value="0">
                                                            <a class="btn btn-custom-yellow btn-default save-edit-btn d-block"
                                                               id="save-btn{{ $ingredient->id }}"
                                                               style="display:none !important;"
                                                               data-id="{{ $ingredient->id }}">
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
                                        {{ $optionCategory->links() }}
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

    <!-- start delete Ingredients Modal -->
    <div class="modal fade custom-modal" id="deleteAlertModal" tabindex="-1"
         aria-labelledby="deleteAlertModal" aria-hidden="true">
        <div class="modal-dialog custom-w-441px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="hidden" value="" id="ingredientId">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="alert-text-1 mb-40px">{{ trans('rest.modal.dish_option.delete_message') }}</h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button"
                                class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px"
                                data-bs-dismiss="modal">{{ trans('rest.button.cancel') }}
                        </button>
                        <button type="button" id="delete-ingredient-btn"
                                class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-160px">{{ trans('rest.button.delete') }}
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
                            <h4 class="alert-text-1 mb-40px">{{ trans('rest.modal.dish_option.alert_message') }}</h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-160px"
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
        var ingValidationMsg = {
            less: '{{ trans('rest.food_order.less') }}',
            more: '{{ trans('user.food_order.more') }}',
        }
    </script>
    <script type="text/javascript" src="{{ asset('js/dish_option.js')}}"></script>
@endsection
