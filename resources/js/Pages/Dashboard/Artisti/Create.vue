<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-4">
                <h1>Aggiungi un nuovo Artista</h1>
            </div>
            <div class="col-12">
                <form @submit.prevent="createArtist">
                    <label for="title" class="fs-3 text-capitalize">titolo</label>
                    <input type="text" name="title" id="title" v-model="title" class="form-control">
                    <label for="description" class="fs-3 text-capitalize">descrizione</label>
                    <textarea name="description" id="description" cols="30" rows="10" class="form-control" v-model="description"></textarea>
                    <select name="show_type" class="form-control" v-model="showType">
                        <option value="1">Mare</option>
                        <option value="2">Special</option>
                        <option value="3">Terra</option>
                    </select>
                    <button type="submit" class="btn-show border border-2">Crea</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
export default {
    name: 'ArtistiCreate',
    setup(){
        const title = ref('')
        const description = ref('')
        const showType = ref(null)
        function createArtist (){
            router.post('/api/create-artist', {
                title: title.value.toLowerCase,
                description: description.value.toLowerCase,
                show_type_id: showType.value.toLowerCase
            })
            .then((res) => {
                console.log(res.data)
            })
            .catch((err) => {
                console.error(err)
            })
        }

        return{
            title,
            description,
            showType,
            createArtist
        }
    }
}
</script>

<style>

</style>
