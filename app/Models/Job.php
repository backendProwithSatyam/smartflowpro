<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job_lists';

    protected $fillable = [
        'user_id',
        'client_id',
        'title',
        'client',
        'job_number',
        'salesperson',
        'job_type',
        'schedule_date',
        'start_time',
        'end_time',
        'schedule_later',
        'anytime',
        'repeats',
        'repeat_end_type',
        'repeat_end_after_number',
        'repeat_end_after_period',
        'repeat_end_on_date',
        'visit_instructions',
        'email_team',
        'send_invoice',
        'product_items',
        'total_cost',
        'total_price',
        'notes',
        'attachments',
        'status'
    ];

    protected $casts = [
        'schedule_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'repeat_end_on_date' => 'date',
        'schedule_later' => 'boolean',
        'anytime' => 'boolean',
        'email_team' => 'boolean',
        'send_invoice' => 'boolean',
        'product_items' => 'array',
        'attachments' => 'array',
        'total_cost' => 'decimal:2',
        'total_price' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
