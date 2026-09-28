<div class="md:col-span-2 bg-blue-50 p-4 rounded-lg border border-blue-100 mb-4">
    <h4 class="text-sm font-bold text-blue-800 mb-3">Structured Location</h4>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">Country</label>
            <select id="loc-country" class="w-full rounded-md border-gray-300 shadow-sm text-sm border p-2">
                <option value="">Select Country</option>
                @if(isset($countries))
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" data-name="{{ $country->name }}">{{ $country->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">State/Province</label>
            <select id="loc-state" class="w-full rounded-md border-gray-300 shadow-sm text-sm border p-2" disabled>
                <option value="">Select State</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">City</label>
            <select id="loc-city" class="w-full rounded-md border-gray-300 shadow-sm text-sm border p-2" disabled>
                <option value="">Select City</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">Area/Locality</label>
            <select id="loc-area" class="w-full rounded-md border-gray-300 shadow-sm text-sm border p-2" disabled>
                <option value="">Select Area</option>
            </select>
        </div>
    </div>
    
    <input type="hidden" name="location_id" id="real_location_id" value="{{ old('location_id', $entity->location_id ?? '') }}">
    <p class="text-xs text-blue-600 mt-2"><i class="fas fa-info-circle"></i> Selecting a location will automatically fill the City and Area text fields below.</p>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countrySel = document.getElementById('loc-country');
        const stateSel = document.getElementById('loc-state');
        const citySel = document.getElementById('loc-city');
        const areaSel = document.getElementById('loc-area');
        const realId = document.getElementById('real_location_id');
        
        // Form specific inputs
        const formCity = document.querySelector('input[name="city"]') || document.querySelector('input[name="location"]');
        const formArea = document.querySelector('input[name="area_locality"]');
        
        function updateRealId() {
            if(areaSel.value) realId.value = areaSel.value;
            else if(citySel.value) realId.value = citySel.value;
            else if(stateSel.value) realId.value = stateSel.value;
            else if(countrySel.value) realId.value = countrySel.value;
            else realId.value = '';
            
            // Auto fill text fields for backward compatibility
            if(citySel.value && formCity) formCity.value = citySel.options[citySel.selectedIndex].text;
            if(areaSel.value && formArea) formArea.value = areaSel.options[areaSel.selectedIndex].text;
            else if(stateSel.value && formCity && !citySel.value) formCity.value = stateSel.options[stateSel.selectedIndex].text;
        }

        async function fetchChildren(parentId, targetSelect) {
            targetSelect.innerHTML = '<option value="">Loading...</option>';
            targetSelect.disabled = true;
            
            try {
                const res = await fetch(`/admin/locations/${parentId}/children`);
                const data = await res.json();
                
                targetSelect.innerHTML = '<option value="">Select Option</option>';
                data.forEach(loc => {
                    const opt = document.createElement('option');
                    opt.value = loc.id;
                    opt.textContent = loc.name;
                    targetSelect.appendChild(opt);
                });
                
                targetSelect.disabled = data.length === 0;
            } catch(e) {
                targetSelect.innerHTML = '<option value="">Error</option>';
            }
        }

        countrySel.addEventListener('change', function() {
            stateSel.innerHTML = '<option value="">Select State</option>'; stateSel.disabled = true;
            citySel.innerHTML = '<option value="">Select City</option>'; citySel.disabled = true;
            areaSel.innerHTML = '<option value="">Select Area</option>'; areaSel.disabled = true;
            
            if(this.value) {
                fetchChildren(this.value, stateSel);
            }
            updateRealId();
        });

        stateSel.addEventListener('change', function() {
            citySel.innerHTML = '<option value="">Select City</option>'; citySel.disabled = true;
            areaSel.innerHTML = '<option value="">Select Area</option>'; areaSel.disabled = true;
            
            if(this.value) {
                fetchChildren(this.value, citySel);
            }
            updateRealId();
        });

        citySel.addEventListener('change', function() {
            areaSel.innerHTML = '<option value="">Select Area</option>'; areaSel.disabled = true;
            
            if(this.value) {
                fetchChildren(this.value, areaSel);
            }
            updateRealId();
        });

        areaSel.addEventListener('change', updateRealId);
    });
</script>
