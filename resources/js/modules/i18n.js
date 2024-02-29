import { createI18n } from 'vue-i18n';

import it from '../locales/it.json'
import en from '../locales/en.json'
// import hr from '../locales/hr.json'


const messages = {
    'it': it,
    'en': en,
    // 'hr': hr
};

const i18n = createI18n({
    locale: 'it', // set locale
    fallbackLocale: 'en', // set fallback locale
    messages, // set locale messages
    legacy: false,
});

export default i18n
