<template>
    <div class="full-screen d-flex flex-column px-3 justify-content-start mt-3">
        <div class="">
            <h1 class="text-center mb-4 fw-bold">{{new Date(newDate[0].data).toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}</h1>

        </div>
    </div>

</template>

<script>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import axios from 'axios'
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
export default {
    name: 'GuestShow',
    setup(){
        const page = usePage()
        const date = computed(() => page.props.data)
        const showTypes = computed(() => page.props.showTypes)
        const newDate = date;
        const alert = ref([]);

        return {
            date,
            newDate,
            showTypes,
            alert
        }
    }
}
</script>

<style>

</style>
