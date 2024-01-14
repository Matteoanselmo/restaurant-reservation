<template>
    <div class="container-fluid">
        <div class="row justify-content-center pt-5">
            <div v-if="resMessage != ''" class="col-8 alert alert-success alert-dismissible fade show" role="alert">
                <p class="mb-0 normal-font">{{ resMessage }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" @click="resMessage = ''"></button>
            </div>
            <div class="col-12 text-center mb-5 normal-font">
                <h1>
                    Invia una nuova Newsletter
                </h1>
                <h5>
                    Ogni newsletter verrà inviata solamente ai clienti che hanno deciso di essere registrati!
                </h5>
            </div>
            <div class="col-8 ">
                <QuillEditor
                    theme="snow"
                    class="w-100"
                    placeholder="Nuovo spettacolo il..."
                    v-model:content="message"
                    contentType="html"
                />
                <div class="w-100 d-flex justify-content-center mt-4">
                    <button class="btn-show border border-2" @click="sendNewsletter">Invia Newsletter</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
export default {
    name:'Newsletter',
    components: {
        QuillEditor
    },
    setup(){
        const resMessage = ref('');
        const message = ref('');
        const sendNewsletter = (() => {
            axios.post('/api/send-newsletter', {message: message})
            .then((res) => {
                resMessage.value = res.data.message;
            })
            .catch((e) => {
                console.error(e)
            })
        })

        return{
            message,
            sendNewsletter,
            resMessage
        }
    }
}
</script>

<style>

</style>
