 <style>
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    .invoice-box table tr.top table td {
        width: 100%;
        display: block;
        text-align: center;
    }
    .tblClass{
        border-collapse: collapse;
    }
    .tblClass td,th {
        border: 1px solid gray;
        padding: 15px;
    }
    .invoice_align{
        text-align:right;
    }
</style>
<?php
    use App\Enums\OrderStatus;
    use App\Enums\OrderType;
    use App\Enums\PaymentStatus;
    use App\Enums\PaymentType;
?>
<div class="invoice-box">
    <table>
        <tr>
            <td colspan="4">
                <?php

                    if($order->order_type == OrderType::Delivery)
                    {
                        echo "<b>".trans('user.invoice.address')."</b><br>";

                        $address = $order->orderUserDetails;

                        echo $address->house_no.' '.$address->street_name.'<br>'.$address->city.'<br>'.$address->zipcode;
                    }
                    else
                    {
                        echo "<b>".trans('user.invoice.restaurant_address')."</b><br>";

                        echo str_replace(',', '<br>', getRestaurantDetail()->rest_address);
                    }
                ?>
            </td>
            <td style="padding-top: 0px;">
                <table cellpadding="0" cellspacing="0" border="0" width="auto" align="right" style="width: auto;">
                    <tr>
                        <td colspan="2" align="right" style="padding-top: 0px;">
                            <h2 style="margin-top: 0px;margin-bottom: 10px;line-height: 16px;">Invoice</h2>
                        </td>
                    </tr>

                    <tr>
                        <td width="150">
                            <b>{{ trans('user.invoice.title') }} #<br>
                            {{ trans('user.invoice.date') }}<br>
                            {{ trans('user.invoice.mode') }}</b>
                        </td>
                        <td>
                            {{ $order->id }}<br>
                            {{ $order->created_at }}<br>
                            {{ $order->payment_type == PaymentType::Card ? trans('user.invoice.card'): ($order->payment_type == PaymentType::Cash ? trans('user.invoice.cash'):'Ideal') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <table class="tblClass">
        <tr style="background-color:#D7DBDD;">
            <th colspan="4">{{ trans('user.invoice.item') }}</th>
            <th>{{ trans('user.invoice.price') }}</th>
            <th>{{ trans('user.invoice.discount') }}</th>
            <th>{{ trans('user.invoice.qty') }}</th>
            <th>{{ trans('user.invoice.amount') }}</th>
        </tr>

        <?php $itemTotalPrice = 0; ?>

        @foreach($order->dishDetails as $key => $dish)
        <tr>
            <td colspan="4">{{ $dish->dish->name }}<br><b>{{ $dish->dishOption->name ?? '' }}</b>{{ getOrderDishIngredients($dish) }}</td>
            <td>€{{ $dish->price }}</td>
            <td>{{ $dish->dish->percentage_off }}%</td>
            <td>{{ $dish->qty }}</td>
            <td>
            <?php
                    $itemPrice = ($dish->price * $dish->qty) + $dish->paid_ingredient_total;
                    $itemTotalPrice += $itemPrice;
                    echo '€'.number_format($itemPrice,2);
            ?>
            </td>
        </tr>
        @endforeach

        <tr>
            <td colspan="8" rowspan="1"></td>
            <br>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="3">{{ trans('user.invoice.subtotal') }}</td>
            <td>€{{ number_format($itemTotalPrice, 2) }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="3">{{ trans('user.invoice.service_charge') }}</td>
            <td>€{{ number_format($order->platform_charge, 2) }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="3">{{ trans('user.invoice.delivery_charge') }}</td>
            <td>€{{ number_format($order->delivery_charge, 2) }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="3">{{ trans('user.invoice.coupon_discount') }}</td>
            <td>€{{ number_format($order->coupon_discount, 2) }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="3">{{ trans('user.invoice.amount_paid') }}</td>
            <td>€{{ number_format($order->total_amount, 2) }}</td>
        </tr>
    </table>
</div>


