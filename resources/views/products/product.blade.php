<x-layouts.main>
    <div class="container mx-auto">
        <div class="lg:grid grid-cols-2 gap-10">
            <div class="mb-10 lg:mb-0">
                <!-- Slider -->
                <div data-hs-carousel='{
    "loadingClasses": "opacity-0",
    "isRTL": true
  }' class="relative h-full">
                    <div class="hs-carousel flex flex-col md:flex-row gap-2 h-full">
                        <div class="md:order-2 relative grow border overflow-hidden bg-white rounded-lg min-h-100">
                            <div class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0">
                                @foreach($product->getMedia() as $media)
                                    <div class="hs-carousel-slide">
                                        <a href="{{ $media->getFullUrl() }}" class="flex justify-center size-full glightbox cursor-zoom-in" data-gallery="gallery1">
                                            <img alt="{{ $product->name }}" class="max-h-full max-w-full object-cover" src="{{ $media->getFullUrl() }}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="hs-carousel-prev cursor-pointer hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 start-0 inline-flex justify-center items-center w-11.5 h-full text-gray-800 hover:bg-gray-800/10 focus:outline-hidden focus:bg-gray-800/10 rounded-s-lg">
                                <span class="text-2xl" aria-hidden="true">
                                  <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6"></path>
                                  </svg>
                                </span>
                                <span class="sr-only">Previous</span>
                            </button>
                            <button type="button" class="hs-carousel-next cursor-pointer hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 end-0 inline-flex justify-center items-center w-11.5 h-full text-gray-800 hover:bg-gray-800/10 focus:outline-hidden focus:bg-gray-800/10 rounded-e-lg">
                                <span class="sr-only">Next</span>
                                <span class="text-2xl" aria-hidden="true">
                                  <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m15 18-6-6 6-6"></path>
                                  </svg>
                                </span>
                            </button>
                        </div>

                        <div class="md:order-1 flex-none">
                            <div class="hs-carousel-pagination max-h-140 flex flex-row md:flex-col gap-2 overflow-x-auto md:overflow-x-hidden md:overflow-y-auto">
                                @foreach($product->getMedia() as $media)
                                    <div class="hs-carousel-pagination-item shrink-0 border border-gray-200 rounded-md overflow-hidden cursor-pointer size-20 md:size-32 hs-carousel-active:border-blue-400">
                                        <img alt="{{ $product->name }}" class="object-cover w-full" src="{{ $media->getFullUrl() }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Slider -->
            </div>
            <div class="p-10 border rounded-xl flex flex-col gap-7">
                <div class="flex items-center justify-between">
                    <h2 class="text-3xl font-bold">{{ $product->name }}</h2>
                    <div class="font-bold text-2xl">
                        <span class="flex items-center gap-2">
                            @if($product->discount != 0) <del class="text-lg text-red-700">{{ $product->price }}</del> @endif
                            {{ $product->final_price }} @include('components.layouts.riyal-icon', ['class' => 'size-4 fill-slate-700'])</span>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <div>
                        <label for="gift-message" class="block text-sm font-medium mb-2">رسالة الإهداء</label>
                        <textarea id="gift-message" class="py-2 px-3 sm:py-3 sm:px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border" rows="3"></textarea>
                    </div>
                    <div>
                        <label for="gift-receiver" class="block text-sm font-medium mb-2">رقم المستلم</label>
                        <input id="gift-receiver" class="py-2.5 sm:py-3 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none border">
                    </div>
                    <div>
                        <label for="gift-calendar" class="block text-sm font-medium mb-2">تاريخ التوصيل</label>
                        <input readonly id="gift-calendar" class="hs-datepicker py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-600 focus:ring-blue-600 disabled:opacity-50 disabled:pointer-events-none" type="text">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">هدايا مع المنتج</label>
                        <div class="w-full overflow-y-auto whitespace-nowrap space-x-3">
                            @foreach($product->gifts as $gift)
                                <button class="cursor-pointer" onclick="this.querySelector('div').classList.toggle('border-slate-700'); this.querySelector('div').classList.toggle('border-2');">
                                    <div class="size-24 rounded-lg  border flex justify-center">
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
                    <div class="py-2 px-3 bg-white border border-gray-200 rounded-lg" data-hs-input-number='{
  "min": 1
}'>
                        <div class="w-full flex justify-between items-center gap-x-5">
                            <div class="grow">
                                <span class="block text-xs text-gray-500">
                                    اختر الكمية
                                </span>
                                <input class="w-full p-0 bg-transparent border-0 text-gray-800 focus:ring-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none" style="-moz-appearance: textfield;" type="number" aria-roledescription="Number field" value="1" data-hs-input-number-input="">
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
                        <button class="w-full border-2 border-slate-800 text-slate-800 hover:bg-slate-800 hover:text-white font-bold transition rounded-full py-2 cursor-pointer flex items-center justify-center gap-2">
                            <x-heroicon-o-shopping-cart class="size-6" />
                            إضافة للعربة
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10">
            <div class="relative py-3 mb-2 flex items-center font-medium text-2xl text-slate-600 after:flex-1 after:border-t after:border-slate-200 after:ms-6">
                <span>منتجات قد تعجبك</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                @foreach($randomProducts as $product)
                    <div class="hs-carousel-slide">
                        @include('products.partials.item', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.main>
