<?php

return [
    'fields' => [
        [
            "component" => "text-field",
            "prefixComponent" => true,
            "attribute" => "name",
            "value" => 'name',
            "panel" => null,
            "sortable" => false,
            "textAlign" => "left"
        ],
        [
            "component" => "text-field",
            "prefixComponent" => true,
            "attribute" => "email",
            "value" => 'email',
            "panel" => null,
            "sortable" => false,
            "textAlign" => "left"
        ],
        [
            "component" => "password-field",
            "prefixComponent" => true,
            "attribute" => "password",
            "value" => null,
            "panel" => null,
            "sortable" => false,
            "textAlign" => "left"
        ],
        [
            "component" => "password-field",
            "prefixComponent" => true,
            "attribute" => "password_confirmation",
            "value" => null,
            "panel" => null,
            "sortable" => false,
            "textAlign" => "left"
        ]
    ],

    'validations' => [
        'name' => 'required|string|min:4|alpha_num',
        'email' => 'required|email',
        'password' => 'nullable|min:6|string|confirmed|required_with:password_confirmation|same:password_confirmation',
        'password_confirmation' => 'nullable|min:6|string'
    ],
];
