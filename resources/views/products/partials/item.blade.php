<div class="flex flex-col gap-3 border rounded-xl p-1 shadow-lg">
    <a href="{{ route('products.show', $product->slug) }}">
        <img class="w-full h-96 object-cover rounded-lg" alt="{{ $product->name }}" src="{{ $product->getFirstMediaUrl() }}">
    </a>
    <a href="{{ route('products.show', $product->slug) }}">
        <h3 class="text-slate-700 font-bold mt-2 text-center line-clamp-1" title="{{ $product->name }}">
            {{ $product->name }}
        </h3>
    </a>
    <div class="flex flex-col items-center justify-between gap-2 px-3 mb-3">
        <div class="font-bold text-lg text-slate-700">
            <span class="flex items-center gap-2">
                @if($product->discount != 0) <del class="text-base text-red-700">{{ $product->price }}</del> @endif
                {{ $product->final_price }} @include('components.layouts.riyal-icon', ['class' => 'size-4 fill-slate-700'])</span>
        </div>
        <div class="w-full">
            <livewire:cart.add-to-cart-button :product-id="$product->id"/>
        </div>
    </div>
</div>
