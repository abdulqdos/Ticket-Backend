<?php

namespace App\Docs\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *   schema="TicketType",
 *   title="TicketType",
 *   description="Ticket Type model",
 *   @OA\Property(property="id", type="integer"),
 *   @OA\Property(property="event_id", type="integer"),
 *   @OA\Property(property="name", type="string"),
 *   @OA\Property(property="price", type="number", format="float"),
 *   @OA\Property(property="quantity", type="integer"),
 *   @OA\Property(property="created_at", type="string", format="date-time"),
 *   @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class TicketTypeSchema {}
