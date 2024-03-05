<template>
    <div class="container-fluid position-relative">
        <button-info></button-info>
        <div
            class="d-flex flex-column align-items-center position-absolute top-0 start-0 m-1 z-3"
        >
            <a
                class="btn-show border border-2"
                :href="route('guest.select.show', { data: data.data })"
            >
                <i class="fa-solid fa-chevron-left fs-3"></i>
            </a>
        </div>
        <ApplicationLogo
            class="position-absolute table-logo animated animate__fadeInUp"
        />
        <div class="row table-row position-relative animated animate__fadeInUp">
            <div
                class="table shadow d-flex align-items-center justify-content-center"
            >
                <a
                    v-if="
                        store.prenotations.some(
                            (item) => item.justoCompiled === true
                        )
                    "
                    :href="route('guest.prenotation', { data: data })"
                    class="btn-show text-uppercase fs-3"
                    >prenota</a
                >
            </div>
            <div v-for="(chair, index) in store.prenotations" :key="index">
                <!-- Modal Button-->
                <button
                    type="button"
                    class="chair btn-show border border-2 shadow"
                    :class="
                        isJustPrenotated.some(
                            (posto) => posto === chair.n_posto
                        )
                            ? 'border-danger my-blur'
                            : 'border'
                    "
                    :id="'chair_' + chair.n_posto"
                    data-bs-toggle="modal"
                    :data-bs-target="'#prenotationModal' + '-' + index"
                    :disabled="
                        isJustPrenotated.some(
                            (posto) => posto === chair.n_posto
                        )
                    "
                >
                    {{ chair.n_posto }}
                    <p
                        v-if="
                            isJustPrenotated.some(
                                (posto) => posto === chair.n_posto
                            )
                        "
                    >
                        <i class="fa-solid fa-x"></i>
                    </p>
                    <p
                        v-if="chair.nome"
                        class="position-absolute top-0 start-50 translate-middle-x"
                    >
                        {{ chair.nome }}
                    </p>
                </button>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div
        v-for="(chair, index) in store.prenotations"
        :key="index"
        class="modal fade"
        :id="'prenotationModal' + '-' + index"
        tabindex="-1"
        :aria-labelledby="'prenotationModalLabel' + '-' + index"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h1
                        class="modal-title fs-2"
                        :id="'prenotationModalLabel' + '-' + index"
                    >
                        Posto n° {{ chair.n_posto }}
                    </h1>
                    <button
                        :id="'closeButtonModal' + '-' + index"
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <Form @submit="handleFormSubmit(index, chair)">
                        <div class="mb-2">
                            <p class="mb-0 me-3 fs-5">Nome*</p>
                            <Field
                                name="nome"
                                v-model="chair.nome"
                                :rules="validationRules.name"
                                class="form-control"
                            />
                            <ErrorMessage name="nome" class="text-danger" />
                        </div>
                        <div class="mb-2">
                            <p class="mb-0 me-3 fs-5">Cognome*</p>
                            <Field
                                name="cognome"
                                v-model="chair.cognome"
                                :rules="validationRules.lastName"
                                class="form-control"
                            />
                            <ErrorMessage name="cognome" class="text-danger" />
                        </div>
                        <div class="mb-2">
                            <p class="mb-0 me-3 fs-5">Email*</p>
                            <Field
                                name="email"
                                v-model="chair.email"
                                :rules="validationRules.email"
                                class="form-control"
                            />
                            <ErrorMessage name="email" class="text-danger" />
                        </div>
                        <div class="mb-2">
                            <p class="mb-0 me-3 fs-5">Telefono*</p>
                            <Field
                                name="n_telefono"
                                v-model="chair.n_telefono"
                                :rules="validationRules.telefono"
                                class="form-control"
                            />
                            <ErrorMessage
                                name="n_telefono"
                                class="text-danger"
                            />
                        </div>
                        <div
                            class="d-flex align-items-center justify-content-center"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-title="Scegliendo di iscriverti alla nostra newsletter vogliamo assicurarti che rispettiamo la tua privacy. I tuoi dati personali saranno utilizzati esclusivamente da Villa-Albertina.it per inviarti aggiornamenti sui nostri spettacoli e offerte speciali. Non condivideremo né venderemo mai i tuoi dati a terze parti. Puoi annullare l'iscrizione in qualsiasi momento."
                        >
                            <Field
                                type="checkbox"
                                name="newsletter"
                                v-model="chair.newsletter"
                                class="form-check-input"
                            />
                            <label class="form-check-label" for="newsletter"
                                >Rimani aggiornato alla newsletter</label
                            >
                        </div>
                        <div class="d-flex justify-content-center">
                            <button
                                type="submit"
                                class="btn-show btn-insert border border-2"
                            >
                                {{
                                    store.prenotations[index].justoCompiled
                                        ? "Modifica"
                                        : "Aggiungi"
                                }}
                            </button>
                        </div>
                    </Form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { onMounted } from "vue";
import { generalStore } from "@/Stores/state";
import { usePage } from "@inertiajs/vue3";
import * as bootstrap from "bootstrap";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Form, Field, ErrorMessage, defineRule } from "vee-validate";
import getValidationRules from "@/validation-rules";
import { useI18n } from "vue-i18n";

const { t } = useI18n();

const page = usePage();
const data = computed(() => page.props.data);
const store = generalStore();

const isJustPrenotated = computed(() => {
    return data.value.bookings.map((booking) => booking.posto);
});

onMounted(() => {
    store.setPrenotationsPrice(data.value.prezzo);
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

const handleFormSubmit = (index, chair) => {
    if (store.prenotations[index].justoCompiled) {
        store.addInPrenotation(chair);
    } else {
        store.prenotations[index].justoCompiled = true;
        store.addInPrenotation(chair);
    }

    closeModal(index);
};

const closeModal = (index) => {
    const closeButtonModal = document.getElementById(
        "closeButtonModal" + "-" + index
    );
    closeButtonModal.click();
};

const validationRules = getValidationRules(t);

// Definisci le regole di vee-validate utilizzando le regole di validazione
Object.keys(validationRules).forEach((ruleName) => {
    defineRule(ruleName, validationRules[ruleName]);
});
</script>

<style scoped>
.table-logo {
    top: 0;
    right: 0;
    /* transform: translateX(-50%); */
    width: 220px;
    height: 220px;
    z-index: 4;
}

.table-row {
    height: calc(100vh - 50px);
}
.table {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80vw;
    height: 40vh;
    border-radius: 20%;
    background-color: #3f2626;
    z-index: 1;
}
.chair {
    cursor: pointer;
    position: absolute;
    height: 85px;
    width: 85px;
    border-radius: 10px;
    z-index: 2;
}
.chair:hover {
    height: 85px;
    width: 85px;
    transition-duration: 0.3s;
}
#chair_1 {
    left: 2%;
    top: 50%;
    transform: translateY(-50%);
}
#chair_2 {
    left: calc(80vw / 3);
    top: 22%;
    transform: translateY(-22%);
}
#chair_3 {
    left: 50%;
    top: 22%;
    transform: translate(-50%, -22%);
}
#chair_4 {
    right: calc(80vw / 3);
    top: 22%;
    transform: translateY(-22%);
}
#chair_5 {
    right: 2%;
    top: 50%;
    transform: translateY(-50%);
}
#chair_6 {
    right: calc(80vw / 3);
    bottom: 20%;
}
#chair_7 {
    left: 50%;
    bottom: 20%;
    transform: translateX(-50%);
}
#chair_8 {
    left: calc(80vw / 3);
    bottom: 20%;
}

@media (max-width: 992px) {
    .table-logo {
        display: none !important;
    }
    .table {
        height: 25vh;
    }
    .chair {
        height: 70px;
        width: 70px;
    }
    #chair_1 {
        border-radius: 25%;
        left: 2%;
        top: 50%;
        transform: translateY(-50%);
    }

    #chair_2 {
        border-radius: 25%;
        left: calc((80vw / 3) - 40px);
        top: 35%;
        transform: translateY(-35%);
    }
    #chair_3 {
        border-radius: 25%;
        left: 50%;
        top: 35%;
        transform: translate(-50%, -35%);
    }
    #chair_4 {
        border-radius: 25%;
        right: calc((80vw / 3) - 40px);
        top: 35%;
        transform: translateY(-35%);
    }
    #chair_5 {
        border-radius: 25%;
        right: 2%;
        top: 50%;
        transform: translateY(-50%);
    }
    #chair_6 {
        right: calc((80vw / 3) - 40px);
        bottom: 32%;
        border-radius: 25%;
    }
    #chair_7 {
        left: 50%;
        bottom: 32%;
        border-radius: 25%;
        transform: translateX(-50%);
    }
    #chair_8 {
        left: calc((80vw / 3) - 40px);
        bottom: 32%;
        border-radius: 25%;
    }
}
</style>
