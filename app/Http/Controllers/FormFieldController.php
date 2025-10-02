<?php

// app/Http/Controllers/FormFieldController.php
namespace App\Http\Controllers;

use App\Models\FormField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormFieldController extends Controller
{
    // Show all fields
    public function index()
    {
        // $fields = FormField::all();
        // return view('admin.partials.add_fields', compact('fields'));
    }

    // Store new fields
    public function store(Request $request)
    {
        $labels = $request->labelName;
        $pageName = $request->page_value;
        $types = $request->fieldType;
        $options = $request->options;
        $transferrable = $request->transferable;
        $defaults = $request->defaultValue;

        foreach ($labels as $index => $label) {
            FormField::create([
                'label_name' => $label,
                'field_type' => $types[$index],
                'options' => in_array($types[$index], ['select', 'checkbox', 'radio'])
                    ? json_encode(explode(',', $options[$index] ?? ''))
                    : null,
                'transferrable' => isset($transferrable) ? (bool)$transferrable : false,
                'default_value' => $defaults ?? null,
                'current_page_name' => $pageName ?? null,
                'user_id' => Auth::id(),
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Form fields saved successfully!'
        ], 200);
    }


    // Edit
    public function edit(FormField $formField)
    {
        return view('form_fields.edit', compact('formField'));
    }

    // Update
    public function update(Request $request, FormField $formField)
    {
        $formField->update([
            'label_name' => $request->label_name,
            'field_type' => $request->field_type,
            'options'    => $request->options,
        ]);

        return redirect()->route('form-fields.index')->with('success', 'Field updated successfully!');
    }

    // Delete
    public function destroy(FormField $formField)
    {
        $formField->delete();
        return redirect()->route('form-fields.index')->with('success', 'Field deleted successfully!');
    }
}
