<template>
    <div v-if="loading" class="load-container">
        <div class="pen-writing-animation">
            <div>
                <h1 id="typed-output"></h1>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
import Typed from "typed.js";
const props = defineProps({
    loading: Boolean,
});

const typedOption = {
    strings: ["Villa Albertina HR ..."],
    typeSpeed: 35,
    backSpeed: 20,
    showCursor: true,
    cursorChar: "",
    loop: true,
};
onMounted(() => {
    if (props.loading) {
        new Typed("#typed-output", typedOption);
    }
});
</script>

<style lang="scss">
.load-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 99;
    background: rgba(255, 255, 255, 0.9);
}
</style>
