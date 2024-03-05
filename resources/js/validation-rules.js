// validationRules.js
export default function getValidationRules(t) {
    return {
        name: (value) => {
            if (!value || !value.trim()) {
                return t('rules.name');
            }
            return true;
        },
        lastName: (value) => {
            if (!value || !value.trim()) {
                return t('rules.last_name');
            }
            return true;
        },
        email: (value) => {
            if (!value || !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(value)) {
                return t('rules.email');
            }
            return true;
        },
        telefono: (value) => {
            // Rimuove il prefisso internazionale se presente
            let phone = value && value.startsWith('+') ? value.substring(3) : value;
            // Rimuove gli spazi bianchi all'inizio e alla fine
            // phone = phone.trim();
            // Controlla se la lunghezza del numero di telefono è compresa tra 7 e 10
            if (phone.length >= 7 && phone.length <= 10) {
                return true;
            }
            // Restituisce un messaggio di errore se il numero non è valido
            return t('rules.telefono');
        },
        address: (value) => {
            if (!value || !value.trim()) {
                return t('rules.address');
            }
            return true;
        },
        city: (value) => {
            if (!value || !value.trim()) {
                return t('rules.city');
            }
            return true;
        },
        zip_code: (value) => {
            // Validazione esempio per codici postali italiani: 5 cifre
            if (!value || !/^\d{5}$/.test(value)) {
                return t('rules.zip_code');
            }
            return true;
        },
        text: (value) => {
            if (value && value.length > 500) {
                return t('rules.max_length');
            }
            return true;
        },
        // Aggiungi qui la nuova regola per "allergens"
        allergens: (value) => {
            if (value && value.length > 500) {
                return t('rules.max_length');
            }
            return true;
        },

    };
}
