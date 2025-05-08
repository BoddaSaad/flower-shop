<header class="mb-10">
    <nav class="flex items-center justify-between container mx-auto py-4">
        <div class="flex items-center gap-4">
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 20 20"><path fill="#000" d="M20 10c0-5.523-4.477-10-10-10S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.093 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.563V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.129 20 14.991 20 10"></path></svg>
            </a>
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 16 16"><path fill="#000" fill-rule="evenodd" d="M11.384 9.489c-.186-.093-1.099-.542-1.269-.604s-.294-.093-.418.093c-.124.185-.48.604-.588.728s-.217.14-.402.046c-.186-.093-.784-.289-1.494-.922A5.6 5.6 0 0 1 6.18 7.544c-.108-.186-.012-.287.081-.38.084-.082.186-.216.279-.325.093-.108.124-.186.186-.31.062-.123.03-.232-.016-.325s-.418-1.007-.572-1.379c-.151-.362-.304-.313-.418-.319a8 8 0 0 0-.356-.006.68.68 0 0 0-.495.232c-.17.186-.65.636-.65 1.55s.665 1.797.758 1.92c.093.125 1.31 2 3.173 2.805.443.192.789.306 1.058.391.445.142.85.122 1.17.074.357-.053 1.099-.45 1.254-.883.155-.434.155-.806.108-.883-.046-.078-.17-.124-.356-.217m-3.389 4.627h-.002a6.17 6.17 0 0 1-3.145-.861l-.225-.134-2.338.613.624-2.28-.147-.233a6.16 6.16 0 0 1-.945-3.288 6.187 6.187 0 0 1 6.18-6.178c1.65.001 3.202.644 4.369 1.812a6.14 6.14 0 0 1 1.807 4.37 6.187 6.187 0 0 1-6.178 6.179M13.253 2.68A7.39 7.39 0 0 0 7.995.5C3.898.5.564 3.834.562 7.932c0 1.31.342 2.59.992 3.716L.5 15.5l3.94-1.034a7.4 7.4 0 0 0 3.552.905h.003c4.097 0 7.432-3.334 7.433-7.433a7.4 7.4 0 0 0-2.175-5.258" clip-rule="evenodd"></path></svg>
            </a>
        </div>
        <div>
            <a href="{{ route('home') }}">
                <img src="{{ asset('Calla-Logo.png') }}" alt="Logo" class="h-12">
            </a>
        </div>
        <div class="flex items-center gap-3">
            @auth()
                <a href="{{ route('dashboard') }}">
                    <x-heroicon-o-user class="size-6"/>
                </a>
            @else
                <a href="{{ route('login') }}">
                    <x-heroicon-o-user class="size-6"/>
                </a>
            @endauth
            <button class="cursor-pointer" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-vertically-centered-modal" data-hs-overlay="#hs-vertically-centered-modal">
                <x-heroicon-o-magnifying-glass class="size-6"/>
            </button>
            <a href="#">
                <x-heroicon-o-shopping-bag class="size-6"/>
            </a>
        </div>
    </nav>
    <nav class="py-3 bg-slate-100">
        <ul class="flex items-center justify-center container mx-auto gap-6 font-medium">
            <li><a href="#" class="text-slate-700">هدايا ورد</a></li>
            <li><a href="#" class="text-slate-700">كيك هدية</a></li>
            <li><a href="#" class="text-slate-700">عطور هدية</a></li>
            <li><a href="#" class="text-slate-700">باقات ورد</a></li>
            <li><a href="#" class="text-slate-700">ورد مع شوكولاتة</a></li>
        </ul>
    </nav>
</header>

<div id="hs-vertically-centered-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto pointer-events-none" role="dialog" tabindex="-1" aria-labelledby="hs-vertically-centered-modal-label">
    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto min-h-[calc(100%-56px)] flex items-center">
        <form action="{{ route('products.index') }}" class="w-full flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto">
            <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200">
                <h3 id="hs-vertically-centered-modal-label" class="font-bold text-gray-800">
                    البحث
                </h3>
                <button type="button" class="cursor-pointer size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none" aria-label="Close" data-hs-overlay="#hs-vertically-centered-modal">
                    <span class="sr-only">إغلاق</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4 overflow-y-auto">
                <input name="search" type="text" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-slate-500 focus:ring-slate-500" placeholder="باقة ورود..." autofocus="" autocomplete="off">
            </div>
            <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200">
                <button type="button" class="cursor-pointer py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" data-hs-overlay="#hs-vertically-centered-modal">
                    إغلاق
                </button>
                <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-slate-600 text-white hover:bg-slate-700 focus:outline-hidden focus:bg-slate-700 disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
                    بحث
                </button>
            </div>
        </form>
    </div>
</div>
