<?php

namespace App\Http\Controllers\Api;

use App\actions\EventActions\CustomerActions\CreateCustomerAction;
use App\actions\EventActions\CustomerActions\UpdateCustomerAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\UpdateCustomerRequest;
use App\Models\Customer;
use App\Traits\Api\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
     *     path="/api/customers/login",
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
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={
     *                     "phone": {"The phone field is required."},
     *                     "password": {"The password must be at least 6 characters."}
     *                 }
     *             )
     *         )
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        $request->validated();

        $customer = Customer::where('phone', $request->phone)->first();

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
     *     path="/api/customers/logout",
     *     tags={"Authentication"},
     *     summary="Logout a customer",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logged out successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logged out successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
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
     *     path="/api/customers/register",
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
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={
     *                     "email": {"The email field is required."},
     *                     "password": {"The password must be at least 6 characters."}
     *                 }
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

        // Return Response With Token
        return $this->ok(
            'Customer registered successfully',
            [
                'token' => $customer->createToken('API token for ' . $customer->phone)->plainTextToken,
            ]
        );
    }

    /**
     * Customer register
     *
     * @OA\Post(
     *     path="/api/customers/{id}/edit",
     *     tags={"Authentication"},
     *     summary="Update customer Data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="phone", type="string", example="0123456789"),
     *             @OA\Property(property="backup_phone", type="string", example="0987654321"),
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer Data Update successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Customer registered successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="token_here")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={
     *                     "email": {"The email field is required."},
     *                     "password": {"The password must be at least 6 characters."}
     *                 }
     *             )
     *         )
     *     )
     * )
     */
    public function update(Customer $customer , UpdateCustomerRequest $request)
    {
        $request->validated();

        // Update Customer
        $customer = (new UpdateCustomerAction(
            customer: $customer,
            phone:       $request->phone ?? $customer['phone'],
            backupPhone: $request->backup_phone ?? $customer['backup_phone'],
            firstName:   $request->first_name ?? $customer['first_name'],
            lastName:    $request->last_name ?? $customer['last_name'],
            email:       $request->email ?? $customer['email'],
        ))->execute();

        // Return Response With Token
        return $this->ok(
            'Customer Data Update successfully'
        );
    }

    /**
     * User Profile
     *
     * @OA\Get(
     *     path="/api/profile",
     *     tags={"Authentication"},
     *     summary="Get authenticated user profile",
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="User profile data",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="User profile data"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="first_name", type="string", example="John"),
     *                 @OA\Property(property="last_name", type="string", example="Doe"),
     *                 @OA\Property(property="phone", type="string", example="0123456789"),
     *                 @OA\Property(property="email", type="string", example="john@example.com"),
     *                 @OA\Property(
     *                     property="profile_image",
     *                     type="string",
     *                     example="https://example.com/storage/profile/avatar.png"
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function profile()
    {
        $user = auth()->user();

        return response()->json([
            'status'  => 200,
            'message' => 'User profile data',
            'data'    => [
                'id'            => $user->id,
                'first_name'    => $user->first_name,
                'last_name'     => $user->last_name,
                'phone'         => $user->phone,
                'email'         => $user->email,
                'profile_image' => $user->getFirstMediaUrl('profile'),
            ],
        ]);
    }
}
