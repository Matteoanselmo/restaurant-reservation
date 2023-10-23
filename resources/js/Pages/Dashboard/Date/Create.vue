<template>
    <div class="container-fluid d-flex flex-column px-3 justify-content-start mt-3">
        <div class="row">
            <div class="col-4">
                <a class="btn-show border border-2" :href="route('dashboard.date.index')">
                    <i class="fa-solid fa-chevron-left  fs-3" ></i>
                </a>
            </div>
            <div class="col-4">
                <h1 class="text-start mb-4 fw-bold animate__animated animate__fadeInDown text-capitalize">Spettacolo {{new Date(data).toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}</h1>
            </div>
            <div class="col-4"></div>
        </div>
        <form @submit.prevent="createReservationDate" enctype="multipart/form-data">
            <div class="row gy-4 align-items-center justify-content-center">
                <div class="col-12 col-md-5 d-flex flex-column align-items-start justify-content-start mb-4 h-100 animate__animated animate__fadeInBottomLeft">
                    <div class="mb-3 w-100">
                        <label class="mb-1 fs-4" for="titolo">Titolo: *</label>
                        <div class="d-flex align-items-center justify-content-center">
                            <input type="text" id="titolo" class="form-control me-3" v-model.trim="formData.titolo" required>
                        </div>
                    </div>
                    <div class="mb-3 w-100">
                        <label class="mb-1 fs-4" for="showType">Show Type: *</label>
                        <div class="d-flex align-items-center justify-content-center">
                            <select id="showType" class="form-control me-3" v-model="formData.show_type_id" required>
                                <option class="text-uppercase" v-for="(showType, x) in showTypes" :key="x" :value="showType.id">{{ showType.nome }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 w-100">
                        <label class="mb-1 fs-4" for="mealType">Ora Spettacolo: *</label>
                        <div class="d-flex align-items-center justify-content-center">
                            <select id="mealType" class="form-control me-3" v-model="formData.pranzo_cena" required>
                                <option value="pranzo">Pranzo</option>
                                <option value="cena">Cena</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-5 d-flex flex-column align-items-start justify-content-start mb-4 h-100 border-start border-2 animate__animated animate__fadeInBottomRight">
                    <label class="mb-1 fs-4" for="descrizione">Descrizione:</label>
                    <textarea id="descrizione" class="form-control" v-model.trim="formData.descrizione" rows="10" required></textarea>
                    <label for="prezzo" class="mb-1 fs-4">
                    Prezzo
                    </label>
                    <input
                        type="text"
                        id="prezzo"
                        class="form-control mb-4"
                        v-model.number="formData.prezzo"
                        step=0.01
                        @input="formatCurrency"
                    >
                    <input type="file" name="img" class="form-control mb-3" @change="onFileChange" multiple accept="image/*">
                    <!-- Anteprime delle immagini -->
                    <div v-if="imagePreviews.length > 0" class="d-flex flex-wrap">
                        <div v-for="(image, index) in imagePreviews" :key="index">
                            <img :src="image" alt="Anteprima immagine" class="me-2 date-image-preview" >
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex align-items-center justify-content-center animate__animated animate__fadeInUp">
                    <button class="btn-show border border-2 text-center" type="submit">Crea Spettacolo</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { router } from '@inertiajs/vue3';
import * as bootstrap from 'bootstrap';
import {generalStore} from '@/Stores/state';
export default {
    name: 'DashboardCreateDate',
    setup(){
        const store = generalStore();
        const page = usePage()
        const data = page.props.data;
        const formData = ref(
            {
                titolo: '',
                descrizione: '',
                posti_disponibili: 1,
                show_type_id: '',
                pranzo_cena: 'pranzo',
                data: data,
                img: [],
                prezzo : 0

            }
        );
        const imagePreviews = ref([]);
        // Aggiungo i file all array, creao un anteprima e ridimensiono i file per l'upload (meno byte piu velocità )
        function onFileChange(event) {
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
                    const maxWidth = 200; // Larghezza massima desiderata
                    const maxHeight = 200; // Altezza massima desiderata

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

                        formData.value.img.push(modifiedFile);
                        imagePreviews.value.push(URL.createObjectURL(modifiedFile));
                    }, originalFile.type);
                    };
                };
                reader.readAsDataURL(originalFile);
                }
            }
            // formData.value.img.forEach(element => {
            //     console.log(element)
            // });
            console.log(typeof formData.value.img)
        }

        const createReservationDate = async () => {
            try {
                // router.post('/api/reservation-dates', formData);
                const newformdata = new FormData();
                newformdata.append('data', formData.value.data);
                newformdata.append('descrizione', formData.value.descrizione);
                // for (const file of formData.value.img) {
                //     newformdata.append('img', file);
                // }
                // Iterazione come se fosse un oggetto
                for (const key in formData.value.img) {
                if (formData.value.img.hasOwnProperty(key)) {
                    // key è l'indice dell'array
                    const image = formData.value.img[key];
                    newformdata.append(`img[${key}]`, image);
                }
}
                newformdata.append('pranzo_cena', formData.value.pranzo_cena);
                newformdata.append('prezzo', formData.value.prezzo);
                newformdata.append('show_type_id', formData.value.show_type_id);
                newformdata.append('titolo', formData.value.titolo);

                router.post('/api/reservation-dates', newformdata, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
            } catch (error) {
                console.error('Error creating reservation date:', error);
            }
        };

        const showTypes = ref([]);

        const fetchShowTypes = async () => {
            try {
                const response = await axios.get('/api/show-types');
                showTypes.value = response.data;
            } catch (error) {
                console.error('Error fetching show types:', error);
            }
        };

        function formatCurrency() {
            let price = String(formData.value.prezzo).replace(/[^\d]/g,'');
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

            formData.value.prezzo = result;
        }

        function onPriceBlur($event) {
            if ($event.target.value.includes(".")) {
                let price = parseFloat($event.target.value);
                formData.value.prezzo = price.toFixed(2);
            }
        }
        onMounted(() => {
            store.disableOverflowHidden();
            fetchShowTypes();
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        onBeforeUnmount(() => {
            store.enableOverflowHidden();
        });

        return {
            data,
            formData,
            createReservationDate,
            showTypes,
            onPriceBlur,
            formatCurrency,
            onFileChange,
            imagePreviews
        }
    },
};
</script>

<style scoped>
    .date-image-preview{
        max-height: 150px;
        max-width: 150px;
        object-fit: contain;
        object-position: center;
        cursor: pointer;
    }
    .date-image-preview:hover{
        border-radius: 10px;
        transform: scale(1.2);
        transition: all .3s;
    }
</style>
