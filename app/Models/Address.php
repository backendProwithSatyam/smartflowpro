<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'client_id',
        'street1',
        'street2',
        'city',
        'province',
        'postal_code',
        'country',
        'tax_rate_id',
        'type'
    ];

    public function taxRate()
    {
        return $this->belongsTo(TaxRate::class);
    }
}
