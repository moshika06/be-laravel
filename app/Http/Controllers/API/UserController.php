<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::get();
            return response()->json([
                'status' => true,
                'message' => 'Fetch data success',
                'data' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Internal server error',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|mid:8'
            ]);
            if ($validation->fails()) {
                return response()->json([
                    'message' => 'Validation Fail',
                    'error' => $validation->errors()
                ]);
            }

            $user = User::create([
                'name' => 'request|name',
                'email' => 'request|email',
                'password' => 'request|password',
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Create user success',
                'data' => $user,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Internal server error',
                'data' => $th->getMessage()
            ]);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
