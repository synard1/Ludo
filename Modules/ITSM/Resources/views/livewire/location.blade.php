<div class="col-lg-8 fv-row">
    <select wire:model="selectedLocation" id="location" name="location" class="js-select2 form-control">
        <option value="">=== Select Location ===</option>
        @foreach ($locationName as $name)
            <option value="{{ $name }}">{{ $name }}</option>
        @endforeach
    </select>
</div>

    @push('scripts')
    <script>
    $('#location').select2({
        tags: true, // Enable tags for new values
        // maximumSelectionLength: 2
    });
    </script>
    @endpush

