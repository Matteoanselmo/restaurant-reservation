<template>
    <div class="d-flex flex-column">
        <h1 class="text-uppercase mb-5">{{ $t("not_a_restourant.title") }}</h1>
        <div class="px-5">
            <h4 class="mb-3">
                {{ $t("not_a_restourant.capter_1") }}
            </h4>
            <h4>{{ $t("not_a_restourant.capter_2") }}</h4>
            <h4>
                {{ $t("not_a_restourant.capter_3") }}
            </h4>
        </div>
    </div>
</template>

<script>
export default {
    name: "NotARestaurant",
};
</script>

<style></style>
