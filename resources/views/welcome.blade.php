<x-layouts.main>
    <div class="container mx-auto mb-10">
    <div data-hs-carousel='{
"loadingClasses": "opacity-0",
"isAutoPlay": true,
"isDraggable": true,
"isRTL": true
}' class="relative">
        <div class="hs-carousel relative overflow-hidden w-full aspect-4/1 bg-white rounded-lg">
            <div class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0">
                @foreach($banners as $banner)
                <div class="hs-carousel-slide">
                    <a href="{{ $banner->url ?? "#" }}" class="block rounded-2xl overflow-hidden shadow-xl">
                        <img class="w-full aspect-4/1 object-cover" src="{{ $banner->getFirstMediaUrl() }}" alt="{{ $banner->name }}">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
    <div class="container mx-auto">
        <div data-hs-carousel='{
    "loadingClasses": "opacity-0",
    "isRTL": true,
    "slidesQty": {
        "xs": 2,
        "sm": 4,
        "md": 6,
        "lg": 8
      }
  }' class="relative" dir="rtl">
            <div class="relative py-3 mb-2 flex items-center font-medium text-2xl text-slate-600 after:flex-1 after:border-t after:border-slate-200 after:ms-6">
                <span>اختر من التشكيلات ما تحب!</span>
                <div class="flex items-center absolute left-0 bg-white">
                    <button type="button" class="hs-carousel-prev hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none inline-flex justify-center items-center w-11.5 h-full text-gray-800 hover:bg-gray-800/10 focus:outline-hidden focus:bg-gray-800/10 cursor-pointer rounded-s-lg">
                        <span class="text-2xl" aria-hidden="true">
                          <svg class="shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6"></path>
                          </svg>
                        </span>
                        <span class="sr-only">السابق</span>
                    </button>
                    <button type="button" class="hs-carousel-next hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none inline-flex justify-center items-center w-11.5 h-full text-gray-800 hover:bg-gray-800/10 focus:outline-hidden focus:bg-gray-800/10 cursor-pointer rounded-e-lg">
                        <span class="sr-only">التالي</span>
                        <span class="text-2xl" aria-hidden="true">
                          <svg class="shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6"></path>
                          </svg>
                        </span>
                    </button>
                </div>
            </div>
            <div class="hs-carousel relative overflow-hidden w-full min-h-50 bg-white rounded-lg">
                <div class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0">
                    @foreach($featuredCategories as $category)
                        <div class="hs-carousel-slide flex flex-col items-center">
                            <a href="{{ route('products.index', ['filter[category]' => $category->id]) }}" class="flex justify-center size-30 rounded-full overflow-hidden">
                                <img class="object-cover size-full" src="{{ $category->getFirstMediaUrl() }}" alt="">
                            </a>
                            <a href="{{ route('products.index', ['filter[category]' => $category->id]) }}" class="font-medium text-slate-700 mt-2">
                                {{ $category->name }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        @foreach($landingCategories as $category)
            <div class="mb-10">
                <div class="relative py-3 mb-2 flex items-center font-medium text-lg sm:text-xl md:text-2xl text-slate-600 after:flex-1 after:border-t after:border-slate-200 after:ms-6">
                    <span>{{ $category->name }}</span>
                    <div class="absolute left-0">
                        <a href="{{ route('products.index', ['filter[category]' => $category->id]) }}" class="border-2 border-slate-200 bg-white hover:bg-slate-200 font-bold text-lg px-5 py-2 text-slate-400 rounded-full hover:text-slate-500 transition">
                            عرض المزيد
                        </a>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 md:gap-5 gap-2">
                    @foreach($category->products as $product)
                        <div>
                            @include('products.partials.item', ['product' => $product])
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</x-layouts.main>
