<?php
return [
	'order_status' => [
		'accepted' => 'Order Accepted',
		'in_kitchen' => 'In kitchen',
		'ready' => 'Ready',
		'ready_for_pickup' => 'Ready For Pickup',
		'out_for_delivery' => 'Out For Delivery',
		'delivered' => 'Delivered',
	],

	'refund_status' => [
		'accepted' => 'Accepted',
		'rejected' => 'Rejected',
	],

	'sidebar' => [
		'menu' => 'Menu',
		'food_order' => 'Food Order',
		'settings' => 'Settings',
		'my_finance' => 'My Finance',
		'coupons' => 'Coupons',
		'user_chat' => 'User Chat',
		'open' => 'Open',
        'all' => 'All',
	],

	'menu' => [
		'title' => 'Menu',
		'search' => 'Search dishes...',
		'add_category' => 'Add New Category',
		'add_ingred' => 'Add New Ingredient',
		'add_dish' => 'Add New Dish',
		'categories' => 'Categories',
		'no_category' => 'No Category exist',
		'dishes' => 'Dishes',
		'no_dish' => 'No Dish Found',
		'popular_week' => 'Popular This Week',
		'best_seller' => 'Best Seller',
		'sold_dishes' => 'Sold :sold_qty dishes',
		'category' => [
			'add' => 'Add Category',
			'edit' => 'Edit Category',
			'dish_category' => 'Dish Category'
		],

		'dish' => [
			'out_of_stock' => 'Out of stock',
			'in_stock' => 'In stock',
			'qty' => 'Qty',
			'edit' => 'Edit Dish',
			'add' => 'Add Dish',
			'dish_image' => 'Dish Image',
			'item_image' => 'Upload Image of Item',
			'dish_name' => 'Dish Name',
			'category' => 'Dish Category',
			'select_category' => 'Select Category',
			'discount_per' => 'Discount Percentage',
			'quantity' => 'Quantity',
			'dish_price' => 'Dish Price',
			'description' => 'Dish Description',
			'option' => 'Dish Option',

			'free_ingred' => 'Raw Ingredients(Free)',
			'ingred_categories' => 'Ingredients Categories',
			'ingred_list' => 'Ingredients List',
			'no_ingred' => 'No Ingredient Attached',
			'extra_ingred' => 'extra toppings Ingredients',

			'select_ingred_category' => 'Select Ingredient Category',
			'select_ingred' => 'Select Ingredient',
			'image' => 'Image',
			'name' => 'Name',
			'price' => 'Price',
            'select_option' => 'Please fill option value to add data',
            'save_ingredient' => 'Ingredient Added Successfully',

            'popular_dishes' => 'Popular Dishes',
            'no_popular' => 'No Popular Dish Found',
            'bestseller_dishes' => 'Best Seller Dishes',
            'no_bestseller' => 'No Bestseller Dish Found',
		],

		'ingredients' => [
			'title' => 'Ingredients',
			'add_category' => 'Add New Ingredient Categories',
			'name' => 'Name',
			'image' => 'Image',
			'ingred_name' => 'Ingredient Name',
			'ingred_category' => 'Ingredient Categories',
			'individual_dish' => 'Add For Individual dish',
			'ingred_categories' => 'Ingredient Categories',
			'item_image' => 'Upload Image of Item',
			'select_category' => 'Select Category',
			'click_to_update' => 'Click to update',
			'free' => '(Free)',
			'more' => '(More)'
		]
	],

	'food_order' => [
        'order_details' => 'Order Details',
		'title' => 'Food Order',
		'filter' => 'Filter Orders',
		'today' => 'Today',
		'week' => 'This week',
		'month' => 'This month',
		'order' => 'Order',
		'order_type' => 'Order Type',
		'no_order' => 'No orders',
		'order_list' => 'Order List',
		'notes' => 'Notes',
		'items' => 'Items',
		'ASAP' => 'ASAP',
		'pickup' => 'Pickup',
		'delivery' => 'Delivery',
		'cod' => 'Cash On Delivery',
		'delivery_mode' => 'Delivery Mode',
		'payment_method' => 'Payment Method',
		'type' => 'Order Type',
		'item_list' => 'Item List',
		'instruction' => 'Delivery Instruction',
		'card' => 'Card',

		'total' => 'Total',
		'bill_details' => 'Bill Details',
		'item_total' => 'Item Total',
		'service_charge' => 'Service charge',
		'delivery_charge' => 'Delivery charge',
		'free_delivery' => 'Free Delivery',
		'discount' => 'Item Discount',
		'print' => 'Print Label',
		'order_time' => 'Order Time',
		'order_amount' => 'Amount',
		'order_description' => 'Description',
		'order_price' => 'Price',
		'order_enjoy' => 'Enjoy your food!',

		'read_more' => 'Read More',
		'close' => 'Close',
		'move_to' => 'Move to',
        'more' => 'More',
        'less' => 'Less',
	],

	'settings' => [
		'title' => 'Settings',
		'profile' => [
			'title' => 'Restaurant Profile',
			'name' => 'Restaurant Name',
			'permit_id' => 'Restaurant Permit ID',
			'phone' => 'Phone',
			'owner_name' => 'Owner Name',
			'email' => 'Email',
			'password' => 'Password',
			'logo' => 'Restaurant Logo',
			'footer_logo' => 'Restaurant Footer Logo',
			'order_acceptance' => 'Online Order Acceptance',
			'notification_sound' => 'Order Notification Sound',
			'address_details' => 'Address Details',
			'permit_doc' => 'Company Permit Document',
			'service_charge' => 'Service Charge',
			'opening_hours' => 'Restaurant Opening Hours',
			'logout' => 'Logout',
			'delivery_time' => 'Delivery Time',
			'take_away_time' => 'Take Away Time'
		],
		'payment' => [
			'history' => 'Payment History',
			'refund_payment' => 'Refund Payment',
			'order_id' => 'Order ID',
			'type' => 'Payment Type',
			'trans_id' => 'Transaction ID',
			'delivery_add' => 'Delivery Address',
			'date_and_time' => 'Date and Time',
			'price' => 'Price',
			'reason' => 'Reason',
			'username' => 'Username',
			'total' => 'Total',
			'card' => 'Card',
			'cash' => 'Cash',
			'accepted' => 'Accepted',
			'rejected' => 'Rejected',
			'accept' => 'Accept',
			'reject' => 'Reject',
		],
		'zipcode' => [
			'title' => 'Zip Code',
			'min_order_price' => 'Minimum Order Price',
			'delivery_charges' => 'Delivery Charges',
			'status' => 'Status',
		],
		'cms' => [
			'title' => 'CMS Pages',
			'privacy' => 'Privacy Policy',
			'terms' => 'Terms & Conditions',
		]
	],

	'my_finance' => [
		'title' => 'My Finance',
		'total_income' => 'Total Income',
		'income' => 'Income',
		'total_revenue' => 'Total Revenue',
		'monthly' => 'Monthly',
		'weekly' => 'Weekly',
		'yearly' => 'Yearly',
		'online' => 'Online',
		'cod' => 'COD',
		'delivery' => 'Delivery',
		'take_away' => 'Take Away',
		'chart_loading' => 'Chart is loading!',
        'delivery_income' => 'Online Delivery',
        'take_away_income' => 'Take Away',
	],

	'coupons' => [
		'title' => 'Coupons',
		'promo_code' => 'Promo code',
		'per_off' => 'Percentage Off',
		'valid_until' => 'Valid Until',
		'edit' => 'Edit Coupon',
		'add' => 'Add Coupon',
		'off' => 'Off',
		'points' => 'Points',
		'min_order_price' => 'Minimum Order Price',
		'validity_date' => 'Validity Date',
		'description' => 'Description',
		'claim_history' => 'Claim History',
		'order_id' => 'Order ID',
		'username' => 'Username',
		'date_time' => 'Date & Time',
		'order_price' => 'Order Price',
		'coupon' => 'Coupon',
        'enter_coupon' => 'Please enter coupon',
	],

	'user_chat' => [
		'title' => 'User Chat',
        'chat' => 'Chat',
		'search' => 'Search',
		'send' => 'Send',
		'write_msg' => 'Write your message',
        'online' => 'Online',
        'offline' => 'Offline',
	],

	'modal' => [
		'category' => [
			'add' => 'Add Category',
			'edit' => 'Edit Category',
			'category' => 'Dish Category',
			'image' => 'Please upload image of Category',
			'delete_message' => 'Are you sure you want to delete this Category?'
		],
		'dish' => [
			'delete_message' => 'Are you sure you want to delete this Dish?',
			'alert_message' => 'There are dishes added to this category. Please remove them to delete.',
		],
		'ingred' => [
			'delete_message' => 'Are you sure you want to delete this Ingredient?',
			'alert_message' => 'There are dishes added to this ingredients. Please remove them to delete this ingredient.',
		],

		'ingred_category' => [
			'delete_message' => 'Are you sure you want to delete this Ingredient?',
			'alert_message' => 'There are dishes/Ingredient added to this Category. Please remove them to delete.',
		],

		'zipcode' => [
			'delete_message' => 'Are you sure you want to delete this zipcode?',
		],

		'coupon' => [
			'delete_message' => 'Are you sure you want to delete this coupon?',
		],

		'cms' => [
			'alert_message' => 'Your content has been successfully saved !!',
		],

		'order_status' => [
			'alert_message' => 'Do you want to change the status to',
		],

		'change_password' => [
			'title' => 'Change Password',
			'old_password' => 'Old Password',
			'new_password' => 'New Password',
			'c_password' => 'Confirm New Password',
			'incorrect_password' => 'Old Password is not correct',
		]
	],

	'button'=> [
		'rows_per_page' => 'Rows per Page',
		'save' => 'Save',
		'ok' => 'Ok',
		'yes' => 'Yes',
		'no' => 'No',
		'cancel' => 'Cancel',
		'submit' => 'Submit',
		'update' => 'Update',
		'delete' => 'Delete',
		'view_all' => 'View all',
		'action' => 'Action',
		'add' => 'Add',
		'login' => 'Login',
		'send_password_link' => 'Send Password Reset Link',
	],

	'auth' => [
		'email' => 'Email',
            'password' => 'Password',
		'new_password' => 'New Password',
		'c_new_password' => 'Confirm New Password',
		'forgot_password' => 'Forgot Password',
		'reset_password' => 'Reset Password',
	],

	'message' => [
		'password_success' => 'Password updated successfully',
		'went_wrong' => 'Something went wrong. Please try again later.',
		'category_delete_success' => 'Category Deleted Successfully',
		'category_add_success' => 'Category Added Successfully',
		'category_update_success' => 'Category Updated Successfully',

		'coupon_delete_success' => 'Coupon Deleted Successfully',
		'coupon_add_success' => 'Coupon Added Successfully',
		'coupon_update_success' => 'Coupon Updated Successfully',
		'coupon_status_success' => 'Coupon status updated successfully',

		'dish_update_success' => 'Dish Updated Successfully',
		'dish_delete_success' => 'Dish Deleted Successfully',

		'dish_ingre_delete_success' => 'Dish Ingredient Deleted successfully',

		'ingredient_delete_success' => 'Ingredient Deleted successfully',
		'ingredient_updated_success' => 'Ingredient Updated successfully',
		'ingredient_status_success' => 'Ingredient status updated successfully',

		'image_type_error' => 'You must select an image file only',
		'image_size_error' => 'Your image is too big, it must be within 1080 X 1080 pixels',

		'zipcode_delete_success' => 'Zipcode Deleted Successfully',
		'zipcode_add_success' => 'Zipcode Added Successfully',
		'zipcode_update_success' => 'Zipcode Updated Successfully',
		'zipcode_status_success' => 'Zipcode status updated successfully',
		'settings_update_success' => 'Settings updated successfully',

		'time_error' => 'Start Time should be less than End Time',
		'password_error' => 'Password must have atleast 1 capital character, 1 small character, 1 digit and 1 symbol',

        'quantity_max' => 'You can not add more quantity.',
	],

];
