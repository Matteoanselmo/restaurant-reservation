<template>
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12 mb-4 d-flex aling-items-center justify-content-evenly py-2 position-relative">
                <a :href="route('dashboard')" class="btn-show border border-2 position-absolute top-0 start-0 m-2"><i class="fa-solid fa-chevron-left"></i></a>
                <h1 class="text-capitalize text-center  m-auto">
                    resoconto
                </h1>
                <div></div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 normal-font animated animate__fadeIn" v-for="(transazione, index) in transazioni.data" :key="index">
                <div class="rounded-5 p-5 border border-2 shadow">
                    <h6>{{ transazione.description }}</h6>
                    <h6 class="d-flex align-items-center mb-4">&euro; {{ transazione.amount / 100 }}</h6>
                    <div class="d-flex flex-column justify-content-center align-items-center flex-wrap">
                        <h6 class="mb-4 text-capitalize">{{ transazione.billing_details.name }}</h6>
                        <h6 class="mb-4">{{ transazione.billing_details.email }}</h6>
                        <div class="w-100 d-flex align-items-center justify-content-evenly">
                            <a class="btn-show border border-2" :href="'mailto:' + transazione.billing_details.email"><i class="fa-regular fa-envelope"></i></a>
                            <a class="btn-show border border-2" :href="'tel:' + transazione.billing_details.phone"><i class="fa-solid fa-phone"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { computed, onMounted, onBeforeUnmount } from 'vue';
import { usePage } from '@inertiajs/vue3';
import {generalStore} from '@/Stores/state';
export default {
    name: 'RescocontoIndex',
    setup(){
        const store = generalStore();
        const page = usePage();
        const transazioni = computed(() => page.props.transazioni);

        onMounted(() => {
            store.disableOverflowHidden();
            console.log(transazioni.value);
        });

        onBeforeUnmount(() => {
            store.enableOverflowHidden();
        });

        return {
            transazioni
        }
    }
}
</script>

<style>

</style>
