<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserValidationUpdate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $idValidator = Validator::make(["id" => $request->route()->parameter('id')], [
            'id' => 'required|exists:users,id'
        ]);
        $userDataValidator = Validator::make($request->all(), [
            'name' => 'string|min:3',
            'email' => 'email:rfc,dns|unique:users,email',
            'age' => 'integer',
        ]);

        if ($userDataValidator->fails() || $idValidator->fails()) {

            $context = $idValidator->fails() ? $idValidator->errors()->toArray() : $userDataValidator->errors()->toArray();

            Log::warning('Validasi update pengguna gagal', $context);
            
            return response()->json([
                'status' => 'failed',
                'message' => 'periksa kembali data yang anda inputkan',
                'data' => $context,
            ], 400);
        }

        Log::info('Validasi update pengguna berhasil');

        return $next($request);
    }
}
