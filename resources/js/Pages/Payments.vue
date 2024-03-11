<template>
    <div>
        <button-info></button-info>
        <application-logo></application-logo>
        <div class="payment-form mb-5">
            <Load :loading="paymentProcessing" />
            <h2 class="text-center mt-5">Dati Pagante</h2>
            <!-- Display a payment form -->
            <h6 class="text-center mb-5 px-5 d-flex">
                <i class="fs-3 fa-regular fa-bell"></i>
                <p class="px-5">
                    Si ricorda che in caso di disdetta con mancato preavviso di
                    giorni non inferiori a 6, sarà restituito un importo pari al
                    60% della prenotazione.
                </p>
                <i class="fs-3 fa-regular fa-bell"></i>
            </h6>
            <Form
                @submit="handleSubmit"
                id="payment-form"
                class="d-flex flex-column justify-content-center align-items-center mb-4 shadow"
            >
                <div class="p-4">
                    <div class="input-group mb-3 d-flex flex-column">
                        <p class="mb-0 me-3 fs-5">Nome*</p>
                        <Field
                            name="nome"
                            v-model.trim="customer.first_name"
                            :rules="validationRules.name"
                            class="form-control w-100 text-capitalize rounded-5"
                        />
                        <ErrorMessage
                            name="nome"
                            class="text-danger text-center"
                        />
                    </div>
                    <div class="input-group mb-3 d-flex flex-column">
                        <p class="mb-0 me-3 fs-5">Cognome*</p>
                        <Field
                            name="cognome"
                            v-model.trim="customer.last_name"
                            :rules="validationRules.lastName"
                            class="form-control w-100 text-capitalize rounded-5"
                        />
                        <ErrorMessage
                            name="cognome"
                            class="text-danger text-center"
                        />
                    </div>
                    <div class="input-group mb-3 d-flex flex-column">
                        <p class="mb-0 me-3 fs-5">Email*</p>
                        <Field
                            name="email"
                            v-model="customer.email"
                            :rules="validationRules.email"
                            class="form-control w-100 text-capitalize rounded-5"
                        />
                        <ErrorMessage
                            name="email"
                            class="text-danger text-center"
                        />
                    </div>
                    <div class="input-group mb-3 d-flex flex-column">
                        <p class="mb-0 me-3 fs-5">Telefono*</p>
                        <Field
                            type="text"
                            name="n_telefono"
                            v-model="customer.n_telefono"
                            :rules="validationRules.telefono"
                            class="form-control w-100 text-capitalize rounded-5"
                        />
                        <ErrorMessage
                            name="n_telefono"
                            class="text-danger text-center"
                        />
                    </div>
                    <div class="input-group mb-3 d-flex flex-column">
                        <p class="mb-0 me-3 fs-5">Via*</p>
                        <Field
                            name="address"
                            type="text"
                            class="form-control w-100 text-capitalize rounded-5"
                            :rules="validationRules.address"
                            v-model.trim="customer.address"
                            required
                        />
                        <ErrorMessage
                            name="address"
                            class="text-danger text-center"
                        />
                    </div>
                    <div class="input-group mb-3 d-flex flex-column">
                        <p class="mb-0 me-3 fs-5">Città*</p>
                        <Field
                            name="city"
                            type="text"
                            class="form-control w-100 text-capitalize rounded-5"
                            :rules="validationRules.city"
                            v-model.trim="customer.city"
                            required
                        />
                        <ErrorMessage
                            name="city"
                            class="text-danger text-center"
                        />
                    </div>
                    <div class="input-group mb-3 d-flex flex-column">
                        <p class="mb-0 me-3 fs-5">Codice Postale*</p>
                        <Field
                            name="zip_code"
                            type="text"
                            class="form-control w-100 text-capitalize rounded-5"
                            :rules="validationRules.zip_code"
                            id="zip_code"
                            v-model.trim="customer.zip_code"
                            required
                        />
                        <ErrorMessage
                            name="zip_code"
                            class="text-danger text-center"
                        />
                    </div>
                    <div class="d-flex flex-wrap justify-content-center">
                        <div id="payment-element"></div>
                    </div>
                    <div class="w-100">
                        <button
                            class="btn btn-primary"
                            type="submit"
                            v-text="
                                paymentProcessing ? 'Convalida' : 'Paga Subito'
                            "
                        ></button>
                    </div>
                </div>
            </Form>
            <h2 class="text-center pb-5">
                Importo da pagare: {{ store.returnTotalPrice }} &euro;
            </h2>
        </div>
        <div class="payment-result">
            <!-- Visualizza qui il risultato del pagamento -->
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref, onMounted, onBeforeUnmount } from "vue";
import { generalStore } from "@/Stores/state";
import { loadStripe } from "@stripe/stripe-js";
import { router } from "@inertiajs/vue3";
import { Form, Field, ErrorMessage } from "vee-validate";
import getValidationRules from "@/validation-rules";
import { defineRule } from "vee-validate";
import { useI18n } from "vue-i18n";

const { t } = useI18n();
const token = ref(null);
const stripe = ref(null);
const elements = ref(null);
const clientSecret = ref(null);
const store = generalStore();
const customer = ref({
    first_name: "",
    last_name: "",
    email: "",
    address: "",
    city: "",
    zip_code: "",
    n_phone: "",
});

const paymentProcessing = ref(false);

const formatCurrency = function (value) {
    // Formatta l'importo in valuta
    return `${(value / 100).toFixed(2)} Euro`;
};

const handleSubmit = async (e) => {
    // e.preventDefault();
    paymentProcessing.value = true;
    const { error } = await stripe.value.confirmPayment({
        elements: elements.value,
        redirect: "if_required",
        confirmParams: {
            payment_method_data: {
                billing_details: {
                    name:
                        customer.value.first_name +
                        " " +
                        customer.value.last_name,
                    email: customer.value.email,
                    address: {
                        city: customer.value.city,
                        line1: customer.value.address,
                        postal_code: customer.value.postal_code,
                    },
                    phone: customer.value.n_phone,
                },
            },
            return_url: `${window.location.origin}/grazie`,
        },
    });
    // console.log(error);
    if (error === undefined) {
        localStorage.clear;
        paymentProcessing.value = false;
        router.post("/api/payment/complete", {
            token: token.value,
            customer: customer.value,
            booked: store.prenotationsWithRequiredFields,
            data: store.data,
        });
    }
};

// Rimozione overflow
const removeOverflow = () => {
    document.documentElement.style.overflow = "visible";
    document.body.style.overflow = "visible";
};

onMounted(async () => {
    store.disableOverflowHidden();
    customer.amount = store.returnTotalPrice;
    customer.cart = JSON.stringify(store.prenotationsWithRequiredFields);
    customer.data = store.data;
    axios
        .post("/api/payment/initiate", customer)
        .then((response) => {
            token.value = response.data.token; // Use to identify the payment
            stripe.value = Stripe(import.meta.env.VITE_STRIPE_KEY);
            clientSecret.value = response.data.client_secret;
            const options = {
                clientSecret: clientSecret.value,
            };

            elements.value = stripe.value.elements(options);
            const paymentElement = elements.value.create("payment");
            paymentElement.mount("#payment-element");
        })
        .catch((error) => {
            console.error(error);
        });
});

const validationRules = getValidationRules(t);

// Definisci le regole di vee-validate utilizzando le regole di validazione
Object.keys(validationRules).forEach((ruleName) => {
    defineRule(ruleName, validationRules[ruleName]);
});
removeOverflow();
</script>

<style scoped>
html,
body {
    overflow: auto !important;
}

/* Stili CSS per il tuo componente Vue */
form {
    width: 30vw;
    min-width: 500px;
    align-self: center;
    box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
        0px 2px 5px 0px rgba(50, 50, 93, 0.1),
        0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
    border-radius: 7px;
    padding: 40px;
    margin: 0 auto;
}

.hidden {
    display: none;
}

#payment-message {
    color: rgb(105, 115, 134);
    font-size: 16px;
    line-height: 20px;
    padding-top: 12px;
    text-align: center;
}

#payment-element {
    margin-bottom: 24px;
}

/* Buttons and links */
button {
    background: #5469d4;
    font-family: Arial, sans-serif;
    color: #ffffff;
    border-radius: 4px;
    border: 0;
    padding: 12px 16px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: block;
    transition: all 0.2s ease;
    box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
    width: 100%;
}
button:hover {
    filter: contrast(115%);
}
button:disabled {
    opacity: 0.5;
    cursor: default;
}

/* spinner/processing state, errors */

@-webkit-keyframes loading {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}
@keyframes loading {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}

@media only screen and (max-width: 600px) {
    form {
        width: 80vw;
        min-width: initial;
    }
}
</style>
