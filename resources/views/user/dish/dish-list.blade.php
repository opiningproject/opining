<div class="dish-details-div">
    <div class="category-list-item-grid">
        @if(count($dishes) > 0)
            @foreach ($dishes as $dish)
                    <?php
                    $disableBtn = '';
                    $customizeBtn = false;
                    if ($dish->qty == 0 || $dish->out_of_stock == '1') {
                        $disableBtn = 'disabled';
                        $customizeBtn = true;
                    }

                    if(count($dish->ingredientsWithoutTrash) == 0){
                        $customizeBtn = true;
                    }
                    ?>
                <div class="card food-detail-card">
                    @if($dish->percentage_off > 0)<p class="mb-0 offer-percantage">{{ $dish->percentage_off }}%</p>@endif
                    <p class="mb-0 food-favorite-icon {{ isset($dish->favorite) ? 'd-none':'' }}" onclick="favorite({{ $dish->id }})" id="unfavorite-icon-{{ $dish->id }}">
                        <img src="{{ asset('images/favorite-before-icon.svg') }}" alt="" class="svg" height="20" width="22">
{{--                        </svg>--}}
                    </p>
                    <p class="mb-0 food-favorite-icon {{ isset($dish->favorite) ? '':'d-none' }}" onclick="unFavorite({{ $dish->id }})" id="favorite-icon-{{ $dish->id }}">
                        <img src="{{ asset('images/favorite-after-icon.svg') }}" alt="" class="svg" height="20" width="22">
                    </p>
                    <div class="food-image">
                        <img src="{{ $dish->image }}" alt="burger imag" class="img-fluid" width="100" height="100"/>
                    </div>
                    <h4 class="food-name-text">{{ $dish->name }}</h4>
                    {{-- <p class="food-price">€{{ number_format($dish->price, 2) }}</p> --}}
                    <button type="button" class="btn btn-xs-sm btn-custom-yellow" onclick="customizeDish({{ $dish->id }})" id="dish-cart-lbl-{{ $dish->id }}" {{ $disableBtn }}>
{{--                        @if($dish->qty == 0 || $dish->out_of_stock == '1')--}}
                        @if($dish->out_of_stock == '1')
                            {{ trans('user.dashboard.out_of_stock') }}
                        @else
                            <img src="{{ asset('images/plus.svg') }}" alt="" class="svg" height="9" width="9">€{{ number_format($dish->price, 2) }}
                        @endif
                    </button>
                    @if(!$customizeBtn)
                        <label class="customize-foodlink">{{ trans('user.dashboard.customizable') }}</label>
                        {{--                    <a href="javascript:void(0);" class="customize-foodlink" onclick="customizeDish({{ $dish->id }});">Customize</a>--}}
                    @endif
                </div>
            @endforeach
        @else
            {{ trans('user.dashboard.no_dish_found') }}
        @endif
    </div>
</div>
