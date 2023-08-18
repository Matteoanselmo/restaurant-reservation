<script setup>
import { Head, Link } from '@inertiajs/vue3';


defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />
    <div id="home" >
        <ApplicationLogo class="full-screen d-flex justify-content-center align-items-center overflow-hidden" ref="appLogoRef"/>
        <NotARestaurant class="full-screen d-flex justify-content-center align-items-center overflow-hidden" ref="restaurantRef"/>
        <ChoseShow class="full-screen d-flex justify-content-center align-items-center" ref="showRef"/>
    </div>

</template>

<script>
import ApplicationLogo from '../Components/ApplicationLogo.vue'
import NotARestaurant from '../Components/NotARestaurant.vue'
import ChoseShow from '../Components/ChoseShow.vue'
export default {
    name: 'ApplicationLogo',
    components: {
        ApplicationLogo,
        NotARestaurant,
        ChoseShow
    },
    mounted() {
        setTimeout(() => {
        this.scrollComponent(this.$refs.restaurantRef);
        }, 500); // Dopo 0.5 secondi
    },
    methods: {
        async scrollComponent(ref) {
        if (ref && ref.$el) {
            ref.$el.scrollIntoView({
            behavior: 'smooth',
            block: 'start',
            });
            if (ref !== this.$refs.showRef) {
            await new Promise(resolve => setTimeout(resolve, 3500)); // Attendi 0.5 secondi prima dello scorrimento successivo
            const nextRef = this.getNextRef(ref);
            this.scrollComponent(nextRef);
            }
        }
        },
        getNextRef(currentRef) {
        switch (currentRef) {
            case this.$refs.restaurantRef:
                return this.$refs.showRef;
            case this.$refs.showRef:
                default:
                 return null; // Fermati qui
        }
        },
    },
}
</script>

<style lang="scss" scoped>

</style>
