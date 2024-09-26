<div class="tab-pane fade cmsPagesen" id="cmsPagesen-tab-pane" role="tabpanel" aria-labelledby="cmsPagesen-tab"
    tabindex="0">

    <h2 class="content-title">CMS Pages(English)</h2>

    <div class="card-body bg-white">
        <div class="d-flex align-items-center justify-content-between">
            <h3 class="text-custom-muted mb-0 tab-title"></h3>
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="content_en" id="btnradio1" autocomplete="off" checked
                    onchange="changeContent('privacy-en');" />
                <label class="btn btn-sm btn-outline-custom-yellow text-muted-default" for="btnradio1"
                    name="privacy_policy">{{ trans('rest.settings.cms.privacy') }}</label>

                <input type="radio" class="btn-check" name="content_en" id="btnradio2" autocomplete="off"
                    onchange="changeContent('terms-en');" />
                <label class="btn btn-sm btn-outline-custom-yellow text-muted-default" for="btnradio2"
                    name="terms">{{ trans('rest.settings.cms.terms') }}</label>
            </div>
        </div>

        <div class="custom-editor-box" id="privacy_box_en" style="display: block;">
            <textarea id="privacy-en">
            {{ $privacy_policy_en }}
            </textarea>
        </div>
        <div class="custom-editor-box" id="terms_box_en" style="display: none;">
            <textarea id="terms-en">
            {{ $terms_en }}
            </textarea>
        </div>
    </div>

    <input type="hidden" name="type" id="type" value="privacy">

    <div class="card-footer bg-white border-0">
        <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                <a class="btn btn-site-theme btn-default" onclick="saveContent('en');">
                    <span class="align-middle">{{ trans('rest.button.save') }}</span>
                </a>
            </div>
        </div>
    </div>
</div>
