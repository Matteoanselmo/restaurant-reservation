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
        <lode class="full-screen d-flex flex-column px-5 justify-content-center align-items-center overflow-hidden" ref="lodeRef"/>
        <div class="d-flex">
            <div>
                <MareShow
                    class="full-screen "
                    id="mare-show"
                    ref="mareShowRef"
                />
                <DateMare
                    class="full-screen d-flex flex-column justify-content-start align-items-center"
                    id="mare-date"
                    ref="mareDateRef"
                />
            </div>
            <div>
                <ChoseShow class="full-screen d-flex justify-content-center align-items-center" id="chose-show" ref="showRef"/>
                <div>
                    <SpecialShow
                        class="full-screen d-flex flex-column justify-content-start align-items-center position-relative"
                        id="special-show"
                        ref="terraShowRef"
                    />
                    <DateSpacial class="full-screen d-flex flex-column justify-content-start align-items-center" id="special-date" ref="attivitaDateRef"/>
                </div>
            </div>
            <div>
                <TerraShow
                    class="full-screen d-flex justify-content-center align-items-center"
                    id="terra-show"
                    ref="terraShowRef"
                />
                <DateTerra
                    class="full-screen d-flex flex-column justify-content-start align-items-center"
                    id="terra-date"
                    ref="terraDateRef"
                />
            </div>
        </div>
    </div>

</template>

<script>
import ApplicationLogo from '../Components/ApplicationLogo.vue'
import Lode from '../Components/Lode.vue'
import NotARestaurant from '../Components/NotARestaurant.vue'
import ChoseShow from '../Components/ChoseShow.vue'
import MareShow from '../Components/MareShow.vue'
import TerraShow from '../Components/TerraShow.vue'
import SpecialShow from '../Components/SpecialShow.vue'
import DateMare from '../Components/Date/DateMare.vue'
import DateSpacial from '../Components/Date/DateSpacial.vue'
import DateTerra from '../Components/Date/DateTerra.vue'
export default {
    name: 'ApplicationLogo',
    components: {
        ApplicationLogo,
        Lode,
        NotARestaurant,
        ChoseShow,
        MareShow,
        TerraShow,
        SpecialShow,
        DateMare,
        DateSpacial,
        DateTerra
    },
    mounted() {
        setTimeout(() => {
            this.scrollComponent(this.$refs.restaurantRef);
        }, 1500); // Dopo 0.5 secondi
    },
    methods: {
        async scrollComponent(ref) {
            if (ref && ref.$el) {
                ref.$el.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
                });
                if (ref !== this.$refs.showRef) {
                    if (ref === this.$refs.lodeRef) {
                        await new Promise(resolve => setTimeout(resolve, 5000)); // Attendi 3.5 secondi prima dello scorrimento successivo
                    }
                    await new Promise(resolve => setTimeout(resolve, 1500)); // Attendi 3.5 secondi prima dello scorrimento successivo
                    const nextRef = this.getNextRef(ref);
                    this.scrollComponent(nextRef);
                }
            }
        },
        getNextRef(currentRef) {
        switch (currentRef) {
            case this.$refs.restaurantRef:
                return this.$refs.lodeRef;
            case this.$refs.lodeRef:
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
