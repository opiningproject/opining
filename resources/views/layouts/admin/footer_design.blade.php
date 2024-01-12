<footer>
    <div class="footer-logo d-flex justify-content-center align-items-center">
        <a href="{{ route('home') }}" style="max-width: 175px;">
            <p class="mb-0">Gomeal<span class="text-yellow-1">.</span></p>
            <div class="text-start" style="padding-left: 60px; padding-right: 15px; margin-top: -25px;">
                <img src="{{ Auth::user()->restaurantDetails->restaurant_logo }}" style="max-width: 100%;">
            </div>
        </a>
    </div>
    <p class="mb-0 footer-copyright-text">Gomeal &copy; 2023 Gomeal - ALL
        Rights Reserved</p>
</footer>
