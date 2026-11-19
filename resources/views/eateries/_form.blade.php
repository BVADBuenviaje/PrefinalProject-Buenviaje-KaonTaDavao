{{-- Blade Presentation --}}
@if ($errors->any())
    <div class="p-4 rounded-md bg-rose-50 border border-rose-200 text-rose-700 text-sm mb-6">
        <p class="font-semibold mb-1">Please fix the following errors:</p>
        <ul class="list-disc list-inside space-y-1 text-xs">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        {{-- Name --}}
        <div>
            <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">Eatery Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $eatery->name ?? '') }}" class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-amber-500">
            @error('name')
                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- District --}}
        <div>
            <label for="district_id" class="block text-xs font-semibold text-slate-700 mb-1">District</label>
            <select name="district_id" id="district_id" class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm bg-white focus:outline-none focus:ring-1 focus:ring-amber-500">
                <option value="">Select a district</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}" @selected(old('district_id', $eatery->district_id ?? '') == $district->id)>
                        {{ $district->name }}
                    </option>
                @endforeach
            </select>
            @error('district_id')
                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        {{-- Address --}}
        <div>
            <label for="address" class="block text-xs font-semibold text-slate-700 mb-1">Address</label>
            <input type="text" name="address" id="address" value="{{ old('address', $eatery->address ?? '') }}" class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-amber-500">
            @error('address')
                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Price Range --}}
        <div>
            <label for="price_range" class="block text-xs font-semibold text-slate-700 mb-1">Price Range</label>
            <select name="price_range" id="price_range" class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm bg-white focus:outline-none focus:ring-1 focus:ring-amber-500">
                <option value="">Select price range</option>
                <option value="budget" @selected(old('price_range', $eatery->price_range ?? '') === 'budget')>Budget (₱)</option>
                <option value="mid" @selected(old('price_range', $eatery->price_range ?? '') === 'mid')>Mid (₱₱)</option>
                <option value="splurge" @selected(old('price_range', $eatery->price_range ?? '') === 'splurge')>Splurge (₱₱₱)</option>
            </select>
            @error('price_range')
                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        {{-- Specialty --}}
        <div>
            <label for="specialty" class="block text-xs font-semibold text-slate-700 mb-1">Specialty Dish</label>
            <input type="text" name="specialty" id="specialty" value="{{ old('specialty', $eatery->specialty ?? '') }}" class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-amber-500">
            @error('specialty')
                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Open Status --}}
        <div class="flex items-center pt-6">
            <input type="hidden" name="is_open" value="0">
            <label class="inline-flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_open" value="1" @checked(old('is_open', isset($eatery) ? $eatery->is_open : true)) class="rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                <span class="text-sm font-semibold text-slate-700">Currently Open for Business</span>
            </label>
            @error('is_open')
                <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Features --}}
    <div>
        <label class="block text-xs font-semibold text-slate-700 mb-2">Features / Amenities</label>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            @php
                $selectedFeatures = old('features', isset($eatery) ? $eatery->features->pluck('id')->toArray() : []);
            @endphp
            @foreach ($features as $feature)
                <label class="inline-flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                    <input type="checkbox" name="features[]" value="{{ $feature->id }}" @checked(in_array($feature->id, $selectedFeatures)) class="rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                    <span>{{ $feature->name }}</span>
                </label>
            @endforeach
        </div>
        @error('features')
            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Business Permit Details --}}
    <div class="pt-4 border-t border-slate-200">
        <h3 class="text-sm font-bold text-slate-900 mb-4">Business Permit Information</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="permit_no" class="block text-xs font-semibold text-slate-700 mb-1">Permit Number (e.g. DVO-2026-0415)</label>
                <input type="text" name="permit_no" id="permit_no" value="{{ old('permit_no', $eatery->permit->permit_no ?? '') }}" placeholder="DVO-2026-0415" class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-amber-500">
                @error('permit_no')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="expires_on" class="block text-xs font-semibold text-slate-700 mb-1">Permit Expiry Date</label>
                <input type="date" name="expires_on" id="expires_on" value="{{ old('expires_on', isset($eatery->permit->expires_on) ? $eatery->permit->expires_on->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border border-slate-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-amber-500">
                @error('expires_on')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>
