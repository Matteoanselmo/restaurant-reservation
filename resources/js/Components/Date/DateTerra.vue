<template>
    <div>
        <div>
            <div class="d-flex flex-column align-items-center d-none">
                <button class="btn-show" @click="scrollToSection('terra-show')">
                    <i class="fa-solid fa-chevron-up  fs-3" ></i>
                </button>
                <h1>
                    Date di terra
                </h1>
            </div>
            <div class="d-flex align-items-center justify-content-evenly w-100 mb-5">
                <button class="btn-show" @click="prevMonth">
                    <i class="fas fa-chevron-left fs-2"></i>
                </button>
                <h1 class="text-center mb-0 fw-bold text-uppercase">{{ currentMonth }}</h1>
                <button class="btn-show" @click="nextMonth">
                    <i class="fas fa-chevron-right fs-2 "></i>
                </button>
            </div>
            <div class="calendar row  m-0 w-100 align-items-center justify-content-center animated animate__fadeInUp">
                <div
                v-for="(day, index) in calendarDays"
                :key="index"
                :class="[{ 'offset-day': day.firstDayOfWeek > 0 && index < day.firstDayOfWeek}, hasAvailableSeats(day.date) ? 'border-success' : '']"
                class="calendar-day rounded-5 bg-white border border-2 btn-show col col-md-2"
                >
                    <Link v-if="hasAvailableSeats(day.date)"
                    class="text-decoration-none text-black"
                    :href="route('guest.mare.show', { data: day.date.toLocaleDateString('en-CA', { year: 'numeric', month: '2-digit', day: '2-digit' }).replace(/\//g, '-') })"
                    >
                        <div class="day-header">{{ day.day }}</div>
                        <div class="day-name">{{ day.dayName }}</div>
                    </Link>
                    <Link v-else class="text-decoration-none text-black" :href="route('guest.no.date', {data: day.date.toLocaleDateString('en-CA', { year: 'numeric', month: '2-digit', day: '2-digit' }).replace(/\//g, '-')} )" >
                        <div class="day-header">{{ day.day }}</div>
                        <div class="day-name">{{ day.dayName }}</div>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
export default {
    name: 'DateTerra',
    components: {
        Link
    },
    data() {
        return {
            currentMonth: new Date().toLocaleDateString('default', {
                month: 'long',
                year: 'numeric',
                hasDate: false
            }),
            monthWithDates: [],
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
            this.getMonthDates();
            return calendarDays;
        },
    },
    methods: {
        getMonthDates(){
            const month = this.currentDate.getMonth() + 1;
            this.monthWithDates = [];
            axios.post(`/api/get-reservation-dates/${month}/${3}`)
            .then((response) => {
                if(response.data){
                    console.log(response.data[0].bookings)
                    response.data.forEach(date => {
                        const dateObject = new Date(date.data);
                        this.monthWithDates.push(dateObject);
                    });
                }
            })
            .catch((error)=> {
                console.error(error)
            })
        },
        hasAvailableSeats(date) {
            return this.monthWithDates.some(eventDate => eventDate.getDate() === date.getDate());
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
            const sectionId = 'terra-show'; // Vai alla sezione successiva
            this.scrollToSection(sectionId);
        }
        });
    }
}
</script>

<style>

</style>
