<?php

namespace App\Http\Controllers\Api\V1;

use App\actions\TicketActions\CreateTicketAction;
use App\actions\TicketActions\DeleteTicketAction;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketType;
use App\Traits\Api\ApiResponses;

/**
 * @OA\Tag(
 *     name="Tickets",
 *     description="APIs for managing tickets"
 * )
 */
class TicketController extends Controller
{
    use ApiResponses;

    /**
     * Book a ticket
     *
     * @OA\Post(
     *     path="/api/v1/tickets/{event_id}/{ticketType_id}/store",
     *     tags={"Tickets"},
     *     summary="Book a ticket for an event",
     *     @OA\Parameter(
     *         name="event_id",
     *         in="path",
     *         description="ID of the event",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="ticketType_id",
     *         in="path",
     *         description="ID of the ticket type",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ticket booked successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Your Booked Has Create Check your profile"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="status", type="integer", example=201)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation or business rule error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="This ticket does not belong to the selected event"),
     *             @OA\Property(property="status", type="integer", example=422)
     *         )
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    // Booking Ticket
    public  function store($event_id ,$ticketType_id )
    {
        // if the customer dose not booking this ticket before
        $customer = auth()->user();

        // Check if Event && Ticket is Here
        $event =  Event::FindOrFailWithError($event_id);
        $ticketType = TicketType::FindOrFailWithError($ticketType_id);


        // if ticket belongs to event
        if(!$event->getTicketType($ticketType)) {
            return $this->error([
                'message' => 'This ticket does not belong to the selected event',
                'status' => 422
            ], 422);
        }

        if($customer->alreadyBooked($ticketType)) {
            return $this->error([
                'message' => 'You are  already booked this ticket',
                'status' => 422
            ] , 422);
        }

        // check if ticket still available (count - 1)
        if (!$ticketType->isAvaliable()) {
            return $this->error([
                'message' => 'Sorry , No tickets available .',
                'status' => 422
            ] , 422);
        }

        // book a ticket with customer (pivot table)
        $ticket = (new CreateTicketAction(
            ticketType_id: $ticketType->id,
            customer_id: $customer->id,
            ticket_type: $ticketType
        ))->execute();

        return $this->ok([
            "message" => "Your Booked Has Create Check your profile",
            'data' => $ticket,
            'status' => 201
        ], 201 );
    }

    /**
     * Cancel a booked ticket
     *
     * @OA\Delete(
     *     path="/api/v1/tickets/{event_id}/{ticketType_id}/destroy",
     *     tags={"Tickets"},
     *     summary="Cancel a booked ticket",
     *     @OA\Parameter(
     *         name="event_id",
     *         in="path",
     *         description="ID of the event",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="ticketType_id",
     *         in="path",
     *         description="ID of the ticket type",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ticket canceled successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Your Booked Has Deleted"),
     *             @OA\Property(property="status", type="integer", example=201)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation or business rule error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="You do not booked this ticket to cancel"),
     *             @OA\Property(property="status", type="integer", example=422)
     *         )
     *     ),
     *     security={{"sanctum":{}}}
     * )
     */
    // Cancel Booking
    public function destroy($event_id ,$ticketType_id)
    {
        // if the customer dose not booking this ticket before
        $customer = auth()->user();

        // Check if Event && Ticket is Here
        $event = Event::FindOrFailWithError($event_id);
        $ticketType = TicketType::FindOrFailWithError($ticketType_id);


        // if ticket belongs to event
        if (!$event->getTicketType($ticketType)) {
            return $this->error([
                'message' => 'This ticket type does not belong to the selected event',
                'status' => 422
            ], 422);
        }

        // Check if he have Ticket to cancel
        if(!$customer->alreadyBooked($ticketType)) {
            return $this->error([
                'message' => 'You are do not booked this ticket to cancel',
                'status' => 422
            ] , 422);
        }

        // cancel
        $ticket = (new DeleteTicketAction(
            ticket_type_id: $ticketType_id,
            customer_id: $customer->id,
            ticket_type: $ticketType
        ))->execute();

        return $this->ok([
            "message" => "Your Booked Has Deleted",
            'status' => 201
        ], 201 );
    }
}
