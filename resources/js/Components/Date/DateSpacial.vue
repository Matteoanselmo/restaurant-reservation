<template>
    <div>
        <div class="position-relative animate__animated" :class="(targetIsVisible) ? 'animate__zoomIn' : ''">
            <div class="d-flex flex-column align-items-center position-absolute top-0 end-0 m-1 btn-date-mare-back">
                <button class="btn-show border border-2" @click="scrollToSection('special-show')">
                    <i class="fa-solid fa-chevron-up  fs-3" ></i>
                </button>
            </div>
            <div class="d-flex align-items-center justify-content-evenly w-100 mb-2">
                <button class="btn-show" @click="prevMonth">
                    <i class="fas fa-chevron-left fs-2"></i>
                </button>
                <h1 class="text-center mb-0 fw-bold text-uppercase">{{ currentMonth }}</h1>
                <button class="btn-show" @click="nextMonth">
                    <i class="fas fa-chevron-right fs-2 "></i>
                </button>
            </div>
            <div class="calendar d-flex flex-wrap m-0 align-items-center justify-content-center" ref="target">
                <div
                v-for="(day, index) in calendarDays"
                :key="index"
                :class="[{ 'offset-day': day.firstDayOfWeek > 0 && index < day.firstDayOfWeek}, hasAvailableSeats(day.date) ? 'border-success' : '']"
                class="calendar-day rounded-5 bg-white border border-2 btn-show"
                >
                    <Link v-if="hasAvailableSeats(day.date)"
                    class="text-decoration-none text-black normal-font"
                    :href="route('guest.select.show', { data: day.date.toLocaleDateString('en-CA', { year: 'numeric', month: '2-digit', day: '2-digit' }).replace(/\//g, '-') })"
                    >
                        <div class="day-header text-black ">{{ day.day }}</div>
                        <div class="day-name text-secondary">{{ day.dayName }}</div>
                    </Link>
                    <Link v-else class="text-decoration-none normal-font" :href="route('guest.no.date', {data: day.date.toLocaleDateString('en-CA', { year: 'numeric', month: '2-digit', day: '2-digit' }).replace(/\//g, '-')} )" >
                        <div class="day-header text-black ">{{ day.day }}</div>
                        <div class="day-name text-secondary">{{ day.dayName }}</div>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue'
import { useElementVisibility } from '@vueuse/core'
export default {
    name: 'DateAttivita',
    components: {
        Link
    },
    setup() {
        const target = ref(null)
        const targetIsVisible = useElementVisibility(target)

        return {
        target,
        targetIsVisible,
        }
    },
    data() {
        return {
            currentMonth: new Date().toLocaleDateString('default', {
                month: 'long',
                year: 'numeric',
                hasDate: false
            }),
            monthWithMareDates: [],
            currentDate: new Date(),
            firstDayOfWeek: 0,
        };
    },
    computed: {
        calendarDays() {
            const year = this.currentDate.getFullYear();
            const month = this.currentDate.getMonth();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            const calendarDays = [];
            for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(year, month, day);
            const dayOfWeek = (this.firstDayOfWeek + day - 1) % 7;
            calendarDays.push({
                day,
                dayName: date.toLocaleDateString('default', { weekday: 'short' }),
                date,
                firstDayOfWeek: dayOfWeek,
            });
            }
            this.getMareMonthDates();
            return calendarDays;
        },
    },
    methods: {
        getMareMonthDates(){
            const month = this.currentDate.getMonth() + 1;
            this.monthWithMareDates = [];
            axios.post(`/api/get-reservation-dates/${month}/${1}`)
            .then((response) => {
                if(response.data){
                    response.data.forEach(date => {
                        const dateObject = new Date(date.data);
                        this.monthWithMareDates.push(dateObject);
                    });
                    console.log(this.monthWithMareDates)
                }
            })
            .catch((error)=> {
                console.error(error)
            })
        },
        hasAvailableSeats(date) {
            return this.monthWithMareDates.some(eventDate => eventDate.getDate() === date.getDate());
        },
        prevMonth() {
            this.currentDate.setMonth(this.currentDate.getMonth() - 1);
            this.updateCurrentMonth();
        },
        nextMonth() {
            this.currentDate.setMonth(this.currentDate.getMonth() + 1);
            this.updateCurrentMonth();
        },
        updateCurrentMonth() {
            this.currentMonth = this.currentDate.toLocaleDateString('default', {
            month: 'long',
            year: 'numeric',
            });
            this.firstDayOfWeek = this.getFirstDayOfWeek();
        },
        getFirstDayOfWeek() {
            const firstDayOfMonth = new Date(
            this.currentDate.getFullYear(),
            this.currentDate.getMonth(),
            1
            );
            return firstDayOfMonth.getDay();
        },
        scrollToSection(sectionId) {
            const targetSection = document.getElementById(sectionId);

            if (targetSection) {
                targetSection.scrollIntoView({ behavior: 'smooth' });
            }
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
            const sectionId = 'special-show'; // Vai alla sezione successiva
            this.scrollToSection(sectionId);
        }
        });
    }
}
</script>

<style lang="scss" scoped>
    @media screen and (max-width: 992px) {
            .btn-date-mare-back{
                width: 100%;
                top: 100% !important;
                left: 50%;
                transform: translateX(-50%);
                button{
                    margin-top: 30vh;
                    width: 95%;
                }
            }
        }
</style>
