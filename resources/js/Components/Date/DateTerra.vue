<template>
    <div>
        <div>
            <button class="btn-show" @click="scrollToSection('terra-show')">
                <i class="fa-solid fa-chevron-up  fs-3" ></i>
            </button>
            <h1>
                Date di terra
            </h1>
        </div>
    </div>
</template>

<script>
export default {
    name: 'DateTerra',
    methods: {
        scrollToSection(sectionId) {
            const targetSection = document.getElementById(sectionId);

            if (targetSection) {
                targetSection.scrollIntoView({ behavior: 'smooth' });
            }
        }
    }
}
</script>

<style>

</style>
