<template>
    <div class="full-screen d-flex flex-column align-items-center justify-content-center my-4 animated animate__fadeInLeft">
        <div class="d-flex align-items-center justify-content-evenly w-100 mb-5">
            <button class="btn-show" @click="prevMonth">
                <i class="fas fa-chevron-left fs-2"></i>
            </button>
            <h1 class="text-center mb-0 fw-bold text-uppercase">{{ currentMonth }}</h1>
            <button class="btn-show" @click="nextMonth">
                <i class="fas fa-chevron-right fs-2 "></i>
            </button>
        </div>
        <div class="calendar row  w-100 align-items-center justify-content-center animated animate__fadeInUp">
            <div
            v-for="(day, index) in calendarDays"
            :key="index"
            :class="[{ 'offset-day': day.firstDayOfWeek > 0 && index < day.firstDayOfWeek}, hasAvailableSeats(day.date) ? 'border-success' : '']"
            class="calendar-day rounded-5 bg-white border border-2 btn-show col-2 col-md-1"
            >
            <!-- <div class="text-decoration-none text-black">
                    <div class="day-header">{{ day.day }}</div>
                    <div class="day-name">{{ day.dayName }}</div>
            </div> -->
                <Link v-if="hasAvailableSeats(day.date)"
                class="text-decoration-none text-black"
                :href="route('dashboard.date.show', { data: day.date.toLocaleDateString('en-CA', { year: 'numeric', month: '2-digit', day: '2-digit' }).replace(/\//g, '-') })"
                >
                    <div>
                        {{ day.date.toLocaleDateString('en-CA', { year: 'numeric', month: '2-digit', day: '2-digit' }).replace(/\//g, '-') }}
                    </div>
                    <div class="day-header">{{ day.day }}</div>
                    <div class="day-name">{{ day.dayName }}</div>
                </Link>
                <Link v-else class="text-decoration-none text-black" :href="route('dashboard.date.create')" >
                    <div class="day-header">{{ day.day }}</div>
                    <div class="day-name">{{ day.dayName }}</div>
                </Link>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
export default {
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
            axios.post(`/api/get-reservation-dates/${month}`)
            .then((response) => {
                if(response.data){
                    response.data.forEach(date => {
                        const dateObject = new Date(date.data);
                        this.monthWithDates.push(dateObject);
                        // const day = dateObject.getDate();
                    });
                    // console.log(this.monthWithDates);
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
    },
};
</script>


<style scoped>

html, body {
    overflow: scroll !important;
}
/* .calendar {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 10px;
    width: 100%;
    padding: 15px;
    max-width: 80vw;
} */

.calendar-day {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    /* padding: 10px; */
    margin: 5px;
    cursor: pointer;
}

.day-header {
    font-size: 1.5rem;
}

.day-name {
    font-size: 1rem;
    margin-top: 5px;
}

.dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-top: 5px;
}

.dot-green {
    background-color: green;
}

.dot-red {
    background-color: red;
}

.btn-group {
    margin-top: 1rem;
}

@media (max-width: 575.98px) {
    /* .calendar{
        grid-template-columns: repeat(7, 1fr);
    } */
}
</style>
