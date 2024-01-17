<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AirplaneTicket extends Model
{
    use HasFactory;


    protected $fillable = [
        'ticket_type',
        'from_destination',
        'to_destination',
        'departure_date',
        'return_date',
        'adults',
        'children',
        'babies',
        'class',
        'message',
        'name',
        'email',
        'customer_contact',
        'answered_by',
        'answer',
    ];

    
    public function answeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'answered_by');
    }
}
