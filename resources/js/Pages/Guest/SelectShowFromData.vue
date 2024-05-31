<template>
    <div
        class="container-fluid d-flex flex-column px-3 justify-content-start mt-3 position-relative"
        id="prenotation-table"
    >
        <button-info></button-info>
        <div
            class="d-flex flex-column align-items-center position-absolute top-0 start-0 m-1 z-3"
        >
            <a class="btn-show border border-2" href="/">
                <i class="fa-solid fa-chevron-left fs-3"></i>
            </a>
        </div>
        <div class="container-fluid">
            <div class="row justify-content-evenly">
                <div class="col-12 mb-5">
                    <h2 class="text-center text-capitalize">
                        {{
                            new Date(newDate[0].data).toLocaleDateString(
                                "it-IT",
                                {
                                    weekday: "long",
                                    year: "numeric",
                                    month: "long",
                                    day: "numeric",
                                }
                            )
                        }}
                    </h2>
                </div>
                <div
                    class="col-12 col-sm-4 d-flex flex-column align-items-center justify-content-center border-bottom border-2 mb-5"
                    v-for="(data, i) in newDate"
                    :key="i"
                >
                    <div class="complex-grid row">
                        <div
                            v-for="(image, index) in data.images"
                            :key="index"
                            :class="getBootstrapGridClasses(index)"
                            class="mb-3"
                        >
                            <img
                                :src="image.path"
                                class="img-fluid shadow w-100"
                                alt="..."
                            />
                        </div>
                    </div>
                    <h3 class="text-uppercase text-center">
                        {{ data.titolo }}
                    </h3>
                    <h3 class="text-uppercase">
                        {{ data.pranzo_cena }} {{ newDate[0].show_type.nome }}
                    </h3>
                    <h5 class="mb-5" v-html="data.descrizione"></h5>
                    <h3 class="mb-4">&euro;{{ data.prezzo }} p.p.</h3>
                    <a
                        :href="route('scelta.posti', { id: data.id })"
                        class="btn-show border border-2 mb-4 text-uppercase"
                        >seleziona posti</a
                    >
                    <h3>
                        diponibili:
                        {{ store.prenotations.length - data.bookings.length }}
                    </h3>
                </div>
            </div>
        </div>
        <div></div>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted, onBeforeUnmount } from "vue";
import { generalStore } from "@/Stores/state";

const page = usePage();
const date = computed(() => page.props.data);
const newDate = date;
const alert = ref([]);
const store = generalStore();
onMounted(() => {
    store.disableOverflowHidden();
});

onBeforeUnmount(() => {
    store.enableOverflowHidden();
});

const getBootstrapGridClasses = (index) => {
    if (index % 2 === 0) {
        // Indice pari
        return "col-3";
    } else {
        // Indice dispari
        return "col-6";
    }
};
</script>

<style lang="scss" scoped>
#prenotation-table {
    overflow: auto;

    .complex-grid {
        display: flex;
        flex-wrap: wrap;

        img {
            border-radius: 8px;
        }
    }
}
</style>
