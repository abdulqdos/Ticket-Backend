<?php

namespace App\Docs\Schemas;

/**
 * @OA\Schema(
 *   schema="Customer",
 *   title="Customer",
 *   description="Customer model",
 *   @OA\Property(property="id", type="integer"),
 *   @OA\Property(property="first_name", type="string"),
 *   @OA\Property(property="last_name", type="string"),
 *   @OA\Property(property="phone", type="string"),
 *   @OA\Property(property="email", type="string")
 * )
 */
class CustomerSchema {}
