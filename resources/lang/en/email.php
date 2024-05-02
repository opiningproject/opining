<?php

return [

	'order_status'  => [
		'subject' => 'Your order #:order_id is :order_status',
		'content' => 'Your order #:order_id is :order_status. Thank you for placing your food order with '.env('APP_NAME')
	],

	'refund_issued'  => [
		'subject' => 'Your refund against order has been issued',
		'content' => 'Thank you for ordered food from the Famfoo app. Your refund against order has been issued. Please find more details below.',
	],

	'common'  => [
		'hello' => 'Hello!',
		'platform_charges' => 'Platform Charges',
		'delivery_charges' => 'Delivery Charges',
		'sub_total' => 'Sub Total',
		'paid' => 'Total',
		'order_id' => 'Order ID',
		'regards' => 'Regards',
		'coupon_discount' => 'Coupon Discount',
		'all_rights_reserved' => 'Copyright 2024 © :app_name All Rights Reserved',
	],
];

