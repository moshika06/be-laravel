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
            $user = User::get();
            return response()->json([
                'status' => true,
                'message' => 'Fetch data success',
                'data' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Internal error server',
                'errors' => $th->getMessage()
            ], 500);
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
                'name'     => 'required|string',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required|min:8'
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'message' => 'Validation Fail',
                    'errors' => $validation->errors()
                ]);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Create user success',
                'data' => $user,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Internal error server',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $user = User::get();
            return response()->json([
                'status' => true,
                'message' => 'Internal error server',
                'data' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Internal error server',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        try {
            $validation = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'required|min:8'
            ]);
            if ($validation->fails()) {
                return response()->json([
                    'message' => 'Validation Fail',
                    'errors' => $validation->errors()
                ], 422);
            }
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = $request->password;
            }
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'Update user success',
                'data' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Internal error server',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'Delete user success',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Internal error server',
                'errors' => $th->getMessage()
            ], 500);
        }
    }
}
