<template>
    <div class="d-flex flex-column pt-4 justify-content-start m-0 container-fluid normal-font">
        <a class="btn-show border border-2 position-absolute top-0 start-0 m-3 z-3 animate__animated animate__zoomIn" :href="route('dashboard.date.index')">
            <i class="fa-solid fa-chevron-left  fs-3" ></i>
        </a>
        <div class="mb-5">
            <h1 class="text-center mb-4 fw-bold text-capitalize animate__animated animate__zoomIn">{{new Date(newDate[0].data).toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}</h1>
            <form
            @submit.prevent="updateReservationDate(data)"
            enctype="multipart/form-data"
            class="container-fluid border boorder-4 rounded-5 py-3 shadow mb-5 animate__animated animate__zoomIn px-4"
            v-for="(data, i) in newDate" :key="i">
                <div class="row align-items-center justify-content-center w-100 m-0">
                    <!-- CREATE -->
                    <div class="col-12 col-md-5 d-flex flex-column align-items-start justify-content-start mb-4 h-100 animate__animated animate__fadeInBottomLeft">
                        <div class="mb-3 w-100">
                            <label class="mb-1 fs-4" for="titolo">Titolo:  </label>
                            <div class="d-flex align-items-center justify-content-center">
                                <input type="text" id="titolo" class="form-control" v-model.trim="data.titolo" >
                            </div>
                        </div>
                        <div class="mb-3 w-100">
                            <label class="mb-1 fs-4" for="showType">Tipo Show:  </label>
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <select id="mealType" class="form-control" v-model.trim="data.show_type_id" @change="getArtistsByShowType(data.show_type_id)">
                                    <option v-for="(show, x) in showTypes" :key="x" :value="show.id" :selected="show.id === data.show_type_id">{{ show.nome }}</option>
                                </select>
                            </div>
                            <div v-if="artists.length > 0" class="normal-font mb-4 px-2">
                                <div class="form-check animate__animated animate__fadeInUp animate__faster pb-2" v-for="(artist, index) in artists" :key="index">
                                    <input class="form-check-input" type="checkbox" :value="artist.id" :id="'artist_' + artist.id" @change="addArtistsInFormdata(artist, data)" :checked="data.artists.some(item => item.id === artist.id)">
                                    <label class="form-check-label text-capitalize" :for="'artist_' + artist.id">
                                        {{ artist.titolo }}
                                    </label>
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn-show border border-2" data-bs-toggle="modal" data-bs-target="#createArtist">
                                    + Artista
                                </button>
                            </div>
                        </div>
                        <div class="mb-3 w-100">
                            <label class="mb-1 fs-4" for="mealType">Ora Spettacolo:  </label>
                            <div class="d-flex align-items-center justify-content-center">
                                <select id="mealType" class="form-control" v-model="data.pranzo_cena" required>
                                    <option value="pranzo">Pranzo</option>
                                    <option value="cena">Cena</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 d-flex flex-column align-items-start justify-content-start mb-4 h-100 border-start border-2 animate__animated animate__fadeInBottomRight">
                        <label class="mb-1 fs-4" for="descrizione">Descrizione:  </label>
                        <textarea id="descrizione" class="form-control mb-2" v-model.trim="data.descrizione"></textarea>
                        <div  class="d-flex flex-wrap mb-3">
                            <div v-for="(image, index) in data.images" :key="index" class="w-50 position-relative date-image-container">
                                <img :src="image.path" alt="Anteprima immagine" class="w-100 h-100 date-image-preview" >
                                <button class="btn btn-danger delete-image fs-2"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                        <!-- Anteprime delle immagini -->
                        <h3 class="normal-font">Anteprima Immagini <span class="fs-6">( le immagini saranno aggiunte in coda se prima non elimini quella/e attuale/i)</span></h3>
                        <div v-if="data.imagePreviews.length > 0" class="d-flex  flex-wrap mb-3">
                            <div v-for="(image, index) in data.imagePreviews" :key="index" class="w-50 p-2 position-relative date-image-container">
                                <img :src="image" alt="Anteprima immagine" class="me-2 w-100 h-100 date-image" >
                                <button class="btn btn-danger delete-image fs-2" @click="removeImageFromPreview(data, image)"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>


                        <input type="file" name="img" class="form-control mb-3" @change="onFileChange($event, data)" multiple accept="image/*">

                        <!-- PREZZO -->
                        <label for="prezzo" class="mb-1 fs-4">
                            Prezzo
                        </label>
                        <input
                            type="text"
                            id="prezzo"
                            class="form-control mb-4"
                            v-model.number="data.prezzo"
                            step=0.01
                            @input="formatCurrency(data)"
                        >
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-evenly position-relative">
                        <!-- DELETE -->
                        <button type="button" class="btn-show bg-danger border-danger text-white normal-font py-3 text-uppercase rounded-5 px-4 fs-5" data-bs-toggle="modal" :data-bs-target="'#exampleModal_' + data.id">
                            Elimina
                        </button>
                        <!-- EDIT -->
                        <button class="btn-show border-warning  normal-font border-2 text-center bg-warning" type="submit" :disabled="data.artists.length === 0">Modifica</button>
                    </div>
                </div>
            </form>
        </div>
        <div v-if="newDate.length === 1 " class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <a :href="route('dashboard.date.create', {data: newDate[0].data})" class="btn-show border border-2 animated animate__zoomIn">Vuoi Aggiumngere un altro spettacolo ?</a>
                </div>
            </div>
        </div>
    </div>
    <!-- DELETE Modal -->
    <div  v-for="(data, x) in newDate" :key="x" class="modal fade" :id="'exampleModal_' + data.id" tabindex="-1" :aria-labelledby="'exampleModalLabel_' + data.id" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header border-0 d-flex justify-content-between align-items-center ">
                <div></div>
                <h1 class="modal-title fs-5 text-danger text-uppercase normal-font" :id="'exampleModalLabel_' + data.id">
                    <i class="fa-solid fa-exclamation"></i> Attenzione <i class="fa-solid fa-exclamation"></i>
                </h1>
                <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="fs-3">
                    Sei sicuro di voler eliminare lo spettacolo di <span class="fw-bold text-danger">{{data.titolo}}</span> <span class="text-uppercase">{{ data.pranzo_cena }}</span>?
                </p>
                <div class=" border-0 d-flex w-00 align-items-center justify-content-evenly">
                    <button type="button" class="btn btn-secondary normal-font" data-bs-dismiss="modal">Annulla</button>
                    <button type="button" class="btn btn-danger fw-bold normal-font" @click="deleteData(data.id)" data-bs-dismiss="modal">Elimina</button>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- + ARTISTI Modal -->
    <div class="modal fade" id="createArtist" tabindex="-1" aria-labelledby="createArtistLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ArtistiCreate/>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import axios from 'axios'
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { router } from '@inertiajs/vue3';
import {generalStore} from '@/Stores/state';
import ArtistiCreate from '../Artisti/Create.vue'
export default {
    name: 'Show',
    components: {
        ArtistiCreate
    },
    setup(){
        const page = usePage()
        const date = computed(() => page.props.data)
        const showTypes = computed(() => page.props.showTypes)
        const newDate = ref(date.value.map(item => ({ ...item, imagePreviews: [] })));
        const artists = ref([]);
        const alert = ref([]);
        const store = generalStore();
        const imagePreviews = ref([]);

        const deleteData = (id) => {
            try {
                router.delete('/api/delete-data/' + id)
            } catch (error) {
                console.error('Error creating reservation date:', error);
            }
        }

        function onFileChange(event, data) {
            const files = event.target.files;

            for (const key in files) {
                if (files.hasOwnProperty(key)) {
                    const originalFile = files[key];

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const dataURL = e.target.result;

                        const img = new Image();
                        img.src = dataURL;

                        img.onload = () => {
                            const maxWidth = 550; // Larghezza massima desiderata
                            const maxHeight = 350; // Altezza massima desiderata

                            let newWidth, newHeight;
                            if (img.width > img.height) {
                                newWidth = maxWidth;
                                newHeight = (img.height / img.width) * maxWidth;
                            } else {
                                newHeight = maxHeight;
                                newWidth = (img.width / img.height) * maxHeight;
                            }

                            // Crea un canvas per ridimensionare l'immagine
                            const canvas = document.createElement('canvas');
                            const ctx = canvas.getContext('2d');
                            canvas.width = newWidth;
                            canvas.height = newHeight;
                            ctx.drawImage(img, 0, 0, newWidth, newHeight);

                            // Converti il canvas in un nuovo oggetto Blob (File)
                            canvas.toBlob((blob) => {
                                const modifiedFile = new File([blob], originalFile.name, {
                                    type: originalFile.type,
                                    lastModified: originalFile.lastModified,
                                    size: blob.size,
                                });

                                // Ora puoi utilizzare sia data che l'evento
                                data.imagePreviews.push(URL.createObjectURL(modifiedFile));
                            }, originalFile.type, 0.7);
                        };
                    };
                    reader.readAsDataURL(originalFile);
                }
            }
            console.log(data);
        }


        function removeImageFromPreview(data, img) {
            const index = data.imagePreviews.indexOf(img);

            if (index !== -1) {
                // L'immagine è presente nell'array della data, rimuovila
                data.imagePreviews.splice(index, 1);
                console.log(`Immagine '${img}' rimossa dall'array.`);
            } else {
                console.log(`L'immagine '${img}' non è presente nell'array.`);
            }

        }


        function addArtistsInFormdata(artist, data) {
            if (!data.artists.some(item => item.id === artist.id)) {
                // L'ID dell'artista non è presente nell'array, quindi lo aggiungiamo
                data.artists.push(artist);
            } else {
                // L'ID dell'artista è già presente, quindi lo rimuoviamo
                const index = data.artists.findIndex(item => item.id === artist.id);
                if (index !== -1) {
                    data.artists.splice(index, 1);
                }
            }
            console.log(data.artists);
        }


        function getArtistsByShowType(showtypeId){
            artists.value = [];
            // array.artists = [];
            axios.post('/api/filtered-artist-title/' + showtypeId)
            .then((res) => {
                res.data.artistiFiltrati.forEach(artist => {
                    artists.value.push(artist);
                });
            })
            .catch((err) => {
                console.error(err);
            })
        };

        function formatCurrency(data) {
            let price = String(data.prezzo).replace(/[^\d]/g,'');
            let pre, dec;
            let delimiter = '.';

            let result = price;

            if (price.length > 3 && price.charAt(0) == '0') {
                price = price.substr(1);
            }

            if (price.length > 2) {
                pre = price.slice(0,-2);
                dec = price.substr((price.length-2), 2);
                result = pre + delimiter + dec;
            }

            data.prezzo = result;
        }

        async function updateReservationDate(data){
            const formData = new FormData();
            formData.append('id', data.id);
            formData.append('titolo', data.titolo);
            formData.append('descrizione', data.descrizione);
            formData.append('pranzo_cena', data.pranzo_cena);
            for (const key in  data.imagePreviews) {
                if ( data.imagePreviews.hasOwnProperty(key)) {
                    const image =  data.imagePreviews[key];
                    formData.append(`img[${key}]`, image);
                }
            }
            formData.append('artisti', data.artists);
            formData.append('data', data.data);
            formData.append('prezzo', data.prezzo);
            try {
                axios.post('/api/update-reservation-dates/', formData)
                .then((res) =>{
                    console.log(res.data);
                }).catch((err) => {
                    console.error(err);
                })
            } catch (error) {
                console.error(error);
            }

        }

        onMounted(() => {
            store.disableOverflowHidden();
            console.log(newDate.value)
        })
        onBeforeUnmount(() => {
            store.enableOverflowHidden();
        })
        return {
            date,
            newDate,
            showTypes,
            deleteData,
            addArtistsInFormdata,
            getArtistsByShowType,
            formatCurrency,
            onFileChange,
            imagePreviews,
            artists,
            removeImageFromPreview,
            alert,
            updateReservationDate
        }
    }
}
</script>

<style lang="scss" scoped>
.date-image-container{
    cursor: pointer;
    .delete-image{
        opacity: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
}

.date-image-container:hover{
    img{
        filter: blur(6px) brightness(60%);
        transition: filter .2s ease-out;
    }
    .delete-image{
        opacity: 1;
        transition: opacity .2s ease-out;
    }
}
</style>
