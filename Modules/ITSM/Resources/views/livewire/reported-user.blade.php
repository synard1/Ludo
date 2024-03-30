<div class="col-lg-8 fv-row">
    <select wire:model="selectedUser" id="reportedBy"  name="reportedBy" class="js-select2 form-control">
            <option value="">=== Select User Reported Name ===</option>
            @foreach ($reportedNames as $name)
                <option value="{{ $name }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
    
    @push('scripts')
    <script>
    $('#reportedBy').select2({
        tags: true, // Enable tags for new values
        // maximumSelectionLength: 2
    });
    </script>
    @endpush
    
    