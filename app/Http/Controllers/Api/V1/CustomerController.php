<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CustomerResource;
use App\Models\Customer;

/**
 * @OA\Tag(
 *     name="Customers",
 *     description="APIs for managing customers"
 * )
 */
class CustomerController extends Controller
{
    /**
     * List all customers
     *
     * @OA\Get(
     *     path="/api/v1/customers",
     *     tags={"Customers"},
     *     summary="Get all customers",
     *     @OA\Response(
     *         response=200,
     *         description="List of customers",
     * @OA\JsonContent(
     *     type="object",
     *     @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/CustomerData")
     *     )
     * )
     *     )
     * )
     */
    public function index()
    {
        return CustomerResource::collection(Customer::all());
    }

    /**
     * Show single customer
     *
     * @OA\Get(
     *     path="/api/v1/customers/{customer}",
     *     tags={"Customers"},
     *     summary="Get a single customer",
     *     @OA\Parameter(
     *         name="customer",
     *         in="path",
     *         description="ID of the customer",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer details",
     *         * @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/CustomerData")
     *                  )
     *              )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Customer not found")
     *         )
     *     )
     * )
     */
    public function show(Customer $customer)
    {
        return CustomerResource::make($customer);
    }
}
