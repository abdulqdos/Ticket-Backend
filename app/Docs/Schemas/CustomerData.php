<?php

namespace App\Docs\Schemas;
/**
 * @OA\Schema(
 *     schema="CustomerData",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="type", type="string", example="customer"),
 *     @OA\Property(
 *         property="attributes",
 *         ref="#/components/schemas/Customer"
 *     ),
 *     @OA\Property(
 *         property="relationships",
 *         type="object",
 *         @OA\Property(
 *             property="tickets",
 *             type="object",
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer"),
 *                     @OA\Property(property="type", type="string", example="ticketType")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Property(
 *         property="includes",
 *         type="object",
 *         @OA\Property(
 *             property="tickets",
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/TicketTypeData")
 *         )
 *     ),
 *     @OA\Property(
 *         property="links",
 *         type="object",
 *         @OA\Property(property="self", type="string")
 *     )
 * )
 */


class CustomerData {}
