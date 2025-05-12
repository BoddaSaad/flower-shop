import 'preline'
import 'lodash'
import { Calendar } from "vanilla-calendar-pro";
import GLightbox from 'glightbox';
import Toastify from 'toastify-js'

const lightbox = GLightbox({});

import 'vanilla-calendar-pro/styles/index.css';

window.addEventListener('load', () => {
    // Calendar
    if(document.querySelector('.gift-calendar')) {
        document.querySelectorAll('.gift-calendar').forEach((element, index) => {
            let calendar = new Calendar(element, {
                inputMode: true,
                positionToInput: 'auto',
                locale: 'ar',
                dateMin: new Date(),
                onChangeToInput(self) {
                    if (!self.context.inputElement) return;
                    if (self.context.selectedDates[0]) {
                        self.context.inputElement.value = self.context.selectedDates[0];
                        self.hide();
                    } else {
                        self.context.inputElement.value = '';
                    }

                    if(Livewire.getByName('cart.add-to-cart-form')[0]){
                        Livewire.getByName('cart.add-to-cart-form')[0].$set('delivery_date', self.context.inputElement.value);
                    }
                    if(Livewire.getByName('cart.cart-item')[index]){
                        Livewire.getByName('cart.cart-item')[index].$set('delivery_date', self.context.inputElement.value);
                    }
                },
            });
            calendar.init();
        })
    }


    // Select
    const selectSorting = HSSelect.getInstance('#select');
    if(selectSorting) {
        const urlValue = new URLSearchParams(window.location.search).get('sort');
        if(urlValue){
            selectSorting.setValue(urlValue)
        }

        selectSorting.on('change', (val) => {
            window.location.href = `${window.location.origin}${window.location.pathname}?${new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), sort: val}).toString()}`;
        });
    }


    // Input Number
    if(document.querySelector('.input-number')) {
        document.querySelectorAll('.input-number').forEach((element, index) => {
            let inputNumber = HSInputNumber.getInstance(element);
            if(inputNumber){
                let debounce = (func, delay) => {
                    let timer;
                    return (...args) => {
                        clearTimeout(timer);
                        timer = setTimeout(() => func(...args), delay);
                    };
                };

                inputNumber.on('change', debounce(({ inputValue }) => {
                    if (Livewire.getByName('cart.add-to-cart-form')[0]) {
                        Livewire.getByName('cart.add-to-cart-form')[0].$set('quantity', inputValue);
                    }
                    if (Livewire.getByName('cart.cart-item')[index]) {
                        Livewire.getByName('cart.cart-item')[index].$set('quantity', inputValue);
                    }
                }, 300));
            }
        })
    }
})



window.addEventListener('popToast', (event) => {
    let icon;
    if(event.detail[0].type === 'success') {
        icon = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-6 fill-green-600">
          <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
        </svg>
        `
    } else if(event.detail[0].type === 'info') {
        icon = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-6 fill-yellow-600">
          <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
        </svg>
`
    } else {
        icon = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-6 fill-red-600">
          <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
        </svg>
        `
    }
    const toastMarkup = `
  <div class="flex p-4">
    <p class="text-sm text-gray-700 flex items-start gap-2">
        ${icon}
        ${event.detail[0].message}
    </p>
    <div class="ms-auto">
      <button onclick="this.closest('.toastify').querySelector('.toast-close').click()" type="button" class="cursor-pointer inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-hidden focus:opacity-100" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
      </button>
    </div>
  </div>
`;

    Toastify({
        text: toastMarkup,
        className: "hs-toastify-on:opacity-100 opacity-0 fixed -top-37.5 right-5 z-90 transition-all duration-300 w-80 bg-white text-sm text-gray-700 border border-gray-200 rounded-xl shadow-lg [&>.toast-close]:hidden dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400",
        duration: 3000,
        close: true,
        escapeMarkup: false,
        position: 'center',
    }).showToast();
});
