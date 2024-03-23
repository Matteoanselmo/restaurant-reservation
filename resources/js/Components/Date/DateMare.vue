<script setup>
import { ref, computed, onMounted } from "vue";
import { useElementVisibility } from "@vueuse/core";
import { Link } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";
const { t } = useI18n();

const target = ref(null);
const targetIsVisible = useElementVisibility(target);
const currentDate = ref(new Date());
const monthWithMareDates = ref([]);

const currentMonth = computed(() => {
    const monthIndex = currentDate.value.getMonth();
    const monthKey = [
        "january",
        "february",
        "march",
        "april",
        "may",
        "june",
        "july",
        "august",
        "september",
        "october",
        "november",
        "december",
    ][monthIndex];
    return monthKey;
});

const calendarDays = computed(() => {
    const year = currentDate.value.getFullYear();
    const month = currentDate.value.getMonth();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    const days = [];
    for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(year, month, day);
        const dayOfWeek = date.getDay(); // Ottiene il giorno della settimana come numero (0 per Domenica, 6 per Sabato)
        const dayNameKey = [
            "sunday",
            "monday",
            "tuesday",
            "wednesday",
            "thursday",
            "friday",
            "saturday",
        ][dayOfWeek];
        const dayNameShort = t(`days.${dayNameKey}`).substring(0, 3);
        days.push({
            day,
            dayName: dayNameShort, // Usa il nome abbreviato del giorno
            date,
            firstDayOfWeek: (date.getDay() + 6) % 7,
        });
    }
    getMareMonthDates();
    return days;
});

function getMareMonthDates() {
    const month = currentDate.value.getMonth() + 1;
    monthWithMareDates.value = [];
    axios
        .post(`/api/get-reservation-dates/${month}/${1}`)
        .then((response) => {
            if (response.data) {
                response.data.forEach((date) => {
                    const dateObject = new Date(date.data);
                    monthWithMareDates.value.push(dateObject);
                });
            }
        })
        .catch((error) => {
            console.error(error);
        });
}

const hasAvailableSeats = (date) => {
    return monthWithMareDates.value.some(
        (eventDate) => eventDate.getDate() === date.getDate()
    );
};

function prevMonth() {
    const newDate = new Date(currentDate.value);
    newDate.setDate(1);
    newDate.setMonth(newDate.getMonth() - 1);
    currentDate.value = newDate;
}

function nextMonth() {
    const newDate = new Date(currentDate.value);
    newDate.setDate(1);
    newDate.setMonth(newDate.getMonth() + 1);
    currentDate.value = newDate;
}

function scrollToSection(sectionId) {
    const targetSection = document.getElementById(sectionId);
    if (targetSection) {
        targetSection.scrollIntoView({ behavior: "smooth" });
    }
}

onMounted(() => {
    let initialTouchY = 0;
    const el = target.value;

    el.addEventListener("touchstart", (e) => {
        initialTouchY = e.touches[0].clientY;
    });

    el.addEventListener("touchend", (e) => {
        const deltaY = initialTouchY - e.changedTouches[0].clientY;
        const swipeThreshold = -50;
        if (deltaY < swipeThreshold) {
            scrollToSection("mare-show");
        }
    });
});
</script>

<template>
    <div>
        <div
            class="position-relative animate__animated"
            :class="targetIsVisible ? 'animate__zoomIn' : ''"
        >
            <div
                class="d-flex flex-column align-items-center position-absolute top-0 end-0 m-1 btn-date-mare-back"
            >
                <button
                    class="btn-show border border-2"
                    @click="scrollToSection('mare-show')"
                >
                    <i class="fa-solid fa-chevron-up fs-3"></i>
                </button>
            </div>
            <div
                class="d-flex align-items-center justify-content-evenly w-100 mb-2"
            >
                <button class="btn-show" @click="prevMonth">
                    <i class="fas fa-chevron-left fs-2"></i>
                </button>
                <h1 class="text-center mb-0 fw-bold text-uppercase">
                    {{ $t("months." + currentMonth) }}
                </h1>
                <button class="btn-show" @click="nextMonth">
                    <i class="fas fa-chevron-right fs-2"></i>
                </button>
            </div>
            <div
                class="calendar d-flex flex-wrap m-0 align-items-center justify-content-center"
                ref="target"
            >
                <div
                    v-for="(day, index) in calendarDays"
                    :key="index"
                    :class="[
                        {
                            'offset-day':
                                day.firstDayOfWeek > 0 &&
                                index < day.firstDayOfWeek,
                        },
                        hasAvailableSeats(day.date) ? 'border-success' : '',
                    ]"
                    class="calendar-day rounded-5 bg-white border border-2 btn-show"
                >
                    <Link
                        v-if="hasAvailableSeats(day.date)"
                        class="text-decoration-none text-black normal-font w-100 h-100"
                        :href="
                            route('guest.select.show', {
                                data: day.date
                                    .toLocaleDateString('en-CA', {
                                        year: 'numeric',
                                        month: '2-digit',
                                        day: '2-digit',
                                    })
                                    .replace(/\//g, '-'),
                            })
                        "
                    >
                        <div class="day-header text-black">{{ day.day }}</div>
                        <div class="day-name text-secondary">
                            {{ day.dayName }}
                        </div>
                    </Link>
                    <Link
                        v-else
                        class="text-decoration-none text-black normal-font w-100 h-100"
                        :href="
                            route('guest.no.date', {
                                data: day.date
                                    .toLocaleDateString('en-CA', {
                                        year: 'numeric',
                                        month: '2-digit',
                                        day: '2-digit',
                                    })
                                    .replace(/\//g, '-'),
                            })
                        "
                    >
                        <div class="day-header text-black">{{ day.day }}</div>
                        <div class="day-name text-secondary">
                            {{ day.dayName }}
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@media screen and (max-width: 992px) {
    .btn-date-mare-back {
        width: 100%;
        top: 100% !important;
        left: 50%;
        transform: translateX(-50%);
        button {
            margin-top: 30vh;
            width: 95%;
        }
    }
}
</style>
