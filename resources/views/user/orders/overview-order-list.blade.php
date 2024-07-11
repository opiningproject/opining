@foreach($orders as $key => $ord)
<div onclick="orderDetail({{ $ord->id }})" style="cursor: pointer;"
     class="{{ $ord->id == $order->id ? 'active':'' }} orders-item d-flex align-items-center justify-content-between gap-2"
     id="order-{{ $ord->id }}">
    <div class="text-grp">
        <div class="title">{{ trans('user.my_orders.order') }}
            #{{ $ord->id }}</div>
        <div class="text">{{ $ord->created_at }}</div>
    </div>
    <div class="price"><span>€</span>{{ number_format($ord->total_amount, 2) }}</div>
    <button class="border-none outline-none arrow-with-bg">
        <img src="{{ asset('images/chevron-down.svg') }}"
             class="img-fluid svg" alt="" width="32" height="32">
    </button>
</div>
@endforeach
