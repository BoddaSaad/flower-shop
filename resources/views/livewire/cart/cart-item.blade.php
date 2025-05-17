<div class="border rounded-2xl p-7">
    <div class="grid grid-cols-8 gap-5 items-start">
        <div class="flex gap-4 col-span-4">
            <img src="{{ $item->product->getFirstMediaUrl() }}" alt="{{ $item->product->name }}" class="w-24 h-24 object-cover rounded-lg">
            <div class="flex flex-col gap-2">
                <h3 class="text-slate-800 font-bold">{{ $item->product->name }}</h3>
                <span class="flex items-center gap-0.5 font-semibold text-slate-500 text-sm">{{ $item->product->final_price }} @include('components.layouts.riyal-icon', ['class' => 'size-3 fill-slate-500'])</span>
                @foreach($item->gifts as $gift)
                    <ul class="text-sm text-slate-700">
                        <li class="flex items-center gap-1">
                            <x-heroicon-o-gift class="text-slate-700 size-4"/>
                            <span class="flex items-center gap-0.5">
                                {{ $gift->name }}: {{ $gift->price }}
                                @include('components.layouts.riyal-icon', ['class' => 'size-3 fill-slate-700'])
                            </span>
                        </li>
                    </ul>
                @endforeach
            </div>
        </div>
        <div class="col-span-2">
            <!-- Input Number -->
            <div class="py-2 px-3 inline-block bg-white border border-gray-200 rounded-lg input-number" data-hs-input-number='{"min": 1}'>
                <div class="flex items-center gap-x-1.5">
                    <button type="button" class="cursor-pointer size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" tabindex="-1" aria-label="Decrease" data-hs-input-number-decrement="">
                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                        </svg>
                    </button>
                    <input wire:model="quantity" class="p-0 w-6 bg-transparent border-0 text-gray-800 text-center focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none" style="-moz-appearance: textfield;" type="number" aria-roledescription="Number field"  data-hs-input-number-input="">
                    <button type="button" class="cursor-pointer size-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" tabindex="-1" aria-label="Increase" data-hs-input-number-increment="">
                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                            <path d="M12 5v14"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- End Input Number -->
        </div>
        <div class="flex items-center gap-5 col-span-2 justify-end">
            <span class="flex items-center gap-2 text-green-700 font-bold">
                المجموع: {{ ($item->product->final_price * $item->quantity) + $item->gifts->sum('price') }}
                @include('components.layouts.riyal-icon', ['class' => 'size-4 fill-green-700'])
            </span>
            <button wire:click="removeItem">
                <x-heroicon-s-x-circle class="size-8 text-red-400 cursor-pointer hover:text-red-500 transition"/>
            </button>
        </div>
    </div>
    <div class="hs-accordion mt-3 @if ($errors->any()) active @endif" id="hs-basic-with-arrow-heading-one">
        <button class="hs-accordion-toggle hs-accordion-active:text-slate-600 py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-slate-900 hover:text-slate-600 focus:outline-hidden focus:text-slate-600 rounded-lg disabled:opacity-50 disabled:pointer-events-none cursor-pointer" aria-expanded="@if ($errors->any()) active @else false @endif" aria-controls="hs-basic-with-arrow-collapse-one">
            <svg class="hs-accordion-active:hidden block size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m6 9 6 6 6-6"></path>
            </svg>
            <svg class="hs-accordion-active:block hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m18 15-6-6-6 6"></path>
            </svg>
            تفاصيل الطلب
        </button>
        <div id="hs-basic-with-arrow-collapse-one" class="hs-accordion-content @if (!$errors->any()) hidden @endif w-full overflow-hidden transition-[height] duration-300" role="region" aria-labelledby="hs-basic-with-arrow-heading-one">
            <div class="flex gap-4 w-full p-2">
                <div class="w-full">
                    <label for="gift-message" class="block text-sm font-medium mb-2">رسالة الإهداء</label>
                    @error('message') <span class="text-red-700 block mb-3 text-sm">{{ $message }}</span> @enderror
                    <textarea wire:model.blur="message" id="gift-message" class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" rows="3"></textarea>
                </div>
                <div class="w-full flex flex-col gap-4">
                    <div>
                        <label for="gift-receiver" class="block text-sm font-medium mb-2">رقم المستلم</label>
                        @error('receiver_number') <span class="text-red-700 block mb-3 text-sm">{{ $message }}</span> @enderror
                        <input wire:model.blur="receiver_number" id="gift-receiver" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border">
                    </div>
                    <div>
                        <label for="gift-calendar" class="block text-sm font-medium mb-2">تاريخ التوصيل</label>
                        @error('delivery_date') <span class="text-red-700 block mb-3 text-sm">{{ $message }}</span> @enderror
                        <input wire:model="delivery_date" readonly id="gift-calendar" class="gift-calendar hs-datepicker py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-600 focus:ring-blue-600 disabled:opacity-50 disabled:pointer-events-none" type="text">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
