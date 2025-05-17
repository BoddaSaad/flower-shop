<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-black text-white py-3 w-full mt-4 rounded-full text-xl font-bold hover:bg-slate-700 cursor-pointer transition']) }}>
    {{ $slot }}
</button>
