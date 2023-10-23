<template>
    <div>
        <div class="payment-form mb-5 ">
            <h2 class="text-center mt-5">Dati Pagante</h2>
            <!-- Display a payment form -->
            <form id="payment-form" class="d-flex flex-column justify-content-center align-items-center mb-4" >
                <div class="p-4">
                    <div class="input-group mb-3 d-flex flex-column ">
                        <label for="first_name">Nome*</label>
                        <input type="text" class="form-control w-100 text-capitalize rounded-5" v-model="customer.first_name"  >
                    </div>
                    <div class="input-group mb-3 d-flex flex-column ">
                        <label for="last_name">Cognome*</label>
                        <input type="text" class="form-control w-100 text-capitalize rounded-5" v-model="customer.last_name"  >
                    </div>
                    <div class="input-group mb-3 d-flex flex-column ">
                        <label for="email">E-Mail*</label>
                        <input type="email" class="form-control w-100 rounded-5" v-model="customer.email"  >
                    </div>
                    <div class="input-group mb-3 d-flex flex-column ">
                        <label for="n_phone">Telefono*</label>
                        <input type="text" class="form-control w-100 text-capitalize rounded-5" v-model="customer.n_phone"  >
                    </div>
                    <div class="input-group mb-3 d-flex flex-column ">
                        <label for="address">Via*</label>
                        <input type="text" class="form-control w-100 text-capitalize rounded-5" v-model="customer.address"  >
                    </div>
                    <div class="input-group mb-3 d-flex flex-column ">
                        <label for="city">Città*</label>
                        <input type="text" class="form-control w-100 text-capitalize rounded-5" v-model="customer.city"  >
                    </div>
                    <div class="input-group mb-3 d-flex flex-column ">
                        <label for="zip_code">Codice Postale*</label>
                        <input type="text" class="form-control w-100 text-capitalize rounded-5"  id="zip_code" v-model="customer.zip_code"  >
                    </div>
                    <div class="d-flex flex-wrap justify-content-center">
                        <div id="payment-element"></div>
                    </div>
                    <div class="w-100">
                        <button class="btn btn-primary" type="submit" @click="handleSubmit"   v-text="paymentProcessing ? 'Processing' : 'Pay Now'">
                        </button>
                    </div>
                </div>
            </form >
            <h2 class="text-center pb-5">Importo da pagare: {{ store.returnTotalPrice }} &euro;</h2>
        </div>
        <div class="payment-result">
            <!-- Visualizza qui il risultato del pagamento -->
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted, computed, onBeforeUnmount } from 'vue';
import {generalStore} from '@/Stores/state';
import { loadStripe } from '@stripe/stripe-js';
import { router } from '@inertiajs/vue3';
export default {
    setup() {
        const token = ref(null);
        const stripe = ref(null);
        const elements = ref(null);
        const clientSecret = ref(null);
        const redirect = ref('');
        const store = generalStore();
        const customer = ref({
            first_name: '',
            last_name: '',
            email: '',
            address: '',
            city: '',
            zip_code:'',
            n_phone: ''
        })

        const paymentProcessing = ref(false);

        const formatCurrency = function(value) {
            // Formatta l'importo in valuta
                return `${(value / 100).toFixed(2)} Euro`;
            }

            const handleSubmit = async (e) => {
                e.preventDefault();

                const { error } = await stripe.value.confirmPayment({
                    elements: elements.value,
                    redirect: 'if_required',
                    confirmParams: {
                        payment_method_data: {
                            billing_details: {
                                name: customer.value.first_name + ' ' + customer.value.last_name,
                                email: customer.value.email,
                                address: {
                                    city: customer.value.city,
                                    line1: customer.value.address,
                                    postal_code: customer.value.postal_code
                                },
                                phone: customer.value.n_phone
                            }
                        },
                        return_url: `${window.location.origin}/grazie`,
                    },
                });
                console.log(error);
                if (error === undefined) {
                    localStorage.clear;
                    router.post("/api/payment/complete", {
                        token: token.value,
                        customer: customer.value,
                        booked: store.prenotationsWithRequiredFields,
                        data:store.data
                    })
                } else {
                    // router.post("/api/payment/failure", {
                    //     token: token.value,
                    //     code: error.code,
                    //     description: error.message,
                    // })
                    console.log(error);
                }
            }

            // Rimozione overflow
            const removeOverflow = () => {
                document.documentElement.style.overflow = 'visible';
                document.body.style.overflow = 'visible';
            };


        onMounted(async () => {
            store.disableOverflowHidden();
            customer.amount = store.returnTotalPrice;
            customer.cart = JSON.stringify(store.prenotationsWithRequiredFields)
            customer.data = store.data;
            axios.post('/api/payment/initiate', customer ).then(response => {
                token.value = response.data.token // Use to identify the payment
                stripe.value = Stripe(import.meta.env.VITE_STRIPE_KEY);
                clientSecret.value = response.data.client_secret;
                const options = {
                    clientSecret: clientSecret.value,
                }

                elements.value = stripe.value.elements(options);
                const paymentElement = elements.value.create('payment');
                paymentElement.mount('#payment-element');
                // console.log(response.data.client_secret)
                console.log(customer.value)
            }).catch(error => {
                console.error(error)
            })

            console.log(store.prenotationsWithRequiredFields)
        })
        onBeforeUnmount(() => {
            // Ripristina l'overflow al valore predefinito prima che il componente sia smontato
            store.enableOverflowHidden();
        });
        return {
            customer,
            store,
            formatCurrency,
            paymentProcessing,
            handleSubmit
        }

    },
};
</script>

<style scoped>

html, body {
    overflow: auto !important;
}

/* Stili CSS per il tuo componente Vue */
form {
    width: 30vw;
    min-width: 500px;
    align-self: center;
    box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
        0px 2px 5px 0px rgba(50, 50, 93, 0.1), 0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
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
    .spinner,
    .spinner:before,
    .spinner:after {
    border-radius: 50%;
    }
    .spinner {
    color: #ffffff;
    font-size: 22px;
    text-indent: -99999px;
    margin: 0px auto;
    position: relative;
    width: 20px;
    height: 20px;
    box-shadow: inset 0 0 0 2px;
    -webkit-transform: translateZ(0);
    -ms-transform: translateZ(0);
    transform: translateZ(0);
    }
    .spinner:before,
    .spinner:after {
    position: absolute;
    content: "";
    }
    .spinner:before {
    width: 10.4px;
    height: 20.4px;
    background: #5469d4;
    border-radius: 20.4px 0 0 20.4px;
    top: -0.2px;
    left: -0.2px;
    -webkit-transform-origin: 10.4px 10.2px;
    transform-origin: 10.4px 10.2px;
    -webkit-animation: loading 2s infinite ease 1.5s;
    animation: loading 2s infinite ease 1.5s;
    }
    .spinner:after {
    width: 10.4px;
    height: 10.2px;
    background: #5469d4;
    border-radius: 0 10.2px 10.2px 0;
    top: -0.1px;
    left: 10.2px;
    -webkit-transform-origin: 0px 10.2px;
    transform-origin: 0px 10.2px;
    -webkit-animation: loading 2s infinite ease;
    animation: loading 2s infinite ease;
    }

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





