<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'service_details' => 'required|string',
            'preferred_date_1' => 'nullable|date|after_or_equal:today',
            'preferred_date_2' => 'nullable|date|after_or_equal:today',
            'preferred_times' => 'nullable|array',
            'preferred_times.*' => 'string|in:anytime,morning,afternoon,evening',
            'onsite_assessment' => 'boolean',
            'onsite_instructions' => 'nullable|string',
            'onsite_schedule_later' => 'boolean',
            'onsite_anytime' => 'boolean',
            'onsite_date' => 'nullable|date|after_or_equal:today',
            'onsite_time' => 'nullable|date_format:H:i',
            'onsite_start_time' => 'nullable|date_format:H:i',
            'onsite_end_time' => 'nullable|date_format:H:i',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240', // 10MB max
            'status' => 'nullable|in:pending,in_progress,completed,cancelled'
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
            'title.required' => 'The title field is required.',
            'client_id.required' => 'Please select a client.',
            'client_id.exists' => 'The selected client does not exist.',
            'service_details.required' => 'Service details are required.',
            'preferred_date_1.after_or_equal' => 'Preferred date 1 must be today or later.',
            'preferred_date_2.after_or_equal' => 'Preferred date 2 must be today or later.',
            'onsite_date.after_or_equal' => 'Onsite assessment date must be today or later.',
            'assigned_to.exists' => 'The selected assigned user does not exist.',
            'attachments.*.file' => 'Each attachment must be a valid file.',
            'attachments.*.mimes' => 'Attachments must be jpg, jpeg, png, pdf, doc, or docx files.',
            'attachments.*.max' => 'Each attachment must not be larger than 10MB.'
        ];
    }
}
