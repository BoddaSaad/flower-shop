<form class="flex flex-col gap-7" wire:submit.prevent="addToCart">
    <div class="flex flex-col gap-4">
        <div>
            <label for="gift-message" class="block text-sm font-medium mb-2">رسالة الإهداء</label>
            @error('message') <span class="text-red-700 block mb-3 text-sm">{{ $message }}</span> @enderror
            <textarea wire:model="message" id="gift-message" class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" rows="3"></textarea>
        </div>
        <div>
            <label for="gift-receiver" class="block text-sm font-medium mb-2">رقم المستلم</label>
            @error('receiver_number') <span class="text-red-700 block mb-3 text-sm">{{ $message }}</span> @enderror
            <input wire:model="receiver_number" id="gift-receiver" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border">
        </div>
        <div>
            <label for="gift-calendar" class="block text-sm font-medium mb-2">تاريخ التوصيل</label>
            @error('delivery_date') <span class="text-red-700 block mb-3 text-sm">{{ $message }}</span> @enderror
            <input wire:model="delivery_date" readonly id="gift-calendar" class="hs-datepicker py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-600 focus:ring-blue-600 disabled:opacity-50 disabled:pointer-events-none" type="text">
        </div>
        <div>
            <label class="block text-sm font-medium mb-2">هدايا مع المنتج (اختياري)</label>
            <div class="w-full overflow-y-auto whitespace-nowrap space-x-3">
                @foreach($product->gifts as $gift)
                    <button wire:click="toggleGift({{ $gift->id }})" type="button" class="cursor-pointer">
                        <div class="size-24 rounded-lg  border flex justify-center @if(in_array($gift->id, $gifts)) border-slate-700 border-2 @endif">
                            <img class="h-full object-cover" src="{{ $gift->getFirstMediaUrl() }}" alt="{{ $gift->name }}">
                        </div>
                        <div class="flex flex-col text-sm">
                            <span>{{ $gift->name }}</span>
                            <span class="flex items-center justify-center gap-1">+{{ $gift->price }} @include('components.layouts.riyal-icon', ['class' => 'size-3 fill-slate-900'])</span>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <!-- Input Number -->
        <div class="py-2 px-3 bg-white border border-gray-200 rounded-lg" id="input-number" data-hs-input-number='{
  "min": 1
}'>
            <div class="w-full flex justify-between items-center gap-x-5">
                <div class="grow">
                    <span class="block text-xs text-gray-500">
                        اختر الكمية
                    </span>
                    <input value="1" class="w-full p-0 bg-transparent border-0 text-gray-800 focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none" style="-moz-appearance: textfield;" type="number" aria-roledescription="Number field" data-hs-input-number-input="">
                </div>
                <div class="flex justify-end items-center gap-x-1.5">
                    <button type="button" class="size-6 cursor-pointer inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-full border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900" tabindex="-1" aria-label="Decrease" data-hs-input-number-decrement="">
                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                        </svg>
                    </button>
                    <button type="button" class="size-6 cursor-pointer inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-full border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900" tabindex="-1" aria-label="Increase" data-hs-input-number-increment="">
                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                            <path d="M12 5v14"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- End Input Number -->
        <div class="w-full">
            <button type="submit" class="w-full border-2 border-slate-800 text-slate-800 hover:bg-slate-800 hover:text-white font-bold transition rounded-full py-2 cursor-pointer flex items-center justify-center gap-2">
                <x-heroicon-o-shopping-cart class="size-6" />
                إضافة للعربة
            </button>
        </div>
    </div>
</form>
