<template>
    <div class="full-screen d-flex flex-column align-items-center justify-content-center">
        <h1 class="text-uppercase">
            grazie
        </h1>
        <h3 class="mb-5">
            da Villa-Albertina
        </h3>
        <a href="/" class="btn-show fs-3 border border-2">Home</a>
    </div>
</template>

<script>
import { usePage } from '@inertiajs/vue3'
import { onMounted, computed } from 'vue';
export default {
    setup(){
        const page = usePage();
        const data = computed(() => page.props.data);

        onMounted ( () => {
            console.log(data.value)
        })
    }
}
</script>

<style>

</style>
