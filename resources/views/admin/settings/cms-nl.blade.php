<div class="tab-pane fade cmsPagesdutch" id="cmsPagesdutch-tab-pane" role="tabpanel" aria-labelledby="cmsPagesdutch-tab" tabindex="0">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
            <h3 class="text-custom-muted mb-0 tab-title"></h3>
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="content_nl" id="btnradio3" autocomplete="off" checked onchange="changeContent('privacy-nl');" />
                <label class="btn btn-sm btn-outline-custom-yellow text-muted-default" for="btnradio3">{{ trans('rest.settings.cms.privacy') }}</label>

                <input type="radio" class="btn-check" name="content_nl" id="btnradio4" autocomplete="off" onchange="changeContent('terms-nl');" />
                <label class="btn btn-sm btn-outline-custom-yellow text-muted-default" for="btnradio4">{{ trans('rest.settings.cms.terms') }}</label>
            </div>
        </div>

        <div class="custom-editor-box" id="privacy_box_nl" style="display: block;">
            <textarea id="privacy-nl">
            {{ $privacy_policy_nl }}
            </textarea>
        </div>
        <div class="custom-editor-box" id="terms_box_nl" style="display: none;">
            <textarea id="terms-nl">
            {{ $terms_nl }}
            </textarea>
        </div>
    </div>

    <input type="hidden" name="type" id="type" value="privacy">

    <div class="card-footer bg-white border-0">
        <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                <a class="btn btn-site-theme btn-default" onclick="saveContent('nl');">
                    <span class="align-middle">{{ trans('rest.button.save') }}</span>
                </a>
            </div>
        </div>
    </div>
</div>