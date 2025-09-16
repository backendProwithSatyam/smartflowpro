<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'title',
        'quote_number',
        'rate_opportunity',
        'salesperson',
        'line_items',
        'subtotal',
        'discount_amount',
        'discount_type',
        'tax_rate_id',
        'tax_amount',
        'required_deposit',
        'deposit_type',
        'total',
        'client_message',
        'contract_disclaimer',
        'internal_notes',
        'attachments',
        'status'
    ];

    protected $casts = [
        'line_items' => 'array',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'required_deposit' => 'decimal:2',
        'total' => 'decimal:2',
        'attachments' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function taxRate()
    {
        return $this->belongsTo(TaxRate::class);
    }

    public function salespersonUser()
    {
        return $this->belongsTo(User::class, 'salesperson');
    }

    // Generate quote number
    public static function generateQuoteNumber()
    {
        $lastQuote = self::orderBy('id', 'desc')->first();
        $number = $lastQuote ? $lastQuote->id + 1 : 1;
        return 'Q-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
