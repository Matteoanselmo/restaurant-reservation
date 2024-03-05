<template>
    <div class="container-fluid">
        <application-logo></application-logo>
        <button-info></button-info>
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="text-center">
                    {{ $t("menu.create_menu") }}
                </h2>
            </div>
        </div>
        <Form class="row">
            <div class="col-12 col-md-6">
                <div>
                    <div
                        class="position-relative animate__animated"
                        :class="targetIsVisible ? 'animate__zoomIn' : ''"
                    >
                        <div
                            class="d-flex align-items-center justify-content-evenly w-100 mb-2"
                        >
                            <button class="btn-show" @click="prevMonth">
                                <i class="fas fa-chevron-left fs-2"></i>
                            </button>
                            <h3 class="text-center mb-0 fw-bold text-uppercase">
                                {{ $t("months." + currentMonth) }}
                            </h3>
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
                                    'calendar-day rounded-5 bg-white border border-2 btn-show',
                                    {
                                        'offset-day':
                                            day.firstDayOfWeek > 0 &&
                                            index < day.firstDayOfWeek,
                                        'date-unavailable': !isDateAvailable(),
                                        'date-available': isDateAvailable(
                                            day.date
                                        ),
                                        'border-success': selectedDates.some(
                                            (selectedDate) =>
                                                selectedDate.getTime() ===
                                                day.date.getTime()
                                        ),
                                        'my-blur': propsDates.some(
                                            (propDate) =>
                                                propDate.getTime() ===
                                                day.date.getTime()
                                        ),
                                    },
                                ]"
                                @click="selectDate(day)"
                            >
                                <div
                                    class="text-decoration-none text-black normal-font"
                                >
                                    <div class="day-header text-black">
                                        {{ day.day }}
                                    </div>
                                    <div class="day-name text-secondary">
                                        {{ day.dayName }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="col-12 col-md-6 d-flex flex-column align-items-center justify-content-center"
            >
                <div class="mb-2 w-100">
                    <p class="mb-0 me-3 fs-5">{{ $t("form.name") }}*</p>
                    <Field
                        name="nome"
                        v-model="subject.nome"
                        :rules="validationRules.name"
                        class="form-control"
                    />
                    <ErrorMessage name="nome" class="text-danger" />
                </div>
                <div class="mb-2 w-100">
                    <p class="mb-0 me-3 fs-5">{{ $t("form.email") }}*</p>
                    <Field
                        name="email"
                        v-model="subject.email"
                        :rules="validationRules.email"
                        class="form-control"
                    />
                    <ErrorMessage name="email" class="text-danger" />
                </div>
                <div class="mb-2 w-100">
                    <p class="mb-0 me-3 fs-5">{{ $t("form.ingredients") }}*</p>
                    <Field
                        as="textarea"
                        name="text"
                        v-model="subject.text"
                        :rules="validationRules.text"
                        class="form-control"
                        max="500"
                    />
                    <ErrorMessage name="text" class="text-danger" />
                </div>
                <div class="mb-5 w-100">
                    <p class="mb-0 me-3 fs-5">{{ $t("form.allergens") }}*</p>
                    <Field
                        as="textarea"
                        name="allergens"
                        v-model="subject.allergens"
                        :rules="validationRules.allergens"
                        class="form-control"
                        max="500"
                    />
                    <ErrorMessage name="allergens" class="text-danger" />
                </div>
                <div>
                    <button
                        class="btn show border border-2 rounded-5 p-3"
                        type="submit"
                    >
                        Invia
                    </button>
                </div>
            </div>
        </Form>
    </div>
</template>

<script setup>
import { Form, Field, ErrorMessage, defineRule } from "vee-validate";
import getValidationRules from "@/validation-rules";
import { useI18n } from "vue-i18n";
import { ref, computed, onMounted } from "vue";
import { useElementVisibility } from "@vueuse/core";
import { usePage } from "@inertiajs/vue3";
import { generalStore } from "@/Stores/state";
const store = generalStore();
const subject = ref({
    name: "",
    email: "",
    text: "",
    allergens: "",
    selectedDate: null, // Aggiungi questa riga
});

const page = usePage();
const props = page.props.hasDates;
const { t } = useI18n();
const validationRules = getValidationRules(t);
const target = ref(null);
const targetIsVisible = useElementVisibility(target);
const currentDate = ref(new Date());

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
        const dayOfWeek = date.getDay();
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
    return days;
});
// Assicurati che props.hasDates sia definito e non sia vuoto prima di eseguire map
const propsDates = ref(
    props.hasDates && Array.isArray(props.hasDates)
        ? props.hasDates.map((dateObj) => new Date(dateObj.data))
        : []
);

const isDateAvailable = (date) => {
    return !propsDates.value.some((propDate) => {
        return (
            propDate.getTime() === date.getTime() &&
            propDate.getMonth() === currentDate.value.getMonth() &&
            propDate.getFullYear() === currentDate.value.getFullYear()
        );
    });
};

const selectedDates = ref([]);

const selectDate = (day) => {
    if (isDateAvailable(day.date)) {
        // Se la data selezionata è già quella attiva, deselezionala
        if (subject.selectedDate === day.date.toISOString().substring(0, 10)) {
            subject.selectedDate = null;
        } else {
            // Altrimenti, imposta la nuova data selezionata
            subject.selectedDate = day.date.toISOString().substring(0, 10);
        }
    }
};

function prevMonth() {
    currentDate.value = new Date(
        currentDate.value.getFullYear(),
        currentDate.value.getMonth() - 1,
        1
    );
}

function nextMonth() {
    currentDate.value = new Date(
        currentDate.value.getFullYear(),
        currentDate.value.getMonth() + 1,
        1
    );
}

// Definisci le regole di vee-validate utilizzando le regole di validazione
Object.keys(validationRules).forEach((ruleName) => {
    defineRule(ruleName, validationRules[ruleName]);
});
store.disableOverflowHidden();

console.log(props);
console.log(calendarDays);
</script>

<style lang="scss" scoped>
.calendar {
    max-width: 100%;
    max-height: 50vh;
    .calendar-day {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 10px !important;
        margin: 5px;
        cursor: pointer;
        width: calc((50vw / 7) - 10px) !important;
        height: 89px;

        .day-header {
            font-size: 1.5rem;
        }

        .day-name {
            font-size: 1rem;
            margin-top: 5px;
        }
    }
}
@media (max-width: 992px) {
    .calendar {
        .calendar-day {
            height: 65px;
            padding: 0 !important;
            margin: 2.5px;
            width: calc((100vw / 7) - 5px) !important;
            border-radius: 15px !important;
            .day-name {
                font-size: 0.8rem;
                margin-top: 0;
            }
        }
    }
}
</style>
