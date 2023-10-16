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
        <div>
            <ApplicationLogo class="full-screen d-flex justify-content-center align-items-center overflow-hidden animated animate__slideInUp" ref="appLogoRef"/>
            <NotARestaurant class="full-screen d-flex justify-content-center align-items-center overflow-hidden animated animate__zoomIn" ref="restaurantRef"/>
            <lode class="full-screen d-flex flex-column px-5 justify-content-center align-items-center overflow-hidden " ref="lodeRef"/>
        </div>
        <div class="d-flex">
            <div>
                <MareShow
                    class="full-screen"
                    id="mare-show"
                />
                <DateMare
                    class="full-screen d-flex flex-column align-items-center justify-content-start my-4 animated animate__fadeInLeft"
                    id="mare-date"
                />
            </div>
            <div>
                <ChoseShow
                    class="full-screen d-flex justify-content-center align-items-center"
                    id="chose-show"
                    ref="showRef"/>
                <div>
                    <SpecialShow
                        class="full-screen"
                        id="special-show"
                    />
                    <DateSpacial
                        class="full-screen d-flex flex-column justify-content-start align-items-center"
                        id="special-date" />
                </div>
            </div>
            <div>
                <TerraShow
                    class="full-screen"
                    id="terra-show"
                />
                <DateTerra
                    class="full-screen d-flex flex-column justify-content-start align-items-center"
                    id="terra-date"
                />
            </div>
        </div>
    </div>

</template>

<script>
import ApplicationLogo from '../Components/ApplicationLogo.vue'
import Lode from '../Components/Lode.vue'
import NotARestaurant from '../Components/NotARestaurant.vue'
import ChoseShow from '../Components/Show/ChoseShow.vue'
import MareShow from '../Components/Show/MareShow.vue'
import TerraShow from '../Components/Show/TerraShow.vue'
import SpecialShow from '../Components/Show/SpecialShow.vue'
import DateMare from '../Components/Date/DateMare.vue'
import DateSpacial from '../Components/Date/DateSpacial.vue'
import DateTerra from '../Components/Date/DateTerra.vue'
import {generalStore} from '@/Stores/state';
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
    data(){
        return{
            store : generalStore()
        }
    },
    mounted() {
        if(this.store.isVisited){
            setTimeout(() => {
                this.scrollComponent(this.$refs.restaurantRef);
            }, 1500); // Dopo 0.5 secondi
        } else {
            this.showRefView()
        }
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
                        await new Promise(resolve => setTimeout(resolve, 1000)); // Attendi 5 secondi prima dello scorrimento successivo
                    } else {
                        await new Promise(resolve => setTimeout(resolve, 1000)); // Attendi 3.5 secondi prima dello scorrimento successivo
                    }
                }
                const nextRef = this.getNextRef(ref);

                if (nextRef) {
                    this.scrollComponent(nextRef);
                } else if (ref === this.$refs.showRef && !this.store.isVisited) {
                    this.showRefView();
                }
            }
        },
        showRefView(){
            this.$refs.showRef.$el.scrollIntoView({
                block:'start'
            })
        },
        getNextRef(currentRef) {
        switch (currentRef) {
            case this.$refs.restaurantRef:
                return this.$refs.lodeRef;
            case this.$refs.lodeRef:
                return this.$refs.showRef;
            case this.$refs.showRef:
            default:
                return null; // Termina lo scorrimento qui
            }
        },
    },
}
</script>

<style lang="scss" scoped>

</style>
