<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\EventResource;
use App\Models\Event;

/**
 * @OA\Tag(
 *     name="Events",
 *     description="APIs for managing events"
 * )
 */
class EventController extends Controller
{
    /**
     * List all events
     *
     * @OA\Get(
     *     path="/api/v1/events",
     *     tags={"Events"},
     *     summary="Get all events",
     *     @OA\Response(
     *         response=200,
     *         description="List of events",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/EventData")
     *         )
     *     )
     * )
     */
    public static function index()
    {
        return EventResource::collection(Event::all());
    }

    /**
     * Show single event
     *
     * @OA\Get(
     *     path="/api/v1/events/{event}",
     *     tags={"Events"},
     *     summary="Get a single event",
     *     @OA\Parameter(
     *         name="event",
     *         in="path",
     *         description="ID of the event",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Event details",
     *         @OA\JsonContent(ref="#/components/schemas/EventData")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Event not found")
     *         )
     *     )
     * )
     */
    public static function show(Event $event)
    {
        return EventResource::make($event);
    }
}
