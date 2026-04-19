<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FormController extends Controller
{
    public function form(): Response
    {
        return response()->view('form');
    }

    public function submitForm(Request $request): Response
    {
        $name = $request->input('name');

        return response()->view('hello', [
            'name' => $name,
        ]);
    }

    public function login(Request $request): Response
    {
        try {
            $rules = [
                'username' => 'required',
                'password' => 'required',
            ];

            $data = $request->validate($rules);

            return response('OK', Response::HTTP_OK);
        } catch (ValidationException $exception) {
            return response($exception->errors(), Response::HTTP_BAD_REQUEST);
        }
    }
}
