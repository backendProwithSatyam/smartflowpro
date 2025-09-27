<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'first_name',
        'last_name',
        'company_name',
        'phone_number',
        'email',
        'lead_source',
        'same_as_billing',
        'tags'
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    
    public function properties()
    {
     return $this->hasMany(Address::class);
    }
}
