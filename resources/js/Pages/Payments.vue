<template>
    <div>
        <div class="payment-form">
            <h2 class="text-center mt-5">Dati Pagante</h2>
            <!-- Display a payment form -->
            <form id="payment-form" class="d-flex flex-column justify-content-center align-items-center mb-4" >
                <div style="width: 500px; " class="border border-2 rounded-4 p-4">
                    <div class="input-group mb-3 d-flex flex-column ">
                        <label for="first_name">Nome</label>
                        <input type="text" class="form-control w-100" v-model="customer.first_name"  >
                    </div>
                    <div class="input-group mb-3 d-flex flex-column ">
                        <label for="last_name">Cognome</label>
                        <input type="text" class="form-control w-100" v-model="customer.last_name"  >
                    </div>
                    <div class="input-group mb-3 d-flex flex-column ">
                        <label for="email">E-Mail</label>
                        <input type="email" class="form-control w-100" v-model="customer.email"  >
                    </div>
                    <div class="input-group mb-3 d-flex flex-column ">
                        <label for="n_phone">Phone</label>
                        <input type="text" class="form-control w-100" v-model="customer.n_phone"  >
                    </div>
                    <div class="input-group mb-3 d-flex flex-column ">
                        <label for="address">Via</label>
                        <input type="text" class="form-control w-100" v-model="customer.address"  >
                    </div>
                    <div class="input-group mb-3 d-flex flex-column ">
                        <label for="city">Città</label>
                        <input type="text" class="form-control w-100" v-model="customer.city"  >
                    </div>
                    <div class="input-group mb-3 d-flex flex-column ">
                        <label for="zip_code">Codice Postale</label>
                        <input type="text" class="form-control w-100"  id="zip_code" v-model="customer.zip_code"  >
                    </div>
                    <div class="d-flex flex-wrap justify-content-center">
                        <div id="payment-element"></div>
                    </div>
                    <div class="w-100">
                        <button class="btn btn-primary" ype="submit" @click="handleSubmit"   v-text="paymentProcessing ? 'Processing' : 'Pay Now'">

                        </button>
                    </div>
                </div>
            </form >
            <h2 class="text-center mb-4">Importo da pagare: {{formatCurrency(store.returnTotalPrice) }} &euro;</h2>
        </div>
        <div class="payment-result">
            <!-- Visualizza qui il risultato del pagamento -->
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted, computed } from 'vue';
import {generalStore} from '@/Stores/state';
import { loadStripe } from '@stripe/stripe-js';
export default {
    setup() {
        const token = ref(null);
        const stripe = ref(null);
        const elements = ref(null);
        const clientSecret = ref(null);
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

        //     const processPayment = async function(){

        //         paymentProcessing.value = true;

        //         const {paymentMethod, error} = await stripe.createPaymentMethod(
        //             'card', cardElement, {
        //                 billing_details: {
        //                     name: customer.first_name + ' ' + customer.last_name,
        //                     email: customer.email,
        //                     n_phone: customer.n_phone,
        //                     address: {
        //                         line1: customer.address,
        //                         city: customer.city,
        //                         state: customer.state,
        //                         postal_code: customer.zip_code
        //                     }
        //                 }
        //             }
        //         )

        //         if(error) {
        //             paymentProcessing.value = false;
        //             alert(error);
        //         } else {
        //             customer.payment_method_id = paymentMethod.id;
        //             customer.amount = store.returnTotalPrice;
        //             customer.cart = JSON.stringify(store.prenotationsWithRequiredFields)

        //             axios.post('/api/payment/initiate', customer)
        //             .then((response) => {
        //                 paymentProcessing.value = false;
        //                 console.log(response.data.message)
        //             })
        //             .catch((err) => {
        //                 paymentProcessing.value = false;
        //                 alert(err);
        //             })
        //         }
        //     }

            const handleSubmit = async (e) => {
                e.preventDefault();

                const { error } = await stripe.value.confirmPayment({
                    elements: elements.value,
                    confirmParams: {
                        // Return URL where the customer should be redirected after the PaymentIntent is confirmed.
                        return_url: 'http://192.168.188.32:8000/grazie',
                    },
                });

                if (error === undefined) {
                    axios.post("/api/payment/complete", {
                        token: token.value,
                    }).then((res) => {

                    });
                } else {
                    axios.post("/api/payment/failure", {
                        token: token.value,
                        code: error.code,
                        description: error.message,
                    })
                }
            }

        onMounted(async () => {
            customer.amount = store.returnTotalPrice;
            customer.cart = JSON.stringify(store.prenotationsWithRequiredFields)

            axios.post('/api/payment/initiate', customer ).then(response => {
                token.value = response.data.token // Use to identify the payment
                stripe.value = Stripe('pk_test_51NrdqoJSKktHNGOdRN4FmawpqhTaMNNp9KAlBgg4iYIB2haRgOeqGzNEAX7UU1oStRqjZ0Ysk30ZsqDRoT9UoNwi00suEnUYN7');
                clientSecret.value = response.data.client_secret;
                const options = {
                    clientSecret: response.data.client_secret,
                }

                elements.value = stripe.value.elements(options);
                const paymentElement = elements.value.create('payment');
                paymentElement.mount('#payment-element');
                console.log(response.data.client_secret)
            }).catch(error => {
                console.error(error)
            })
            // stripe = await loadStripe(import.meta.env.VITE_STRIPE_KEY);
            // stripe = await loadStripe('pk_test_51NrdqoJSKktHNGOdRN4FmawpqhTaMNNp9KAlBgg4iYIB2haRgOeqGzNEAX7UU1oStRqjZ0Ysk30ZsqDRoT9UoNwi00suEnUYN7');
            // const elements = stripe.elements({
            //     mode: 'payment',
            //     currency: 'eur',
            //     amount: 10000,
            // });

            // cardElement = elements.create('card', {
            //     classes: {
            //         base: 'rounded border border-2 w-100 form-control'
            //     }
            // })

            // cardElement.mount('#card-element')
        })

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





