<template>
    <div v-if="loading" id="loading-component" class="bg-light">
        <i class="fs-1 fa-solid fa-spinner"></i>
    </div>
</template>

<script>
export default {
    name: 'Loading',
    props: {
        loading: Boolean
    }
}
</script>

<style lang="scss" scoped>
    #loading-component{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        height: 100vh;
        width: 100vw;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
