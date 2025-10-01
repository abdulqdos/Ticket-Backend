<?php

namespace App\Docs\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="EventData",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="type", type="string", example="event"),
 *     @OA\Property(
 *         property="attributes",
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="description", type="string"),
 *         @OA\Property(property="start_date", type="string", format="date-time"),
 *         @OA\Property(property="end_date", type="string", format="date-time"),
 *         @OA\Property(property="location", type="string")
 *     ),
 *     @OA\Property(
 *         property="relationships",
 *         type="object",
 *         @OA\Property(
 *             property="ticket_types",
 *             type="object",
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer"),
 *                     @OA\Property(property="type", type="string", example="ticket_types")
 *                 )
 *             )
 *         ),
 *         @OA\Property(
 *             property="city",
 *             type="object",
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer"),
 *                 @OA\Property(property="type", type="string", example="city")
 *             )
 *         ),
 *         @OA\Property(
 *             property="company",
 *             type="object",
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer"),
 *                 @OA\Property(property="type", type="string", example="company")
 *             )
 *         )
 *     ),
 *     @OA\Property(
 *         property="includes",
 *         type="object",
 *         @OA\Property(
 *             property="city",
 *             ref="#/components/schemas/CityData"
 *         ),
 *         @OA\Property(
 *             property="company",
 *             ref="#/components/schemas/CompanyData"
 *         ),
 *         @OA\Property(
 *             property="ticketTypes",
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
class EventData {}
