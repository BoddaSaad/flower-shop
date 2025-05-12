<div class="grid grid-cols-4 gap-5">
    <div class="col-span-3 flex flex-col gap-5">
        @foreach($cartItems as $item)
            <livewire:cart.cart-item :item="$item" :key="$item->id"/>
        @endforeach
    </div>
    <div>
        <div class="border rounded-2xl p-7 flex flex-col gap-5 sticky top-5">
            <h4 class="text-xl font-semibold text-slate-700">ملخص الطلب</h4>
            <div class="flex justify-between">
                <span class="text-slate-600">مجموع المنتجات</span>
                <span class="flex items-center gap-2 font-semibold">{{ $summary['subtotal'] }} @include('components.layouts.riyal-icon', ['class' => 'size-4 fill-slate-900'])</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-600">التوصيل</span>
                <span class="flex items-center gap-2 font-semibold">{{ $summary['shippingCost'] }} @include('components.layouts.riyal-icon', ['class' => 'size-4 fill-slate-900'])</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-600">الإجمالي</span>
                <span class="flex items-center gap-2 font-semibold">{{ $summary['total'] }} @include('components.layouts.riyal-icon', ['class' => 'size-4 fill-slate-900'])</span>
            </div>
            @if(!$allItemsValid)
                <span class="text-red-600">يرجى إكمال بيانات الطلبات</span>
            @endif
            <button wire:click="checkout" class="bg-slate-800 py-3 rounded-full text-white font-bold cursor-pointer
              {{ $allItemsValid ? 'hover:bg-slate-900' : 'opacity-50 cursor-not-allowed' }} transition"
                    {{ $allItemsValid ? '' : 'disabled' }}>
                إتمام الطلب
            </button>
        </div>
    </div>
</div>
