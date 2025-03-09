<div class="">
    @foreach ($specifications as $index => $spec)
        <div class="flex gap-2 mb-2">
            <input type="text" wire:model="specifications.{{ $index }}.key" placeholder="Key"
                   class="border p-2 rounded w-1/2">
            <input type="text" wire:model="specifications.{{ $index }}.value" placeholder="Value"
                   class="border p-2 rounded w-1/2">
            <button wire:click="removeSpecification({{ $index }})" class="text-danger px-3 rounded">X</button>
        </div>
    @endforeach

    <button wire:click="addSpecification" class="text-information px-3 py-1 rounded">+ Add Specification</button>

    @if (session()->has('message'))
        <div class="mt-2 text-green-600">
            {{ session('message') }}
        </div>
    @endif
</div>
