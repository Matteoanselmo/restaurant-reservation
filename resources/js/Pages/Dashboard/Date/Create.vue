<template>
    <div
        class="container-fluid d-flex flex-column px-3 justify-content-start mt-3"
    >
        <div class="row">
            <div class="col-4">
                <a
                    class="btn-show border border-2"
                    :href="route('dashboard.date.index')"
                >
                    <i class="fa-solid fa-chevron-left fs-3"></i>
                </a>
            </div>
            <div class="col-6">
                <h2
                    class="text-start mb-4 fw-bold animate__animated animate__fadeInDown text-capitalize normal-font"
                >
                    Spettacolo
                    {{
                        new Date(data).toLocaleDateString("it-IT", {
                            weekday: "long",
                            year: "numeric",
                            month: "long",
                            day: "numeric",
                        })
                    }}
                </h2>
            </div>
            <div class="col-4"></div>
        </div>
        <form
            @submit.prevent="createReservationDate"
            enctype="multipart/form-data"
            class="normal-font"
        >
            <div class="row gy-4 align-items-center justify-content-center">
                <div
                    class="col-12 col-md-5 d-flex flex-column align-items-start justify-content-start mb-4 h-100 animate__animated animate__fadeInBottomLeft"
                >
                    <div class="mb-3 w-100">
                        <label class="mb-1 fs-4" for="titolo">Titolo: *</label>
                        <div
                            class="d-flex align-items-center justify-content-center"
                        >
                            <input
                                type="text"
                                id="titolo"
                                class="form-control me-3"
                                v-model.trim="formData.titolo"
                                required
                            />
                        </div>
                    </div>
                    <div class="mb-3 w-100">
                        <label class="mb-1 fs-4" for="showType"
                            >Tipo Show: *</label
                        >
                        <div
                            class="d-flex align-items-center justify-content-center mb-3"
                        >
                            <select
                                id="showType"
                                class="form-control me-3"
                                v-model="formData.show_type_id"
                                @change="
                                    getArtistsByShowType(formData.show_type_id)
                                "
                                required
                            >
                                <option
                                    v-for="(showType, x) in showTypes"
                                    :key="x"
                                    :value="showType.id"
                                >
                                    <span class="text-capitalize">{{
                                        showType.nome
                                    }}</span>
                                </option>
                            </select>
                        </div>
                        <div
                            v-if="artists.length > 0"
                            class="normal-font mb-4 px-2"
                        >
                            <div
                                class="form-check animate__animated animate__fadeInUp animate__faster pb-2"
                                v-for="(artist, index) in artists"
                                :key="index"
                            >
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    :value="artist.id"
                                    :id="'artist_' + artist.id"
                                    @change="addArtistsInFormdata(artist)"
                                />
                                <label
                                    class="form-check-label text-capitalize"
                                    :for="'artist_' + artist.id"
                                >
                                    {{ artist.titolo }}
                                </label>
                            </div>
                        </div>
                        <div>
                            <button
                                type="button"
                                class="btn-show border border-2"
                                data-bs-toggle="modal"
                                data-bs-target="#createArtist"
                                :disabled="!formData.show_type_id"
                            >
                                + Artista
                            </button>
                        </div>
                    </div>
                    <div class="mb-3 w-100">
                        <label class="mb-1 fs-4" for="mealType"
                            >Ora Spettacolo: *</label
                        >
                        <div
                            class="d-flex align-items-center justify-content-center"
                        >
                            <select
                                id="mealType"
                                class="form-control me-3"
                                v-model="formData.pranzo_cena"
                                required
                            >
                                <option value="pranzo">Pranzo</option>
                                <option value="cena">Cena</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div
                    class="col-12 col-md-5 d-flex flex-column align-items-start justify-content-start mb-4 h-100 border-start border-2 animate__animated animate__fadeInBottomRight"
                >
                    <h4>Descrizione: *</h4>
                    <!-- <textarea id="descrizione" class="form-control mb-4" v-model.trim="formData.descrizione" rows="10" required></textarea> -->
                    <QuillEditor
                        theme="snow"
                        class="w-100"
                        placeholder="Nuova cena per ..."
                        v-model:content="formData.descrizione"
                        contentType="html"
                    />
                    <label for="prezzo" class="mb-1 fs-4"> Prezzo * </label>
                    <input
                        type="text"
                        id="prezzo"
                        class="form-control mb-4"
                        v-model.number="formData.prezzo"
                        step="0.01"
                        @input="formatCurrency"
                    />
                    <input
                        type="file"
                        name="img"
                        class="form-control mb-3"
                        @change="onFileChange"
                        multiple
                        accept="image/*"
                    />
                    <!-- Anteprime delle immagini -->
                    <div
                        v-if="imagePreviews.length > 0"
                        class="d-flex flex-wrap"
                    >
                        <div
                            v-for="(image, index) in imagePreviews"
                            :key="index"
                        >
                            <img
                                :src="image"
                                alt="Anteprima immagine"
                                class="me-2 date-image-preview"
                            />
                        </div>
                    </div>
                </div>
                <div
                    class="col-12 d-flex flex-column align-items-center justify-content-center animate__animated animate__fadeInUp"
                >
                    <button
                        class="btn-show border border-2 text-center"
                        type="submit"
                        :disabled="formData.artisti.length === 0"
                    >
                        Crea Spettacolo
                    </button>
                    <div v-if="formData.artisti.length === 0">
                        <p>* Devi scegliere almeno un artista</p>
                    </div>
                </div>
            </div>
        </form>
        <!-- Modal -->
        <div
            class="modal fade"
            id="createArtist"
            tabindex="-1"
            aria-labelledby="createArtistLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <ArtistiCreate />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";
import axios from "axios";
import { ref, onMounted, onBeforeUnmount } from "vue";
import { router } from "@inertiajs/vue3";
import * as bootstrap from "bootstrap";
import { generalStore } from "@/Stores/state";
import ArtistiCreate from "../Artisti/Create.vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
const store = generalStore();
const page = usePage();
const data = page.props.data;
// const artists = page.props.artists;
const artists = ref([]);
const formData = ref({
    titolo: "",
    descrizione: "",
    posti_disponibili: 1,
    show_type_id: "",
    pranzo_cena: "pranzo",
    data: data,
    artisti: [],
    img: [],
    prezzo: 0,
});

function addArtistsInFormdata(artist) {
    if (!formData.value.artisti.includes(artist.id)) {
        // L'ID dell'artista non è presente nell'array, quindi lo aggiungiamo
        formData.value.artisti.push(artist.id);
    } else {
        const index = formData.value.artisti.indexOf(artist.id);
        formData.value.artisti.splice(index, 1);
    }

    console.log(formData.value.artisti);
}

function getArtistsByShowType(showtypeId) {
    artists.value = [];
    formData.value.artisti = [];
    axios
        .post("/api/filtered-artist-title/" + showtypeId)
        .then((res) => {
            res.data.artistiFiltrati.forEach((artist) => {
                artists.value.push(artist);
            });
        })
        .catch((err) => {
            console.error(err);
        });
}
const imagePreviews = ref([]);
// Aggiungo i file all array, creao un anteprima e ridimensiono i file per l'upload (meno byte piu velocità )
function onFileChange(event) {
    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
        const originalFile = files[i];
        const reader = new FileReader();

        reader.onload = (e) => {
            const dataURL = e.target.result;
            const img = new Image();
            img.src = dataURL;

            img.onload = () => {
                const maxWidth = 550;
                const maxHeight = 350;

                let newWidth, newHeight;
                if (img.width > img.height) {
                    newWidth = maxWidth;
                    newHeight = (img.height / img.width) * maxWidth;
                } else {
                    newHeight = maxHeight;
                    newWidth = (img.width / img.height) * maxHeight;
                }

                const canvas = document.createElement("canvas");
                const ctx = canvas.getContext("2d");
                canvas.width = newWidth;
                canvas.height = newHeight;
                ctx.drawImage(img, 0, 0, newWidth, newHeight);

                canvas.toBlob(
                    (blob) => {
                        const modifiedFile = new File(
                            [blob],
                            originalFile.name,
                            {
                                type: originalFile.type,
                                lastModified: originalFile.lastModified,
                            }
                        );

                        formData.value.img.push(modifiedFile);
                        imagePreviews.value.push(
                            URL.createObjectURL(modifiedFile)
                        );
                    },
                    originalFile.type,
                    0.7
                );
            };
        };

        reader.readAsDataURL(originalFile);
    }
}

async function createReservationDate() {
    try {
        const newformdata = new FormData();
        newformdata.append("data", formData.value.data);
        newformdata.append("descrizione", formData.value.descrizione);
        formData.value.img.forEach((image, index) => {
            newformdata.append(`img[${index}]`, image);
        });
        newformdata.append("pranzo_cena", formData.value.pranzo_cena);
        newformdata.append("prezzo", formData.value.prezzo);
        newformdata.append("show_type_id", formData.value.show_type_id);
        newformdata.append("titolo", formData.value.titolo);
        newformdata.append("artisti", formData.value.artisti.join(","));

        router.post("/api/reservation-dates", newformdata, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });
    } catch (error) {
        console.error("Error creating reservation date:", error);
    }
}

const showTypes = ref([]);

const fetchShowTypes = async () => {
    try {
        const response = await axios.get("/api/show-types");
        showTypes.value = response.data;
    } catch (error) {
        console.error("Error fetching show types:", error);
    }
};

function formatCurrency() {
    let price = String(formData.value.prezzo).replace(/[^\d]/g, "");
    let pre, dec;
    let delimiter = ".";

    let result = price;

    if (price.length > 3 && price.charAt(0) == "0") {
        price = price.substr(1);
    }

    if (price.length > 2) {
        pre = price.slice(0, -2);
        dec = price.substr(price.length - 2, 2);
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
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

onBeforeUnmount(() => {
    store.enableOverflowHidden();
});
</script>

<style scoped>
.date-image-preview {
    max-height: 150px;
    max-width: 150px;
    object-fit: contain;
    object-position: center;
    cursor: pointer;
}
.date-image-preview:hover {
    border-radius: 10px;
    transform: scale(1.2);
    transition: all 0.3s;
}
</style>
