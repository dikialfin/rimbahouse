<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Rimba Api",
 *      description="Rimba Api"
 * )
 */
class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User;
    }

    /**
     * @OA\Post(
     *      path="/api/users",
     *      tags={"User"},
     *      summary="Adding user",
     *      description="Adding user",
     *      @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(
     *           property="name", 
     *           type="string", 
     *           default="Username Here"
     *       ),
     *          @OA\Property(
     *           property="email", 
     *           type="string", 
     *           default="useremail@email.email"
     *       ),
     *          @OA\Property(
     *           property="age", 
     *           type="integer", 
     *           default=28
     *       )
     *      )
     *  ),
     *      @OA\Response(
     *          response=201,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=500, description="failed operation"),
     * )
     */
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

    /**
     * @OA\Put(
     *      path="/api/users/{id}",
     *      tags={"User"},
     *      summary="Update user information by id",
     *      description="Update user information by id",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *      @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          type="object",
     *          @OA\Property(
     *           property="name", 
     *           type="string", 
     *           default="Username Here"
     *       ),
     *          @OA\Property(
     *           property="email", 
     *           type="string", 
     *           default="useremail@email.email"
     *       ),
     *          @OA\Property(
     *           property="age", 
     *           type="integer", 
     *           default=28
     *       )
     *      )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=500, description="failed operation"),
     * )
     */
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

    /**
     * @OA\Delete(
     *      path="/api/users/{id}",
     *      tags={"User"},
     *      summary="Delete user information by id",
     *      description="Delete user data",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=404, description="data not found"),
     *      @OA\Response(response=500, description="failed operation"),
     * )
     */
    public function deleteUser(Request $request, $id)
    {
        try {

            $user = $this->userModel::find($id);

            if (is_null($user)) {
                Log::error('Terjadi kesalahan: user id tidak dapat di temukan');

                return response()->json([
                    'status' => 'failed',
                    'message' => 'periksa kembali data yang anda inputkan',
                    'data' => [
                        "id" => "id not found"
                    ],
                ], 404);
            }

            $user->delete();

            Log::info('Berhasil menghapus data user : ', [
                'id' => $id
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'berhasil menghapus data',
                'data' => []
            ], 204);
        } catch (Exception $exception) {
            Log::error('Terjadi kesalahan: ' . $exception->getMessage(), ['exception' => $exception]);

            return response()->json([
                'status' => 'failed',
                'message' => 'terjadi kesalahan pada server',
                'data' => []
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/users/{id}",
     *      tags={"User"},
     *      summary="Get user information by id",
     *      description="Returns user data",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=404, description="data not found"),
     *      @OA\Response(response=500, description="failed operation"),
     * )
     */
    public function detailUser(Request $request, $id)
    {
        try {

            $user = $this->userModel::find($id);

            if (is_null($user)) {
                Log::error('Terjadi kesalahan: user id tidak dapat di temukan');

                return response()->json([
                    'status' => 'failed',
                    'message' => 'periksa kembali data yang anda inputkan',
                    'data' => [
                        "id" => "id not found"
                    ],
                ], 404);
            }

            Log::info('Berhasil memuat data user : ', [
                'id' => $id
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'berhasil memuat data',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'age' => $user->age,
                ]
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

    /**
     * @OA\Get(
     *      path="/api/users",
     *      tags={"User"},
     *      summary="Get list of users",
     *      description="Returns list of users",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=500, description="failed operation")
     *     )
     *
     * Returns list of users
     */
    public function getUsers(Request $request)
    {
        try {
            $users = User::paginate(5);

            Log::info('Berhasil memuat data user');

            return response()->json([
                'status' => 'success',
                'message' => 'berhasil memuat data',
                'data' => $users
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
