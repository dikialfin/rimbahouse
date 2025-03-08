<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User;
    }

    public function addUser(Request $request)
    {
        try {
            $this->userModel->name = $request->input('name');
            $this->userModel->email = $request->input('email');
            $this->userModel->age = $request->input('age');
            $this->userModel->save();

            Log::info('Berhasil menambahkan data', [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'age' => $request->input('age')
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'berhasil menambahkan data',
                'data' => []
            ], 201);
        } catch (Exception $exception) {

            Log::error('Terjadi kesalahan: ' . $exception->getMessage(), ['exception' => $exception]);

            return response()->json([
                'status' => 'failed',
                'message' => 'terjadi kesalahan pada server',
                'data' => []
            ], 500);
        }
    }

    public function editUser(Request $request, $id)
    {
        try {
            $user = $this->userModel::find($id);
            $user->name = $request->has('name') ? $request->input('name') : $user->name;
            $user->email = $request->has('email') ? $request->input('email') : $user->email;
            $user->age = $request->has('age') ? $request->input('age') : $user->age;
            $user->save();

            Log::info('Berhasil mengubah data', [
                'name' => $request->has('name') ? $request->input('name') : $user->name,
                'email' => $request->has('email') ? $request->input('email') : $user->email,
                'age' => $request->has('age') ? $request->input('age') : $user->age
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'berhasil mengubah data',
                'data' => []
            ], 200);
        } catch (Exception $exception) {

            Log::error('Terjadi kesalahan: ' . $exception->getMessage(), ['exception' => $exception]);

            return response()->json([
                'status' => 'failed',
                'message' => 'terjadi kesalahan pada server',
                'data' => []
            ], 500);
        }
    }
}
