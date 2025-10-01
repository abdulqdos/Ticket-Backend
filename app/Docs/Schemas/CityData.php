<?php

namespace App\Docs\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="CityData",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="type", type="string", example="city"),
 *     @OA\Property(
 *         property="attributes",
 *         type="object",
 *         @OA\Property(property="name", type="string", example="طرابلس")
 *     )
 * )
 */
class CityData {}

