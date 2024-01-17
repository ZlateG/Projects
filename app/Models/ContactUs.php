<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactUs extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'message',
        'answered_by',
        'answer',
    ];
    public function answeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'answered_by');
    }
}
