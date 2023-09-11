<template>
    <div class="container-fluid">
        <div class="full-screen row justify-content-center align-items-center">
            <div class="col-7">
                <h1>
                    Ci dispiace tanto, non c'è ancora nessuno spettacolo per {{new Date(data).toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
                </h1>
            </div>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
export default {
    name:'NoData',
    setup(){
        const page = usePage()
        const data = computed(() => page.props.data)

        return  {
            data
        }
    }
}
</script>

<style>

</style>
