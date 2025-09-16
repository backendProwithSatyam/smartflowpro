<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'invoice_subject',
        'invoice_number',
        'issued_date',
        'payment_due',
        'due_date',
        'salesperson',
        'line_items',
        'subtotal',
        'discount_amount',
        'discount_type',
        'tax_rate_id',
        'tax_amount',
        'total',
        'client_message',
        'contract_disclaimer',
        'internal_notes',
        'attachments',
        'status'
    ];

    protected $casts = [
        'line_items' => 'array',
        'issued_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
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

    // Generate invoice number
    public static function generateInvoiceNumber()
    {
        $lastInvoice = self::orderBy('id', 'desc')->first();
        $number = $lastInvoice ? $lastInvoice->id + 1 : 1;
        return 'INV-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
