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
@media screen and (max-width: 1200px) {
    img {
        height: 45px;
    }
}
@media screen and (max-width: 768px) {
    img {
        height: 35px;
    }
}
@media screen and (max-width: 576px) {
    img {
        height: 25px;
    }
}
</style>
