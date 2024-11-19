<div class="flex space-x-2">
    <button wire:click="approve({{ $record->id }})" class="text-green-500 hover:text-green-700">
        <x-heroicon-o-check class="w-5 h-5" />
    </button>
    <button wire:click="reject({{ $record->id }})" class="text-red-500 hover:text-red-700">
        <x-heroicon-o-x class="w-5 h-5" />
    </button>
</div>