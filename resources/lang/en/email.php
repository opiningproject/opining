<?php

return [

    'account' => [
        'welcome' => 'Welcome',
        'subject' => 'Welcome to :rest_name',
        'content' => "Thank you for creating an account with us! You're now part of the :rest_name. Get ready for exclusive offers and updates",
    ],

	'order_status'  => [
		'subject' => 'Your order #:order_id is :order_status',
		'content' => 'Your order #:order_id is :order_status. Thank you for placing your food order with '.env('APP_NAME')
	],

    'admin' => [
        'order' => [
            'subject' => 'New Order Received: :order_no',
            'content' => "We hope this message finds you well. We're excited to inform you that a new order has been received at :rest_name",
            'order_details_title' => 'Here are the details of the order:'
        ],
        'coupon' => [
            'subject' => 'Earn Points on Your Next Order and Unlock a Coupon Code!',
            'content1' => "Exciting news! We're thrilled to introduce our new rewards program, designed to thank you for your continued support. Now, every purchase you make earns you points that you can redeem for exclusive rewards, including special coupon codes.",
            'content2' => "Accumulate points to unlock coupon codes for future purchases. To kick-start your points collection, simply place an order today. You're already on your way to unlocking fantastic discounts!"
        ],
        'dish' => [
            'subject' => 'Exciting News: New Dish Added to Our Menu!',
            'content1' => "We're thrilled to inform you that we've added a delicious new dish to our menu! Introducing :dish_name. To give you a taste of what's in store, here's a sneak peek:",
            'content2' => "Visit us soon to savor this delectable addition to our menu and indulge in a culinary journey like no other.",
        ],
        'refund' => [
            'subject' => 'Refund Issued for Your Order :order_no',
            'content1' => 'We hope this email finds you well.',
            'content2' => 'We regret to inform you that there has been an issue with your recent order (:order_no). Due to unforeseen circumstances, we were unable to fulfill your order as expected. As a result, we have processed a refund for the total amount of your order.',
            'content3' => "Please allow 4-5 business days for the refund to reflect in your account, depending on your bank's processing time. If you have any questions or need further assistance, feel free to reach out.",
            'content4' => "Thank you for your understanding.",
        ],
        'refund_reject' => [
            'subject' => 'Refund Rejected for Your Order :order_no',
            'content1' => 'We hope this email finds you well. We regret to inform you that the refund request for your order (:order_no) is been rejected.',
            'content2' => 'If you have any questions or need further assistance, feel free to reach out.',
            'content3' => 'Thank you for your understanding.',
        ]
    ],

    'user' => [
        'refund' => [
            'subject' => 'Refund Requested for Your Order :order_no',
            'content1' => "I hope this message finds you well. I am writing to request a refund for my recent order #:order_no from :rest_name",
            'content2' => 'I kindly ask for your prompt attention to this matter. Thank you for your understanding and assistance.',
        ],
        'order' => [
            'subject' => 'New Order: :order_no',
            'content1' => "We hope this message finds you well. We're excited to inform you that a new order has been placed.",
            'content2' => 'Please ensure that the order is prepared promptly and with utmost care. We trust in your expertise to provide an exceptional dining experience to our valued customers.',
            'content3' => "Thank you for your dedication and commitment to excellence.",
            'order_details_title' => 'Here are the details of the order:'
        ],
    ],

	'refund_issued'  => [
		'subject' => 'Your refund against order has been issued',
		'content' => 'Thank you for ordered food from the Famfoo app. Your refund against order has been issued. Please find more details below.',
	],

    'common'  => [
        'hello' => 'Hello!',
        'dear' => 'Dear',
        'platform_charges' => 'Platform Charges',
        'delivery_charges' => 'Delivery Charges',
        'sub_total' => 'Sub Total',
        'paid' => 'Total',
        'date_time' => 'Date and Time',
        'cust_name' => 'Customer Name',
        'contact_info' => 'Contact Information',
        'del_address' => 'Delivery Address',
        'refund_details' => 'Refund Details',
        'refund_amount' => 'Refund Amount',
        'refund_method' => 'Refund Method',
        'special_ins' => 'Special Instructions',
        'order_items' => 'Order Items',
        'total_amount' => 'Total Amount',
        'order_id' => 'Order ID',
        'order_no' => 'Order Number',
        'best_wishes' => 'Thank you for choosing :rest_name. We look forward to serving you soon!',
        'regards' => 'Regards',
        'best_regards' => 'Best Regards',
        'coupon_discount' => 'Coupon Discount',
        'all_rights_reserved' => 'Copyright 2024 © :app_name All Rights Reserved',
    ],

    'text' => [
        'refund_success' => 'Your refund has been processed successfully for :order_no. Please allow a few days for it to reflect in your account',
        'refund_cancel' => 'Your refund request has been cancelled for :order_no.',
        'order_placed' => "Your order has been placed! We'll notify you once it's on its way. Thank you for ordering with us!",
    ]
];

