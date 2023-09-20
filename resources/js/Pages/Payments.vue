<template>
    <div>
        <div class="payment-form">
            <h2 class="text-center mt-5">Dati Pagante</h2>
            <!-- Display a payment form -->
            <form id="payment-form" class="mb-4" @submit.prevent="handleSubmit(e)">
                <div id="link-authentication-element">
                    <!--Stripe.js injects the Link Authentication Element-->
                </div>
                <div id="payment-element">
                    <!--Stripe.js injects the Payment Element-->
                </div>
                <input type="hidden" name="amount" :value="store.returnTotalPrice">

                <button id="submit">
                    <div class="spinner hidden" id="spinner"></div>
                    <span id="button-text">Pay now</span>
                </button>
                <div id="payment-message" class="hidden"></div>
            </form>
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
export default {
    setup() {
        const store = generalStore();

        const formatCurrency = function(value) {
            // Formatta l'importo in valuta
                return `${(value / 100).toFixed(2)} Euro`;
            }
        // This is your test publishable API key.
        const stripe = Stripe("pk_test_51NrdqoJSKktHNGOdRN4FmawpqhTaMNNp9KAlBgg4iYIB2haRgOeqGzNEAX7UU1oStRqjZ0Ysk30ZsqDRoT9UoNwi00suEnUYN7");

        let elements;

        initialize();
        checkStatus();


        let emailAddress = '';

        async function initialize() {
            const { clientSecret } = await fetch('/api/generate-client-secret').then((r) => r.json());

            elements = stripe.elements({ clientSecret });

            const linkAuthenticationElement = elements.create("linkAuthentication");
            linkAuthenticationElement.mount("#link-authentication-element");

            const paymentElementOptions = {
                layout: "tabs",
            };

            const paymentElement = elements.create("payment", paymentElementOptions);
            paymentElement.mount("#payment-element");
        }

        async function handleSubmit() {
            // Imposti spinner On
            setLoading(true);

            // Crea un nuovo oggetto FormData
            const formData = new FormData();

            // Aggiungi i dati delle prenotazioni al FormData
            for (const prenotation of store.prenotationsWithRequiredFields) {
                // Crea un oggetto con i dati della prenotazione
                const prenotationData = {
                    n_posto: prenotation.n_posto,
                    nome: prenotation.nome,
                    cognome: prenotation.cognome,
                    email: prenotation.email,
                    n_telefono: prenotation.n_telefono,
                    price: prenotation.price,
                };

                // Converti l'oggetto in una stringa JSON e aggiungila come valore
                // con una chiave unica al FormData
                formData.append('prenotations[]', JSON.stringify(prenotationData));
            }
            const response = await axios.post('/api/payment/initiate', formData, {
                responseType: 'json'
            })
            console.log(response.data.session);

            const { error } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    // Make sure to change this to your payment completion page
                    return_url: response.data.session.success_url,
                    receipt_email: emailAddress,
                },
            });

            // This point will only be reached if there is an immediate error when
            // confirming the payment. Otherwise, your customer will be redirected to
            // your `return_url`. For some payment methods like iDEAL, your customer will
            // be redirected to an intermediate site first to authorize the payment, then
            // redirected to the `return_url`.
            if (error.type === "card_error" || error.type === "validation_error") {
                showMessage(error.message);
            } else {
                showMessage("An unexpected error occurred.");
            }

            setLoading(false);
        }

        // Fetches the payment intent status after payment submission
        async function checkStatus() {
            const clientSecret = new URLSearchParams(window.location.search).get(
                "payment_intent_client_secret"
            );

            if (!clientSecret) {
                return;
            }

            const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

            switch (paymentIntent.status) {
                case "succeeded":
                showMessage("Payment succeeded!");
                break;
                case "processing":
                showMessage("Your payment is processing.");
                break;
                case "requires_payment_method":
                showMessage("Your payment was not successful, please try again.");
                break;
                default:
                showMessage("Something went wrong.");
                break;
            }
        }
        // ------- UI helpers -------

        function showMessage(messageText) {
            const messageContainer = document.querySelector("#payment-message");

            messageContainer.classList.remove("hidden");
            messageContainer.textContent = messageText;

            setTimeout(function () {
                messageContainer.classList.add("hidden");
                messageContainer.textContent = "";
            }, 4000);
        }

        // Show a spinner on payment submission
        function setLoading(isLoading) {
            if (isLoading) {
                // Disable the button and show a spinner
                document.querySelector("#submit").disabled = true;
                document.querySelector("#spinner").classList.remove("hidden");
                document.querySelector("#button-text").classList.add("hidden");
            } else {
                document.querySelector("#submit").disabled = false;
                document.querySelector("#spinner").classList.add("hidden");
                document.querySelector("#button-text").classList.remove("hidden");
            }
        }
        return {
            handleSubmit,
            store,
            formatCurrency
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





