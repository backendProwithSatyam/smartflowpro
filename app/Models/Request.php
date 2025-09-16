<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'title',
        'service_details',
        'preferred_date_1',
        'preferred_date_2',
        'preferred_times',
        'onsite_assessment',
        'onsite_instructions',
        'onsite_schedule_later',
        'onsite_anytime',
        'onsite_date',
        'onsite_time',
        'onsite_start_time',
        'onsite_end_time',
        'assigned_to',
        'notes',
        'attachments',
        'status'
    ];

    protected $casts = [
        'preferred_times' => 'array',
        'onsite_assessment' => 'boolean',
        'onsite_schedule_later' => 'boolean',
        'onsite_anytime' => 'boolean',
        'onsite_date' => 'date',
        'onsite_time' => 'datetime:H:i',
        'onsite_start_time' => 'datetime:H:i',
        'onsite_end_time' => 'datetime:H:i',
        'attachments' => 'array',
        'preferred_date_1' => 'date',
        'preferred_date_2' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
