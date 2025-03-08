<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class UserValidationInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'age' => 'required|integer',
        ]);

        if ($validator->fails()) {

            Log::warning('Validasi input pengguna gagal', $validator->errors()->toArray());
            
            return response()->json([
                'status' => 'failed',
                'message' => 'periksa kembali data yang anda inputkan',
                'data' => $validator->errors()->toArray(),
            ], 400);
        }

        Log::info('Validasi input pengguna berhasil');

        return $next($request);
    }
}
