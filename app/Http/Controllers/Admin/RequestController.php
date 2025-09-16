<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequestRequest;
use App\Models\Client;
use App\Models\Request as ServiceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = ServiceRequest::with(['client', 'assignedUser'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('admin.pages.requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::where('user_id', Auth::id())->latest()->get();
        $users = User::where('id', '!=', Auth::id())->get();
        return view('admin.pages.requests.new-request', compact('clients', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequestRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();
            $data['onsite_assessment'] = $request->has('onsite_assessment');
            $data['onsite_schedule_later'] = $request->has('onsite_schedule_later');
            $data['onsite_anytime'] = $request->has('onsite_anytime');

            // Handle file uploads
            if ($request->hasFile('attachments')) {
                $attachments = [];
                foreach ($request->file('attachments') as $file) {
                    $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('request-attachments', $filename, 'public');
                    $attachments[] = [
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getMimeType()
                    ];
                }
                $data['attachments'] = $attachments;
            }

            $serviceRequest = ServiceRequest::create($data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Request created successfully!',
                    'data' => $serviceRequest
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Request created successfully!',
                'data' => $serviceRequest
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating request: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Error creating request: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $request = ServiceRequest::with(['client', 'assignedUser'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('admin.pages.requests.show', compact('request'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $serviceRequest = ServiceRequest::where('user_id', Auth::id())->findOrFail($id);
        $clients = Client::where('user_id', Auth::id())->latest()->get();
        $users = User::where('id', '!=', Auth::id())->get();

        return view('admin.pages.requests.new-request', compact('serviceRequest', 'clients', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequestRequest $request, string $id)
    {
        try {
            $serviceRequest = ServiceRequest::where('user_id', Auth::id())->findOrFail($id);

            $data = $request->validated();
            $data['onsite_assessment'] = $request->has('onsite_assessment');
            $data['onsite_schedule_later'] = $request->has('onsite_schedule_later');
            $data['onsite_anytime'] = $request->has('onsite_anytime');

            // Handle file uploads
            if ($request->hasFile('attachments')) {
                $attachments = $serviceRequest->attachments ?? [];
                foreach ($request->file('attachments') as $file) {
                    $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('request-attachments', $filename, 'public');
                    $attachments[] = [
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                        'type' => $file->getMimeType()
                    ];
                }
                $data['attachments'] = $attachments;
            }

            $serviceRequest->update($data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Request updated successfully!',
                    'data' => $serviceRequest
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Request updated successfully!',
                'data' => $serviceRequest
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating request: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()
                ->with('error', 'Error updating request: ' . $e->getMessage());
        }
    }

    /**
     * Update request status
     */
    public function updateStatus(Request $request, string $id)
    {
        try {
            $serviceRequest = ServiceRequest::where('user_id', Auth::id())->findOrFail($id);
            
            $request->validate([
                'status' => 'required|in:pending,in_progress,completed,cancelled'
            ]);
            
            $serviceRequest->update(['status' => $request->status]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Request status updated successfully!'
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Request status updated successfully!'
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating request status: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error updating request status: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $serviceRequest = ServiceRequest::where('user_id', Auth::id())->findOrFail($id);

            // Delete associated files
            if ($serviceRequest->attachments) {
                foreach ($serviceRequest->attachments as $attachment) {
                    if (Storage::disk('public')->exists($attachment['path'])) {
                        Storage::disk('public')->delete($attachment['path']);
                    }
                }
            }

            $serviceRequest->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Request deleted successfully!'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Request deleted successfully!'
            ]);
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting request: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error deleting request: ' . $e->getMessage());
        }
    }
}
