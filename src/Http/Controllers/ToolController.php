<?php

namespace Runline\ProfileTool\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class ToolController extends Controller
{
    public function index()
    {
        return response()->json([
            [
                "component" => "text-field",
                "prefixComponent" => true,
                "indexName" => __("ឈ្មោះ"),
                "name" => __("ឈ្មោះ"),
                "attribute" => "name",
                "value" => auth()->user()->name,
                "panel" => null,
                "sortable" => false,
                "textAlign" => "left"
            ],
            [
                "component" => "text-field",
                "prefixComponent" => true,
                "indexName" => __("សារអេឡិចត្រូនិច"),
                "name" => __("សារអេឡិចត្រូនិច"),
                "attribute" => "email",
                "value" => auth()->user()->email,
                "panel" => null,
                "sortable" => false,
                "textAlign" => "left"
            ],
            [
                "component" => "password-field",
                "prefixComponent" => true,
                "indexName" => __("លេខសម្ងាត់"),
                "name" => __("លេខសម្ងាត់"),
                "attribute" => "password",
                "value" => null,
                "panel" => null,
                "sortable" => false,
                "textAlign" => "left"
            ],
            [
                "component" => "password-field",
                "prefixComponent" => true,
                "indexName" => __("លេខសម្ងាត់បញ្ជាក់"),
                "name" => __("លេខសម្ងាត់បញ្ជាក់"),
                "attribute" => "password_confirmation",
                "value" => null,
                "panel" => null,
                "sortable" => false,
                "textAlign" => "left"
            ]
        ]);
    }

    public function store()
    {
        $validations = config('nova-profile-tool.validations');

        request()->validate($validations);

        $fields = request()->only(array_keys($validations));

        if (empty($fields['password'])) {
            unset($fields['password']);
        } else {
            $fields['password'] = Hash::make($fields['password']);
        }

        auth()->user()->update($fields);

        return response()->json([
            "status" => 200,
            "msg" => "អ្នកបានធ្វើបច្ចុប្បន្នភាពprofileបានជោគជ័យ"
        ]);
    }
}
