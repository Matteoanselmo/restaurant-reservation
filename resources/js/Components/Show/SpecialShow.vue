<template>
    <div class="container-fluid position-relative" ref="specialShow">
        <div class="row">
            <div class="col-12 d-flex flex-column align-items-center mb-2">
                <button class="btn-show" @click="scrollToSection('chose-show')">
                    <i class="fa-solid fa-chevron-up  fs-3" ></i>
                </button>
                <h1>
                    Lo Special
                </h1>
            </div>
            <div class="col-6 col-md-4 col-lg-3 " v-for="(artista, i) in specialArtists" :key="i" >
                <div class="rounded-5 border border-2 p-2 mb-4 position-relative artist-card  guest-artist-card py-5 w-100 h-100">
                    <div class="position-absolute top-0 start-0 h-100 w-100 my-blur ">
                        <img :src="'/' + artista.img_path" alt="" class="h-100 w-100 artist-img rounded-5">
                    </div>
                    <div class="position-absolute top-50 start-50 translate-middle z-2 d-flex justify-content-evenly align-items-center h-100 w-100">
                        <h2 class="text-start text-capitalize">
                            {{ artista.titolo }}
                        </h2>
                        <div class="d-flex flex-column justify-content-evenly align-items-center h-100 w-75">
                            <h5 class="text-uppercase border border-2 btn-show">
                                {{ artista.show_type.nome }}
                            </h5>
                            <p>
                                {{ artista.descrizione }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button class="position-absolute start-50 translate-middle-x btn-show my-btn-bottom " @click="scrollToSection('special-date')">
                    Date
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useElementVisibility } from '@vueuse/core'
export default {
    name: 'SpecialShow',
    setup(){
        function scrollToSection(sectionId) {
            const targetSection = document.getElementById(sectionId);

            if (targetSection) {
                targetSection.scrollIntoView({ behavior: 'smooth' });
            }
        }
        const specialShow =ref(null);
        const targetIsVisible = useElementVisibility(specialShow)
        const specialArtists = ref([]);

        onMounted(()=> {
            if(targetIsVisible){
                axios.post(`/api/filtered-artist/${2}`)
                .then((res) => {
                    specialArtists.value = res.data.artistiFiltrati;
                }).catch((err) => {
                    console.error(err)
                })
            }
        })
        return {
            scrollToSection,
            specialArtists,
            specialShow,
            targetIsVisible
        }
    },
    mounted() {
        let initialTouchY = 0;

        // Aggiungi un listener per il gesto di swipe
        this.$el.addEventListener('touchstart', (e) => {
        initialTouchY = e.touches[0].clientY;
        });

        this.$el.addEventListener('touchend', (e) => {
            const deltaY = initialTouchY - e.changedTouches[0].clientY;

            // Definisci una soglia per determinare quando considerare il gesto come uno swipe
            const swipeThreshold = -50;

            if (deltaY < swipeThreshold) {
                // Calcola la direzione dello swipe
                const sectionId = 'chose-show'; // Vai alla sezione successiva
                this.scrollToSection(sectionId);
            } else {
                const sectionId = 'special-date'; // Vai alla sezione successiva
                this.scrollToSection(sectionId);
            }
        });
    }
}
</script>

<style scoped>

</style>
