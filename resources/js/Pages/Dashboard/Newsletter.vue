<template>
    <div class="container-fluid">
        <div class="row justify-content-center pt-5">
            <div class="col-12 text-center mb-5">
                <h1>
                    Invia una nuova Newsletter
                </h1>
                <h5>
                    Ogni newsletter verrà inviata solamente ai clienti che hanno deciso di essere registrati!
                </h5>
            </div>
            <div class="col-8 d-flex flex-column align-items-center">
                <textarea v-model="message" rows="5" class="form-control mb-5" placeholder="Nuovo spettacolo il..."></textarea>
                <button class="btn-show" @click="sendNewsletter">Invia Newsletter</button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue'
export default {
    name:'Newsletter',
    setup(){
        const message = ref('');
        const sendNewsletter = (() => {
            axios.post('/api/send-newsletter', {message: message})
            .then((res) => {
                console.log(res.data.message)
            })
            .catch((e) => {
                console.error(e)
            })
        })

        return{
            message,
            sendNewsletter
        }
    }
}
</script>

<style>

</style>
