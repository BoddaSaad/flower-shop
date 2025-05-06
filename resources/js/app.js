import 'preline'
import 'lodash'
import { Calendar } from "vanilla-calendar-pro";
import GLightbox from 'glightbox';

const lightbox = GLightbox({});

import 'vanilla-calendar-pro/styles/index.css';

const calendar = new Calendar('#gift-calendar', {
    inputMode: true,
    positionToInput: 'auto',
    locale: 'ar',
    dateMin: new Date(),
    onChangeToInput(self) {
        if (!self.context.inputElement) return;
        if (self.context.selectedDates[0]) {
            self.context.inputElement.value = self.context.selectedDates[0];
            // if you want to hide the calendar after picking a date
            self.hide();
        } else {
            self.context.inputElement.value = '';
        }
    },
});
calendar.init();

