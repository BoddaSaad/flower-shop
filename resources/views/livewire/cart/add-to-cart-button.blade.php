<button wire:click="addToCart" class="md:text-base text-sm w-full border-2 border-slate-800 text-slate-800 hover:bg-slate-800 hover:text-white font-bold transition rounded-full py-2 flex items-center justify-center cursor-pointer">
    <span wire:loading.remove class="flex items-center justify-center gap-2">
        <x-heroicon-o-shopping-cart class="md:size-6 size-4" />
        إضافة للعربة
    </span>
    <div wire:loading class="animate-spin inline-block size-5 border-3 border-current border-t-transparent rounded-full flex items-center justify-center" role="status" aria-label="loading">
        <span class="sr-only">Loading...</span>
    </div>
</button>
