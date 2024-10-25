@if(count($dishes) > 0)
    @foreach ($dishes as $dish)
        <?php
        $disableBtn = '';
        $customizeBtn = false;

        //                                        if ($dish->qty == 0 || $dish->out_of_stock == '1') {
        if ($dish->out_of_stock == '1') {
            $disableBtn = 'disabled';
            $customizeBtn = true;
        }

        if (count($dish->ingredientsWithoutTrash) == 0) {
            $customizeBtn = true;
        }

        ?>
        <div class="order-listing-col">
            <div class="dish-box">
                @if ($dish->percentage_off > 0)
                    <label class="discount">{{ $dish->percentage_off }}%</label>
                @endif
                <div class="image">
                    <img src="{{ $dish->image }}" alt=""/>
                </div>

                <div class="details">
                    <h3>{{ $dish->name }}</h3>
                    <button type="button" class="btn price-btn"
                            onclick="customizeDish({{ $dish->id }})" {{ $disableBtn }}
                            id="dish-cart-lbl-{{ $dish->id }}">
                        @if ($dish->out_of_stock == '1')
                            {{ trans('user.dashboard.out_of_stock') }}
                        @else
                            <img src="{{ asset('images/plus-up.svg') }}" class="svg"
                                 height="9"
                                 width="9">€{{ number_format($dish->price, 2) }}
                        @endif
                    </button>
                    <a href="#" class="customizable">Customizable</a>
                </div>
            </div>
        </div>
    @endforeach
@else
    {{ trans('user.dashboard.no_dish_found') }}
@endif
