<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\FormField;
use App\Models\TaxRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('addresses')->where('user_id', Auth::id())->paginate(10);
        return view('admin.pages.client.index', compact('clients'));
    }

public function show(Client $client)
{
    $client->load(['addresses', 'properties']); // addresses aur properties dono
    return view('admin.pages.client.view_client', compact('client'));
    // return view('admin.pages.client.view_client', compact('client'));
}



    public function create()
    {
        // dd(111);
        $taxRates = TaxRate::where('user_id', Auth::id())->get();
        $customFields = FormField::where('user_id', Auth::id())
            ->where('current_page_name', 'client')
            ->orWhere('transferrable', true)
            ->get();
        return view('admin.pages.client.partials.add', [
            'client' => new Client(),
            'taxRates' => $taxRates,
            'editMode' => false,
            'customFields' => $customFields
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'firstName' => 'required',
            'lastName'  => 'required',
            'email'     => 'nullable|email',
            'companyName' => 'nullable|string|max:255',
            'phoneNumber' => 'nullable|string|max:50',
            'leadSource' => 'nullable|string|max:255',
            'sameAsBilling' => 'nullable|boolean',
            'addresses' => 'nullable|array',
            'addresses.*.street1' => 'nullable|string|max:255',
            'addresses.*.street2' => 'nullable|string|max:255',
            'addresses.*.city' => 'nullable|string|max:255',
            'addresses.*.province' => 'nullable|string|max:255',
            'addresses.*.postalCode' => 'nullable|string|max:20',
            'addresses.*.country' => 'nullable|string|max:255',
            'addresses.*.tax_rate_id' => 'nullable|exists:tax_rates,id',
            'billingAddress' => 'nullable|array',
            'billingAddress.street1' => 'nullable|string|max:255',
            'billingAddress.street2' => 'nullable|string|max:255',
            'billingAddress.city' => 'nullable|string|max:255',
            'billingAddress.province' => 'nullable|string|max:255',
            'billingAddress.postalCode' => 'nullable|string|max:20',
            'billingAddress.country' => 'nullable|string|max:255',
            'billingAddress.tax_rate_id' => 'nullable|exists:tax_rates,id',
        ]);

        $client = Client::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'company_name' => $request->companyName,
            'phone_number' => $request->phoneNumber,
            'email' => $request->email,
            'lead_source' => $request->leadSource,
        ]);
        if ($request->has('addresses')) {
            foreach ($request->addresses as $address) {
                $client->addresses()->create($address + ['type' => 'property']);
                // $client->addresses()->create($address + ['type' => 'billing']);
            }
        }
        if (!$request->has('same_as_billing') && $request->billing_address) {
            $client->addresses()->create($request->billing_address + ['type' => 'billing']);
        }

        return redirect()->route('clients.index')->with('success', 'Client created successfully!');
    }

    public function edit(Client $client)
    {
        $taxRates = TaxRate::where('user_id', Auth::id())->get();
        $client->load('addresses');
        return view('admin.pages.client.partials.add', [
            'client' => $client->load('addresses'),
            'taxRates' => $taxRates,
            'editMode' => true
        ]);
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'firstName' => 'required',
            'lastName'  => 'required',
            'email'     => 'nullable|email',
            'companyName' => 'nullable|string|max:255',
            'phoneNumber' => 'nullable|string|max:50',
            'leadSource' => 'nullable|string|max:255',
            'sameAsBilling' => 'nullable|boolean',
            'addresses' => 'nullable|array',
            'addresses.*.street1' => 'nullable|string|max:255',
            'addresses.*.street2' => 'nullable|string|max:255',
            'addresses.*.city' => 'nullable|string|max:255',
            'addresses.*.province' => 'nullable|string|max:255',
            'addresses.*.postalCode' => 'nullable|string|max:20',
            'addresses.*.country' => 'nullable|string|max:255',
            'addresses.*.tax_rate_id' => 'nullable|exists:tax_rates,id',
            'billingAddress' => 'nullable|array',
            'billingAddress.street1' => 'nullable|string|max:255',
            'billingAddress.street2' => 'nullable|string|max:255',
            'billingAddress.city' => 'nullable|string|max:255',
            'billingAddress.province' => 'nullable|string|max:255',
            'billingAddress.postalCode' => 'nullable|string|max:20',
            'billingAddress.country' => 'nullable|string|max:255',
            'billingAddress.tax_rate_id' => 'nullable|exists:tax_rates,id',
        ]);

        $client->update([
            'title' => $request->title,
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'company_name' => $request->companyName,
            'phone_number' => $request->phoneNumber,
            'email' => $request->email,
            'lead_source' => $request->leadSource,
        ]);

        $client->addresses()->delete();

        if ($request->has('addresses')) {
            foreach ($request->addresses as $address) {
                $client->addresses()->create($address + ['type' => 'property']);
            }
        }
        if (!$request->has('same_as_billing') && $request->billing_address) {
            $client->addresses()->create($request->billing_address + ['type' => 'billing']);
        }

        return redirect()->route('clients.index')->with('success', 'Client updated successfully!');
    }

    public function addTag(Request $request)
    {
        $client = Client::findOrFail($request->client_id);
        $oldTags = $client->tags ? explode(',', $client->tags) : [];
        $newTags = array_merge($oldTags, $request->tags);
        $client->tags = implode(',', array_unique($newTags));
        $client->save();
        return response()->json(['success' => true]);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully!');
    }

 
}
