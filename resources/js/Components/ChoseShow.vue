<template>
    <div class="d-flex flex-column justify-content-between py-3">
        <div></div>
        <div>
            <button class="btn-show mx-5" v-for="(show, index) in allShow" :key="index">
                {{ show }}
            </button>
            <span class="backdrop"></span>
        </div>
        <div>
            <a class="fs-4" href="#">Hai una attività ?</a>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ChoseShow',
    data() {
        return{
            allShow: [
                'mare',
                'special',
                'terra'
            ]
        }
    }
}
</script>

<style scoped>
.btn-show {
position: relative;
font-size: 17px;
text-transform: uppercase;
text-decoration: none;
padding: 1em 2.5em;
display: inline-block;
border-radius: 6em;
transition: all .2s;
border: none;
font-family: inherit;
font-weight: 500;
color: black;
background-color: white;
}

.btn-show:hover {
transform: translateY(-3px);
box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.btn-show:active {
transform: translateY(-1px);
box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
}

.btn-show::after {
content: "";
display: inline-block;
height: 100%;
width: 100%;
border-radius: 100px;
position: absolute;
top: 0;
left: 0;
z-index: -1;
transition: all .4s;
}

.btn-show::after {
background-color: #fff;
}

.btn-show:hover::after {
transform: scaleX(1.4) scaleY(1.6);
opacity: 0;
}

</style>
