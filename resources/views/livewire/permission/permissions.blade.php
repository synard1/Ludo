<div>
<!-- <button type="button" class="btn btn-light-primary" wire:click="create()">
                        {!! getIcon('plus-square','fs-3') !!}
                        Add Permission
                    </button> -->
                    <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_permission" wire:click="create()">
                        {!! getIcon('plus-square','fs-3') !!}
                        Add Permission
                    </button>
<!-- <button wire:click="create()" class="btn btn-primary">Create New Permission</button> -->

    @if($isOpen)
        @include('livewire.permission.add-modal')
    @endif
</div>
