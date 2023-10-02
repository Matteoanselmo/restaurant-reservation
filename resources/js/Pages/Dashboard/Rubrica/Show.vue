<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>
                    {{ cliente.nome }} {{ cliente.cognome }}
                </h1>
            </div>
            <div class="col-12">
                <h3>
                    <a :href="'mailto:' + cliente.email">
                        {{ cliente.email }}
                    </a>
                </h3>
            </div>
            <div class="col-12">
                <h3>
                    <a :href="'tel:'+cliente.n_telefono">
                        {{ cliente.n_telefono }}
                    </a>
                </h3>
            </div>
        </div>
    </div>
</template>

<script>
import { computed, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
export default {
    name: 'RubricaShow',
    setup(){
        const page = usePage();
        const cliente = computed(() => page.props.cliente);

        return {
            cliente
        }
    }
}
</script>

<style>

</style>
