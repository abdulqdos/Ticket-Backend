<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\TicketTypeResource;
use App\Models\TicketType;

/**
 * @OA\Tag(
 *     name="TicketTypes",
 *     description="APIs for managing ticket types"
 * )
 */
class TicketTypeController extends Controller
{
    /**
     * List all ticket types
     *
     * @OA\Get(
     *     path="/api/v1/ticket-types",
     *     tags={"TicketTypes"},
     *     summary="Get all ticket types",
     *     @OA\Response(
     *         response=200,
     *         description="List of ticket types",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/TicketType")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return TicketTypeResource::collection(TicketType::all());
    }

    /**
     * Show single ticket type
     *
     * @OA\Get(
     *     path="/api/v1/ticket-types/{ticketType}",
     *     tags={"TicketTypes"},
     *     summary="Get a single ticket type",
     *     @OA\Parameter(
     *         name="ticketType",
     *         in="path",
     *         description="ID of the ticket type",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ticket type details",
     *         @OA\JsonContent(ref="#/components/schemas/TicketType")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ticket type not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ticket type not found")
     *         )
     *     )
     * )
     */
    public function show(TicketType $ticketType)
    {
        return TicketTypeResource::make($ticketType);
    }
}
