<template>
    <div class="alert alert-dismissible fade show" :class="message.class" role="alert">
        <strong> {{ message.message }} </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</template>

<script>
export default {
    name: 'Message',
    props: {
        message: Object,
    }
}
</script>

<style>

</style>
