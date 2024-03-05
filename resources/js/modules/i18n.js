import { createI18n } from 'vue-i18n';

import it from '../locales/it.json'
import en from '../locales/en.json'
import fr from '../locales/fr.json'


const messages = {
    'it': it,
    'en': en,
    'fr': fr
};

const i18n = createI18n({
    locale: 'it', // set locale
    fallbackLocale: 'en', // set fallback locale
    messages, // set locale messages
    legacy: false,
});

export default i18n
