<div class="tab-pane fade" id="banner-tab-pane" role="tabpanel" aria-labelledby="banner-tab"
     tabindex="0">
    <div class="card-body">
        <div class="card-custom-body">
            <!-- start edit dish card section -->
            <section class="">
                <div class="card editdish-card ingredients-card">
                    <div class="card-header border-0 bg-white border-bottom-0">
                        <div class="row">

                        </div>
                    </div>
                    <div class="card-body py-0">
                        <form method="POST" name="add-banner-form" action="{{ route('banners.store') }}"
                              id="add-banner-form"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="imageupload-box inline-imageupload-box">
                                        <label for="ingredientsnameenglish"
                                               class="form-label">{{ trans('rest.my_website.banners.image') }}
                                        </label>
                                        <label for="input-file"
                                               class="upload-file justify-content-center gap-2">
                                            <img src="{{ asset('images/blank-img.svg')}}" id="img-preview"
                                                 class="img-fluid" height="35" width="27">
                                            <p class="mb-0"
                                               id="img-label">{{ trans('rest.my_website.banners.item_image') }}</p>
                                        </label>
                                        <input type="file" id="input-file" class="d-none" name="image">
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="contentenglish"
                                               class="form-label">{{ trans('rest.my_website.banners.content') }}
                                            <span class="text-custom-muted">(English)</span></label>
                                        <input type="text" class="form-control" name="content_en"/>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="contentdutch"
                                               class="form-label">{{ trans('rest.my_website.banners.content') }}
                                            <span class="text-custom-muted">(Dutch)</span></label>
                                        <input type="text" class="form-control" name="content_nl"/>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <button type="submit"
                                                class="btn btn-site-theme btn-default d-block w-130px">
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
                                    <th scope="col" width="12%"
                                        class="text-center">{{ trans('rest.my_website.banners.image') }}</th>
                                    <th scope="col"
                                        class="text-center">{{ trans('rest.my_website.banners.content') }}
                                        <span class="text-custom-muted font-regularcustom">(English)</span>
                                    </th>
                                    <th scope="col"
                                        class="text-center">{{ trans('rest.my_website.banners.content') }}
                                        <span class="text-custom-muted font-regularcustom">(Dutch)</span>
                                    </th>
                                    <th scope="col" class="text-center"
                                        width="5%">{{ trans('rest.button.action') }}</th>
                                    <th scope="col" class="text-center"
                                        width="10%">{{ trans('rest.button.action') }}</th>
                                </tr>
                                </thead>
                                <tbody id="bannerTbody">
                                @foreach ($bannersData as $bannerData)
                                    <tr id="banner-tr{{ $bannerData->id }}" class="bannerRow"
                                        data-id="{{ $bannerData->id }}">
                                        <td scope="row" class="text-center">
                                            <img src="{{ $bannerData->image }}" class="img-fluid"
                                                 id="ing-exist-img{{ $bannerData->id }}"
                                                 style="height: 60px !important;" alt="banner img 1"/>
                                            <div class="imageupload-box inline-imageupload-box mb-0"
                                                 style="display: none" id="img-div{{ $bannerData->id }}">
                                                <label for="banner-image{{ $bannerData->id }}"
                                                       class="upload-file">
                                                    <input type="file" class="banner-image-file"
                                                           id="banner-image{{ $bannerData->id }}"
                                                           data-id="{{ $bannerData->id }}">
                                                    <img src="{{ $bannerData->image }}" alt="tomatoes image"
                                                         id="banner-img-preview{{ $bannerData->id }}"
                                                         class="img-fluid" width="25" height="25">
                                                    <p class="mb-0 text-lowercase">{{ trans('rest.my_website.banners.click_to_update') }}</p>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <input type="text" class="form-control text-center w-10r m-auto"
                                                   id="content_en{{ $bannerData->id }}"
                                                   value="{{ $bannerData->content_en }}" readonly/>
                                        </td>
                                        <td class="text-center">
                                            <input type="text" class="form-control text-center w-10r m-auto"
                                                   id="content_nl{{ $bannerData->id }}"
                                                   value="{{ $bannerData->content_nl }}" readonly/></td>
                                        <td class="text-center">
                                            <div class="form-group mb-0">
                                                <div
                                                    class="form-check form-switch form-switch-sm custom-switch justify-content-center ps-0">
                                                    <input
                                                        class="form-check-input green-check-input update-ing-status update-banner-status-{{$bannerData->id}} "
                                                        value="{{ $bannerData->id }}"
                                                        type="checkbox" role="switch"
                                                        id="action" {{ ($bannerData->status == 1) ? 'checked' : ''  }}>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div
                                                class="d-flex align-items-center justify-content-between gap-1">
                                                <a class="btn btn-site-theme btn-icon edit-banner-btn"
                                                   tabindex="0" data-id="{{ $bannerData->id }}"
                                                   id="edit-btn{{ $bannerData->id }}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a class="btn btn-site-theme btn-icon del-banner-btn"
                                                   data-id="{{ $bannerData->id }}"
                                                   id="del-btn{{ $bannerData->id }}">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </a>
                                                <input type="hidden" id="deleted-dish{{ $bannerData->id }}">
                                                <input type="hidden" id="is_edited{{ $bannerData->id }}"
                                                       value="0">
                                                <a class="btn btn-site-theme btn-default save-edit-btn d-block"
                                                   id="save-btn{{ $bannerData->id }}"
                                                   style="display:none !important;"
                                                   data-id="{{ $bannerData->id }}">
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
                            {{ $bannersData->links() }}
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
    </div>
</div>

<!-- start delete Ingredients Modal -->
<div class="modal fade custom-modal" id="deleteAlertModal" tabindex="-1"
     aria-labelledby="deleteAlertModal" aria-hidden="true">
    <div class="modal-dialog custom-w-441px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <input type="hidden" value="" id="bannerId">
                <div class="row">
                    <div class="col-12">
                        <h4 class="alert-text-1 mb-40px">{{ trans('rest.modal.banner.delete_message') }}</h4>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button"
                            class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px"
                            data-bs-dismiss="modal">{{ trans('rest.button.cancel') }}
                    </button>
                    <button type="button" id="delete-ingredient-btn"
                            class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-160px">{{ trans('rest.button.delete') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end delete Ingredients Modal -->
