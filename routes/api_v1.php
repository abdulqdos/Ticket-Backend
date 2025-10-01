<?php


use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\TicketTypeController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->as('api.v1.')->group(function () {
    Route::apiResource('customers', CustomerController::class)->only(["index" , "show"]);
    Route::apiResource('events', EventController::class)->only(["index" , "show"]);
    Route::apiResource('ticket-types', TicketTypeController::class)->only(["index" , "show"]);
//    Route::get('')
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/events/{event}/ticket-types/{ticket_type}' , [TicketController::class , 'store'])->name('tickets.store'); // Booking ticket route
        Route::delete('/events/{event}/ticket-types/{ticket_type}' , [TicketController::class , 'destroy'])->name('tickets.destroy'); // Cancel ticket route
    });
});
