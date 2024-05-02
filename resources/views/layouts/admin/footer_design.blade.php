<footer>
    <div class="footer-logo d-flex justify-content-center align-items-center">
        <a href="{{ route('home') }}" style="max-width: 175px;">
            <div class="d-flex">
                <img src="{{ getRestaurantDetail()->footer_logo }}" class="web-logo">
            </div>
        </a>
    </div>
    <p class="mb-0 footer-copyright-text">{{ trans('user.footer.rights_reserved',['app_name' => env('APP_NAME')]) }}</p>
</footer>
