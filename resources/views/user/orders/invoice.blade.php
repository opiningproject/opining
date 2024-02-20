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
                        echo "<b>Address</b><br>";

                        $address = $order->orderUserDetails;

                        echo $address->house_no.' '.$address->street_name.'<br>'.$address->city.'<br>'.$address->zipcode;
                    }
                    else
                    {
                        echo "<b>Restaurant Address</b><br>";

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
                            <b>Invoice #<br>
                            Invoice Date<br>
                            Payment Mode</b>
                        </td>
                        <td>
                            {{ $order->id }}<br>
                            {{ $order->created_at }}<br>
                            {{ $order->payment_type == PaymentType::Card ? 'Card': ($order->payment_type == PaymentType::Cash ? 'Cash':'Ideal') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <table class="tblClass">
        <tr style="background-color:#D7DBDD;">
            <th colspan="4">Item</th>
            <th>Price</th>
            <th>Discount</th>
            <th>Quantity</th>
            <th>Amount</th>
        </tr>

        <?php $itemTotalPrice = 0; ?>

        @foreach($order->dishDetails as $key => $dish)
        <tr>
            <td colspan="4">{{ $dish->dish->name }}<br><b>{{ $dish->dishOption->name ?? '' }}</b>-{{ getOrderDishIngredients($dish) }}</td>
            <td>€{{ $dish->price }}</td>
            <td>{{ $dish->dish->percentage_off }}%</td>
            <td>{{ $dish->qty }}</td>
            <td>
            <?php
                    $itemPrice = ($dish->price * $dish->qty) + $dish->orderDishPaidIngredients->sum('total');
                    $itemTotalPrice += $itemPrice;
                    echo '€'.$itemPrice;
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
            <td colspan="3">Subtotal</td>
            <td>€{{ $itemTotalPrice }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="3">Service Charge</td>
            <td>€{{ $order->platform_charge }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="3">Delivery Charge</td>
            <td>€{{ $order->delivery_charge }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="3">Coupon Discount</td>
            <td>€{{ $order->coupon_discount }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td colspan="3">Amount Paid</td>
            <td>€{{ $order->total_amount }}</td>
        </tr>
    </table>
</div>


