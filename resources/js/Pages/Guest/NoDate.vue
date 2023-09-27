<template>
    <div class="container-fluid">
        <div class="full-screen row justify-content-center align-items-center position-relative">
            <img src="/images/logo/logo.png" class="position-absolute top-50 start-50 translate-middle w-50 h-50" style="filter: blur(6px) opacity(0.5);"/>
            <div class="col-7">
                <h1 class="text-center position-absolute top-50 start-50 translate-middle">
                    Ci dispiace tanto, non c'è ancora nessuno spettacolo per <span class="text-capitalize">{{new Date(data).toLocaleDateString('it-IT', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}</span>
                </h1>
            </div>
        </div>
    </div>
</template>

<script>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
export default {
    name:'NoData',
    components:{
        ApplicationLogo
    },
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
