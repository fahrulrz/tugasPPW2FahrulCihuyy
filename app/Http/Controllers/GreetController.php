<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class GreetController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/greet",
     *     tags={"greetinggggg"},
     *     summary="Returns a Sample API response",
     *     description="A sample greeting to test out the API",
     *     operationId="greet",
     *     @OA\Parameter(
     *         name="firstname",
     *         description="nama depan",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="lastname",
     *         description="nama belakang",
     *         required=true,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             example={
     *                 "success": true,
     *                 "message": "Berhasil mengambil Kategori Berita",
     *                 "data": {
     *                     "output": "Hallo John Doe",
     *                     "firstname": "John",
     *                     "lastname": "Doe"
     *                 }
     *             }
     *         )
     *     ),
     * )
     */

    public function greet(Request $request)
    {
        $userData = $request->only([
            'first_name',
            'last_name',
        ]);
        if (empty($userData['first_name']) && empty($userData['last_name'])) {
            return new \Exception('Missing name', 404);
        }
        return response()->json(['message' => 'Berhasil memproses masukan user', 'success' => true, 'data' => [
            'output' => 'Hello ' . $userData['first_name'] . ' ' . $userData['last_name'],
            'first_name' => $userData['first_name'],
            'last_name' => $userData['last_name'],
        ]], 200);
    }
}
