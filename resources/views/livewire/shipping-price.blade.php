<div>
    <form wire:submit="create">
        {{ $this->form }}

        <x-filament::button type="submit" class="mt-5">
            حفظ
        </x-filament::button>
    </form>

    <x-filament-actions::modals />
</div>
