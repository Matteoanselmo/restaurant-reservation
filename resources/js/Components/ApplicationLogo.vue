<template>
    <Link :href="route('home')">
        <img
            src="/images/logo/logo.png"
            class="position-fixed top-0 start-0"
            style="height: 100px"
        />
    </Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<style></style>
