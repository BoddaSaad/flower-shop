<x-layouts.main>
    <div class="container mx-auto">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            الطلبات السابقة
        </h2>

        @forelse($orders as $order)
            <div class="mt-5 p-10 rounded-xl border">
                <div class="flex justify-between border-b mb-4 pb-3">
                    <div class="flex gap-5">
                        <span class="text-slate-700">رقم الطلب: {{ $order->reference }}</span>
                        <span class="text-slate-700">حالة الطلب: {{ ucfirst($order->status) }}</span>
                    </div>
                    <div class="flex gap-5">
                        <span class="text-slate-700">تاريخ الطلب: {{ $order->created_at->translatedFormat('d M Y') }}</span>
                        <span class="text-slate-700">إجمالي الطلب: {{ $order->amount_in_cents / 100 }}</span>
                    </div>
                </div>
                @foreach($order->items as $item)
                    <div class="flex items-start justify-between my-3 gap-5">
                        <div class="flex items-start gap-5">
                            <img src="{{ $item->product->getFirstMediaUrl() }}" alt="{{ $item->product->name }}" class="w-24 h-24 object-cover rounded-lg">
                            <div>
                                <h4 class="font-semibold">{{ $item->product->name }}</h4>
                                <div class="flex gap-2">
                                    <span class="text-slate-500 text-sm">الكمية: {{ $item->quantity }}</span>
                                    <span class="text-slate-500 text-sm font-semibold flex items-center gap-1">السعر: {{ $item->unit_price_in_cents / 100 }} @include('components.layouts.riyal-icon', ['class' => 'size-3 fill-slate-500'])</span>
                                </div>
                                <span class="text-slate-700 block">تاريخ التوصيل: {{ $item->delivery_date }}</span>
                                <span class="text-slate-700 block">رقم المستلم: {{ $item->receiver_number }}</span>
                            </div>
                        </div>
                        @if($item->gifts->count())
                            <ul class="list-disc">
                                <span class="text-slate-700 font-semibold">الهدايا</span>
                                @foreach($item->gifts as $gift)
                                    <li>{{ $gift->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <span>الإجمالي: {{ (($item->unit_price_in_cents / 100) * $item->quantity) + $item->gifts->sum('price') }}</span>
                    </div>
                @endforeach
            </div>
        @empty
            <div class="rounded-xl border justify-center items-center flex flex-col gap-5 h-96 mt-10">
                <x-heroicon-o-shopping-cart class="size-16 text-slate-400"/>
                <h3 class="text-slate-400 font-semibold text-xl">لا توجد طلبات سابقة</h3>
            </div>
        @endforelse
    </div>
</x-layouts.main>
