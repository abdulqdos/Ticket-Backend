<?php

namespace App\Docs\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="CompanyData",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="type", type="string", example="company"),
 *     @OA\Property(
 *         property="attributes",
 *         type="object",
 *         @OA\Property(property="name", type="string", example="Libyan Web Co."),
 *         @OA\Property(property="phone", type="string", example="0912345678"),
 *         @OA\Property(property="email", type="string", example="info@company.com")
 *     )
 * )
 */
class CompanyData {}
