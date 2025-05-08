import 'preline'
import 'lodash'
import { Calendar } from "vanilla-calendar-pro";
import GLightbox from 'glightbox';

const lightbox = GLightbox({});

import 'vanilla-calendar-pro/styles/index.css';

if(document.querySelector('#gift-calendar')) {
    const calendar = new Calendar('#gift-calendar', {
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
        },
    });
    calendar.init();
}

window.addEventListener('load', () => {
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
})

