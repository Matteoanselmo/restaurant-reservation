<template>
    <Link :href="route('home')">
        <img
            src="/images/logo/logo.png"
            class="position-fixed top-0 start-0 rounded m-2"
        />
    </Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<style lang="scss" scoped>
img {
    height: 100px;
}
@media screen and (max-width: 767px) {
    img {
        height: 45px;
    }
}
</style>
