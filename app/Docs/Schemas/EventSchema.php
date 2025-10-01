<?php
namespace App\Docs\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *   schema="Event",
 *   title="Event",
 *   description="Event model",
 *   @OA\Property(property="id", type="integer"),
 *   @OA\Property(property="title", type="string"),
 *   @OA\Property(property="description", type="string"),
 *   @OA\Property(property="start_date", type="string", format="date-time"),
 *   @OA\Property(property="end_date", type="string", format="date-time"),
 *   @OA\Property(property="created_at", type="string", format="date-time"),
 *   @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class EventSchema {}
