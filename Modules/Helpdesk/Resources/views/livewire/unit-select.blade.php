<div class="col-lg-8 fv-row">
    <select wire:model="selectedUnit" id="unit-dropdown" name="unit-dropdown" class="js-select2 form-control">
        <option value="">Select Unit Name</option>
        @foreach ($UnitNames as $name)
            <option value="{{ $name }}">{{ $name }}</option>
        @endforeach
    </select>
</div>

    @push('scripts')
    <script>
    $('#unit-dropdown').select2({
        tags: true, // Enable tags for new values
        // maximumSelectionLength: 2
    });

    // $('#unit-dropdown').on('select2:select', function (e) {
    //     @this.set('selectedUnit', e.params.data.text);
    //     // @this.set('selectedUnit', ucfirst(e.params.data.text));
    // });

    // // Handle tag removal
    // $('#unit-dropdown').on('select2:unselect', function (e) {
    //     // Check if it's a tag that the user added (not an existing option)
    //     if (e.params && e.params.data && e.params.data.newTag) {
    //         // You can add additional logic here, like confirming the removal.
    //         // For now, we'll remove it without confirmation.
    //         $('#unit-dropdown').select2('open'); // Reopen the dropdown
    //     }
    // });

    // // Helper function to capitalize the first letter
    // function ucfirst(str) {
    //     return str.charAt(0).toUpperCase() + str.slice(1);
    // }
    </script>
    @endpush

