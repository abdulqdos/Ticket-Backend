<?php

namespace App\Docs\Schemas;

/**
 * @OA\Schema(
 *     schema="TicketData",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="type", type="string", example="ticket"),
 *     @OA\Property(
 *         property="attributes",
 *         ref="#/components/schemas/TicketType"
 *     ),
 *     @OA\Property(
 *         property="links",
 *         type="object",
 *         @OA\Property(property="self", type="string")
 *     )
 * )
 */


class TicketData {}
