<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_anonymous',
        'sender_name',
        'sender_initial',
        'sender_contact',
        'recipient_name',
        'recipient_class',
        'recipient_contact',
        'bundle_type',
        'message_content',
        'total_price',
        'payment_method',
        'payment_proof_path',
        'status',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
    ];
}
