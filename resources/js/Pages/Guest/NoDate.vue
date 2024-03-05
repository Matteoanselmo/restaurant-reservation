<template>
    <div class="container-fluid">
        <button-info></button-info>
        <div
            class="full-screen row justify-content-center align-items-center position-relative"
        >
            <ApplicationLogo />
            <img
                src="/images/logo/logo.png"
                class="position-absolute top-50 start-50 translate-middle w-50 h-50"
                style="filter: blur(6px) opacity(0.5)"
            />
            <div class="col-7">
                <h1
                    class="text-center position-absolute top-50 start-50 translate-middle"
                >
                    {{ $t("no_date.text") }}
                    <span class="text-capitalize">{{ formattedDate }}</span>
                </h1>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { useI18n } from "vue-i18n"; // Assicurati di importare useI18n se stai utilizzando vue-i18n
import { usePage } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const { locale } = useI18n(); // Ottieni il locale corrente da vue-i18n
const page = usePage();
const data = computed(() => page.props.data);

const formattedDate = computed(() => {
    const options = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
    };
    return new Date(data.value).toLocaleDateString(locale.value, options);
});
</script>

<style></style>
