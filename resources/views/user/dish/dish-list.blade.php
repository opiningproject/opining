<div class="dish-details-div">
    <div class="category-list-item-grid">
        @if(count($dishes) > 0)
            @foreach ($dishes as $dish)
                <div class="card food-detail-card">
                    <p class="mb-0 offer-percantage">{{ $dish->percentage_off }}%</p>
                    <p class="mb-0 food-favorite-icon {{ isset($dish->favorite) ? 'd-none':'' }}"
                       onclick="favorite({{ $dish->id }})" id="unfavorite-icon-{{ $dish->id }}">
                        <img src="{{ asset('images/favorite-before-icon.svg') }}" alt="" class="svg" height="20"
                             width="22">

                        </svg>
                    </p>
                    <p class="mb-0 food-favorite-icon {{ isset($dish->favorite) ? '':'d-none' }}"
                       onclick="unFavorite({{ $dish->id }})" id="favorite-icon-{{ $dish->id }}">
                        <img src="{{ asset('images/favorite-after-icon.svg') }}" alt="" class="svg" height="20"
                             width="22">

                    </p>
                    <div class="food-image">
                        <img src="{{ $dish->image }}" alt="burger imag" class="img-fluid" width="100" height="100"/>
                    </div>
                    <h4 class="food-name-text">{{ $dish->name }}</h4>
                    <p class="food-price">€{{ $dish->price }}</p>
                    <button type="button" class="btn btn-xs-sm btn-custom-yellow" onclick="addToCart({{ $dish->id }})"
                            id="dish-cart-lbl-{{ $dish->id }}" {{ $dish->cart ? 'disabled':''}}>
                        @if($dish->cart)
                            Added to cart
                        @else
                            Add
                            <img src="{{ asset('images/plus.svg') }}" alt="" class="svg" height="9" width="9">
                        @endif
                    </button>
                    <a href="javascript:void(0);" class="customize-foodlink" onclick="customizeDish({{ $dish->id }});">Customize</a>
                </div>
            @endforeach
        @else
          No such dish exist
        @endif
    </div>
</div>
