<?php

namespace App\Http\Controllers\Api;

use App\actions\CustomerActions\CreateCustomerAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Traits\Api\ApiResponses;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="APIs for customer authentication"
 * )
 */
class AuthController extends Controller
{
    use ApiResponses;

    /**
     * Customer login
     *
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Authentication"},
     *     summary="Login as a customer",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="phone", type="string", example="0123456789"),
     *             @OA\Property(property="password", type="string", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Authenticated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Authenticated"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="token_here")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid credentials")
     *         )
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        $request->validated();

        $customer = Customer::query();

        try {
            $customer = Customer::where('phone', $request->phone)->first();
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket Not Found' ,404);
        }

        if (! $customer || ! Hash::check($request->password, $customer->password)) {
            return $this->error('Invalid credentials', 401);
        }

        $token = $customer->createToken('API token for ' . $customer->phone, ['customer'])->plainTextToken;

        return $this->ok(
            'Authenticated',
            [
                'token' => $token,
            ]
        );
    }

    /**
     * Customer logout
     *
     * @OA\Post(
     *     path="/api/auth/logout",
     *     tags={"Authentication"},
     *     summary="Logout a customer",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logged out successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logged out successfully")
     *         )
     *     )
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        $customer = $request->user('customer');

        if ($customer) {
            $customer->currentAccessToken()->delete();
        }

        return $this->ok('Logged out successfully');
    }


    /**
     * Customer register
     *
     * @OA\Post(
     *     path="/api/auth/register",
     *     tags={"Authentication"},
     *     summary="Register a new customer",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="phone", type="string", example="0123456789"),
     *             @OA\Property(property="backup_phone", type="string", example="0987654321"),
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="password", type="string", example="secret123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Customer registered successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="token_here")
     *             )
     *         )
     *     )
     * )
     */
    public function register(RegisterRequest $request)
    {
        $request->validated();

        // Create new Customer
        $customer = (new CreateCustomerAction(
            phone:       $request->phone,
            backupPhone: $request->backup_phone,
            firstName:   $request->first_name,
            lastName:    $request->last_name,
            email:       $request->email,
            password:    $request->password
        ))->execute();

        // Return Respone With Token
        return $this->ok(
            'Customer registered successfully',
            [
                'token' => $customer->createToken('API token for ' . $customer->phone)->plainTextToken,
            ]
        );
    }
}
