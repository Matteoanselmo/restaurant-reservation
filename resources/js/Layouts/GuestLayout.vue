<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="position-relative">
        <div>
                <ApplicationLogo class="position-absolute top-50 start-50 translate-middle login-logo my-blur" style="z-index: -1;" />
        </div>

        <div
            class="position-absolute top-50 start-50 translate-middle"
        >
            <slot />
        </div>
    </div>
</template>

<style scoped>
.login-logo {
    height: 100%;
    object-position: center;
    object-fit: cover;
}
</style>
