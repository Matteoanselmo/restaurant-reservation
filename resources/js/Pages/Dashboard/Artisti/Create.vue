<template>
    <div class="container-fluid">
        <div class="row normal-font">
            <div class="col-12 mb-4 text-center ">
                <h1 class="normal-font">Aggiungi Artista</h1>
            </div>
            <div class="col-12">
                <Message
                    v-if="message.message"
                    :message="message"
                />
                <form @submit.prevent="createArtist">
                    <div class="mb-3">
                        <label for="title" class="fs-3 text-capitalize">titolo</label>
                        <input type="text" name="title" id="title" v-model="title" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="fs-3 text-capitalize">descrizione</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="form-control" v-model="description"></textarea>
                    </div>
                    <label class="mb-1 fs-4" for="show_type">Tipo Show: *</label>
                    <select name="show_type" class="form-control mb-3" v-model="showType">
                        <option value="1">Mare</option>
                        <option value="2">Special</option>
                        <option value="3">Terra</option>
                    </select>
                    <div class="files mb-3">
                        <label class="fs-3">Carica una immagine</label>
                        <input type="file" name="image" class="form-control form-control-lg" @change="onFileChange" accept="image/*">
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn-show border border-2 text-center">Crea</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { router } from '@inertiajs/vue3';
import {generalStore} from '@/Stores/state';
import Message from '@/Components/Dashboard-Cmponents/Message.vue';
export default {
    name: 'ArtistiCreate',
    components: {
        Message
    },
    setup(){
        const store = generalStore();
        const title = ref('');
        const description = ref('');
        const showType = ref(null);
        const message = ref({
            message : '',
            class: ''
        });
        const img = ref('');

        function onFileChange(event){
            const file = event.target.files[0];
            img.value = file;
        }
        async function createArtist() {
            const formData = new FormData();
            formData.append('title', title.value.toLowerCase());
            formData.append('description', description.value.toLowerCase());
            formData.append('show_type_id', showType.value.toLowerCase());
            formData.append('image', img.value);

            try {
                axios.post('/api/create-artist', formData)
                .then((res) => {
                    console.log(res.data);
                    message.value.message = res.data.message;
                    message.value.class = res.data.class;
                }).catch((err) => {
                    console.error(err)
                })
            } catch (error) {
                console.error(error)
            }
        }
        onMounted(()=> {
            store.disableOverflowHidden();
        })

        onBeforeUnmount(() => {
            store.enableOverflowHidden();
        });

        return{
            title,
            description,
            showType,
            img,
            createArtist,
            onFileChange,
            message
        }
    }
}
</script>

<style lang="scss" scoped>
    .files input {
        border: 2px dashed #92b0b3;
        border-radius: 6px;
        padding: 120px 0px 85px 35%;
        text-align: center !important;
        margin: 0;
        width: 100% !important;
    }


</style>
