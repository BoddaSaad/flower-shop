<div class="flex flex-col gap-3 border rounded-xl p-1 shadow-lg">
    <a href="{{ route('products.product') }}">
        <img class="w-full h-96 object-cover rounded-lg" alt="باقة بألوان الورد الصيفية" src="https://images.pexels.com/photos/12561872/pexels-photo-12561872.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load">
    </a>
    <a href="{{ route('products.product') }}">
        <h3 class="text-slate-700 font-bold mt-2 text-center line-clamp-1" title="باقة بألوان الورد الصيفية">
            باقة بألوان الورد الصيفية
        </h3>
    </a>
    <div class="flex flex-col items-center justify-between gap-2 px-3 mb-3">
        <div class="font-bold text-lg text-slate-700">
            <span class="flex items-center gap-2"><del class="text-base text-red-700">200</del> 150 @include('components.layouts.riyal-icon', ['class' => 'size-4 fill-slate-700'])</span>
        </div>
        <div class="w-full">
            <button class="w-full border-2 border-slate-800 text-slate-800 hover:bg-slate-800 hover:text-white font-bold transition rounded-full py-2 cursor-pointer flex items-center justify-center gap-2">
                <x-heroicon-o-shopping-cart class="size-6" />
                إضافة للعربة
            </button>
        </div>
    </div>
</div>
