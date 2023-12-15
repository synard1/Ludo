<div class="col-lg-8 fv-row">
<select wire:model="selectedReporter" id="reporter-dropdown"  name="reporter-dropdown" class="js-select2 form-control">
        <option value="">Select Reporter Name</option>
        @foreach ($reporterNames as $name)
            <option value="{{ $name }}">{{ $name }}</option>
        @endforeach
    </select>
</div>

@push('scripts')
<script>
$('#reporter-dropdown').select2({
    tags: true, // Enable tags for new values
    // maximumSelectionLength: 2
});

// $('#reporter-dropdown').on('select2:select', function (e) {
//     @this.set('selectedReporter', e.params.data.text);
//     // @this.set('selectedReporter', ucfirst(e.params.data.text));
// });

// // Handle tag removal
// $('#reporter-dropdown').on('select2:unselect', function (e) {
//     // Check if it's a tag that the user added (not an existing option)
//     if (e.params && e.params.data && e.params.data.newTag) {
//         // You can add additional logic here, like confirming the removal.
//         // For now, we'll remove it without confirmation.
//         $('#reporter-dropdown').select2('open'); // Reopen the dropdown
//     }
// });

// // Helper function to capitalize the first letter
// function ucfirst(str) {
//     return str.charAt(0).toUpperCase() + str.slice(1);
// }
</script>
@endpush

