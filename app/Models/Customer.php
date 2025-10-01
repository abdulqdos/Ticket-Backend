<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory , HasApiTokens;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'email_verified_at',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function alreadyBooked(TicketType $ticketType)
    {
        return $this->tickets->contains(function ($ticket) use ($ticketType) {
            return $ticket->ticket_type_id === $ticketType->id;
        });
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketTypes()
    {
        return $this->hasManyThrough(
            TicketType::class,  // final model
            Ticket::class,      // intermediate model (pivot)
            'customer_id',      // foreign key in tickets table
            'id',               // foreign key in ticket_types table
            'id',               // local key in customers table
            'ticket_type_id'    // local key in tickets table
        );
    }
}
