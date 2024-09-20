<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'file_mb'    => 'The :attribute may not be greater than :max Megabytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
       'email' => [
            'required' => 'The email field is required.',
            'email' => 'The email must be a valid email address.',
            'max' => 'The email may not be greater than :max.',
            'unique' => 'The email has already been taken.',
			'checkemail' => 'The email has already been taken.',
        ],
        'username' => [
            'required' => 'The username field is required.',
            'max' => 'The username may not be greater than :max.',
            'unique' => 'The username has already been taken.',
			'not_email' => 'The username must not be an email.',
        ],
        'name' => [
            'required' => 'The name field is required.',
            'max' => 'The name may not be greater than :max.',
			'string' => 'The name must be a string.',
        ],
        'current_password' => [
            'required' => 'The current password field is required.',
			'check_current_password' => 'Please enter correct current password.',
        ],
		'confirm_password' => [
            'required' => 'The confirm password field is required.',
			'same' => 'The confirm password and new password must match.',
        ],
        'new_password' => [
            'required' => 'The new password field is required.',
            'min' => 'The new password must be at least :min.',
        ],
        'password' => [
            'required' => 'The password field is required.',
            'min' => 'The password must be at least :min.',
        ],
		'profile_img' => [
			'required' => 'The profile image field is required.',
			'image' => 'The profile image must be an image.',
			'mimes' => 'The profile image must be a file of type: jpeg, jpg, png.',
			'max' => 'The profile image must not be more than 2 MB.',
		],
		'login' => [
			'required' => 'Please enter your username or email.',
		],
		'forgot_user' => [
			'required' => 'Please enter your username or e-mail address.',
			'string' => 'The username or e-mail address must be a string.',
		],
		'cms_page' => [
			'required' => 'The cms page type is required.',
			'in' => 'The given cms page type is invalid.',
		],
		'contact_number' => [
			'required' => 'The contact number field is required.',
			'regex' => 'The contact number is invalid.',
			'max' => 'The contact number may not be greater than :max.',
		],
		'status' => [
			'required' => 'The status field is required.',
			'in' => 'The selected status is invalid.',
		],
		'content' => [
			'required' => 'The content field is required.',
		],
		'title' => [
            'required' => 'The title field is required.',
            'max' => 'The title may not be greater than :max.',
        ],
		'description' => [
            'required' => 'The description field is required.',
        ],
		'message' => [
			'required' => 'The message field is required.',
			'max' => 'The message may not be greater than :max.',
		],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
