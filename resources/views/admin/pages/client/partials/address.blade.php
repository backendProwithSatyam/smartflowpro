
@push('styles')
<style>
 .btn-custom-secondary{
  background-color: #fff;
        color:#388523;
        border: #388523 solid 1px;
}
.btn-custom-secondary:hover {
    background-color: #388523;
  color:#fff;
}
</style>
@endpush
<div class="address-group p-3 mb-3">
    <div class="row">
        <div class="col-md-12">
            <label>Street 1</label>
            <input type="text" class="form-control"
                name="{{ is_numeric($index) ? "addresses[$index][street1]" : "billing_address[street1]" }}"
                value="{{ old("addresses.$index.street1", $address['street1'] ?? '') }}">
        </div>
        <div class="col-md-12">
            <label>Street 2</label>
            <input type="text" class="form-control"
                name="{{ is_numeric($index) ? "addresses[$index][street2]" : "billing_address[street2]" }}"
                value="{{ old("addresses.$index.street2", $address['street2'] ?? '') }}">
        </div>
        <div class="col-md-6">
            <label>City</label>
            <input type="text" class="form-control"
                name="{{ is_numeric($index) ? "addresses[$index][city]" : "billing_address[city]" }}"
                value="{{ old("addresses.$index.city", $address['city'] ?? '') }}">
        </div>
        <div class="col-md-6">
            <label>Province</label>
            <input type="text" class="form-control"
                name="{{ is_numeric($index) ? "addresses[$index][province]" : "billing_address[province]" }}"
                value="{{ old("addresses.$index.province", $address['province'] ?? '') }}">
        </div>
        <div class="col-md-6">
            <label>Postal Code</label>
            <input type="text" class="form-control"
                name="{{ is_numeric($index) ? "addresses[$index][postal_code]" : "billing_address[postal_code]" }}"
                value="{{ old("addresses.$index.postal_code", $address['postal_code'] ?? '') }}">
        </div>
        <div class="col-md-6">
            <label>Country</label>
            <input type="text" class="form-control"
                name="{{ is_numeric($index) ? "addresses[$index][country]" : "billing_address[country]" }}"
                value="{{ old("addresses.$index.country", $address['country'] ?? '') }}">
        </div>
        <div class="col-md-12">
            <label>Tax Rate</label>
            <div class="input-group">
                <select class="form-select"
                    name="{{ is_numeric($index) ? "addresses[$index][tax_rate_id]" : "billing_address[tax_rate_id]" }}">
                    <option value="">-- Select --</option>
                    @foreach($taxRates as $rate)
                        <option value="{{ $rate->id }}" {{ old("addresses.$index.tax_rate_id", $address['tax_rate_id'] ?? '') == $rate->id ? 'selected' : '' }}>
                            {{ $rate->name }} ({{ $rate->rate }}%)
                        </option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                    data-bs-target="#taxRateModal">+</button>
            </div>
        </div>
    </div>
</div>