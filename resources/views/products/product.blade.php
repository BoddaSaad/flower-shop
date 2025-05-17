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

                <livewire:cart.add-to-cart-form :product="$product"/>
            </div>
        </div>

        <div class="mt-10">
            <div class="relative py-3 mb-2 flex items-center font-medium text-2xl text-slate-600 after:flex-1 after:border-t after:border-slate-200 after:ms-6">
                <span>منتجات قد تعجبك</span>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 md:gap-5 gap-2">
                @foreach($randomProducts as $product)
                    @include('products.partials.item', ['product' => $product])
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.main>
