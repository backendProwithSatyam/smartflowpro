<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'invoice_subject' => 'required|string|max:255',
            'invoice_number' => 'nullable|string|max:50',
            'issued_date' => 'required|date',
            'payment_due' => 'required|in:upon_receipt,net_15,net_30,net_45,custom',
            'due_date' => 'nullable|date|after_or_equal:issued_date',
            'salesperson' => 'nullable|exists:users,id',
            'line_items' => 'nullable|array',
            'line_items.*.name' => 'required_with:line_items|string|max:255',
            'line_items.*.description' => 'nullable|string',
            'line_items.*.quantity' => 'required_with:line_items|numeric|min:0',
            'line_items.*.unit_price' => 'required_with:line_items|numeric|min:0',
            'line_items.*.total' => 'required_with:line_items|numeric|min:0',
            'line_items.*.service_date' => 'nullable|date',
            'line_items.*.type' => 'required_with:line_items|in:product,service',
            'subtotal' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:percentage,fixed',
            'tax_rate_id' => 'nullable|exists:tax_rates,id',
            'tax_amount' => 'nullable|numeric|min:0',
            'total' => 'nullable|numeric|min:0',
            'client_message' => 'nullable|string',
            'contract_disclaimer' => 'nullable|string',
            'internal_notes' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
            'status' => 'nullable|in:draft,sent,paid,overdue,cancelled'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'client_id.required' => 'Please select a client.',
            'client_id.exists' => 'The selected client does not exist.',
            'invoice_subject.required' => 'The invoice subject field is required.',
            'issued_date.required' => 'The issued date field is required.',
            'payment_due.required' => 'Please select a payment due option.',
            'due_date.after_or_equal' => 'Due date must be on or after the issued date.',
            'salesperson.exists' => 'The selected salesperson does not exist.',
            'tax_rate_id.exists' => 'The selected tax rate does not exist.',
            'line_items.*.name.required_with' => 'Line item name is required.',
            'line_items.*.quantity.required_with' => 'Line item quantity is required.',
            'line_items.*.unit_price.required_with' => 'Line item unit price is required.',
            'line_items.*.total.required_with' => 'Line item total is required.',
            'attachments.*.file' => 'Each attachment must be a valid file.',
            'attachments.*.mimes' => 'Attachments must be jpg, jpeg, png, pdf, doc, or docx files.',
            'attachments.*.max' => 'Each attachment must not be larger than 10MB.'
        ];
    }
}
