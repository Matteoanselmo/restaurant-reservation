<template>
    <div>
        <button class="btn-show fs-3" @click="checkout()">paga</button>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    setup(){
        const checkout = function(){
            axios.post('/api/payment/initiate')
            .then((res) => {
                console.log(res)
            })
            .catch((e) => {
                console.error(e)
            })
        }

        return {
            checkout
        }
    }
}
</script>

<style>

</style>
