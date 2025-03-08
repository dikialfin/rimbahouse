<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $userModel;

    public function __construct() {
        $this->userModel = new User;
    }

    public function addUser(Request $request) {
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
}
