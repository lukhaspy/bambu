<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();

        return response()->json(['users' => $users], '200');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => "required|string|max:45",
            'cedula' => "required|integer|unique:users,cedula",
            'telefono' => "required|string",
            'email' => "required|email",
            'rol' => "required|in:1,2,3",
            'user' => "required",
            'password' => "required"
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 403);
        }

        try {

            DB::beginTransaction();
            $user = User::create([
                'nombre' => $request->nombre,
                'cedula' => $request->cedula,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'user' => $request->user,
                'password' => Hash::make($request->password),
                'rol' => $request->rol,

            ]);
            DB::commit();
            return response()->json($user->id, 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), '500');
        }
    }
}
