<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UtilController extends Controller
{
    public static function validateRequest($data, $rules)
    {
        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validation->errors()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
