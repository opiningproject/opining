<div class="popular-item-grid">
    @if(count($dishes) > 0)
        @foreach ($dishes as $dish)
            <div class="card food-detail-card dish-card-div{{ $dish->id }}">
                @if($dish->out_of_stock == '1')
                    <p class="mb-0 inoutstock-badge text-bg-danger-1">Out of stock</p>
                @else
                    <p class="mb-0 inoutstock-badge text-bg-success-1">In stock</p>
                @endif
                <div class="card-body p-0">
                    <p class="quantity-text badge">Qty:{{ $dish->qty }}</p>
                    <div class="food-image">
                        <img src="{{ $dish->image }}" alt="burger imag" class="img-fluid"/>
                    </div>
                    <h4 class="food-name-text">{{ $dish->name }}</h4>
                    <p class="food-price">€{{ $dish->price }}</p>
                    <div class="food-detail-card-btn">
                        <a href="{{ route('editDish', $dish->id) }}"
                           class="btn btn-custom-yellow btn-icon" data-id="{{ $dish->id }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a class="btn btn-custom-yellow btn-icon" data-bs-toggle="modal"
                           data-bs-target="#deleteDishAlertModal" data-id="{{ $dish->id }}">
                            <i class="fa-regular fa-trash-can"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div>
            No Dish Exist
        </div>
    @endif
</div>
