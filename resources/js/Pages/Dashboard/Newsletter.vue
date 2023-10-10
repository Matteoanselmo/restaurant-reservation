<template>
    <div class="container-fluid">
        <div class="row justify-content-center pt-5">
            <div class="col-8 d-flex flex-column align-items-center">
                <textarea v-model="message" rows="5" class="form-control mb-5" placeholder="Scrivi una nuova newsLetter"></textarea>
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
