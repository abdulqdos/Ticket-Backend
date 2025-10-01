<?php
namespace App\Docs\Schemas ;

/**
 * @OA\Schema(
 *     schema="TicketTypeData",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="type", type="string", example="ticketType"),
 *     @OA\Property(
 *         property="attributes",
 *         type="object",
 *         @OA\Property(property="name", type="string", example="VIP"),
 *         @OA\Property(property="price", type="number", format="float", example=100.5),
 *         @OA\Property(property="quantity", type="integer", example=50),
 *         @OA\Property(property="event_id", type="integer", example=1)
 *     ),
 *     @OA\Property(
 *         property="links",
 *         type="object",
 *         @OA\Property(property="self", type="string", example="http://localhost:8000/api/v1/ticket-types/1")
 *     )
 * )
 */

class TicketTypeData {}
