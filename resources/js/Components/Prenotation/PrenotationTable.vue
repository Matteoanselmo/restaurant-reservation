<template>
    <div class="row position-relative">
        <div class="table shadow">
        </div>
        <button type="button" class="chair btn-show border border-2 dropdown-toggle" id="chair_1" data-bs-toggle="drop_chair_1" aria-expanded="false">1</button>
        <ul class="dropdown-menu" aria-labelledby="chair_1">
            <li><button class="dropdown-item" type="button">Action</button></li>
            <li><button class="dropdown-item" type="button">Another action</button></li>
            <li><button class="dropdown-item" type="button">Something else here</button></li>
        </ul>
        <button type="button" class="chair btn-show border border-2" id="chair_2">2</button>
        <button type="button" class="chair btn-show border border-2" id="chair_3">3</button>
        <button type="button" class="chair btn-show border border-2" id="chair_4">4</button>
        <button type="button" class="chair btn-show border border-2" id="chair_5">5</button>
        <button type="button" class="chair btn-show border border-2" id="chair_6">6</button>
        <button type="button" class="chair btn-show border border-2" id="chair_7">7</button>
        <button type="button" class="chair btn-show border border-2" id="chair_8">8</button>
    </div>
</template>

<script>
export default {
    name:'PrenotationTable'
}
</script>

<style scoped>
.row{
    height: calc(100vh - 50px);
}
.table{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80vw;
    height: 40vh;
    border-radius: 20%;
    background-color: grey;
    z-index: 1;
}
.chair{
    cursor: pointer;
    position: absolute;
    height: 70px;
    width: 70px;
    border-radius: 10px;
    z-index: 2;
}
.chair:hover{
    height: 85px;
    width: 85px;
    transition-duration: .3s ;
}
#chair_1{
    left: 2%;
    top: 50%;
    transform: translateY(-50%);
}
#chair_2{
    left: calc(80vw / 3);
    top: 22%;
    transform: translateY(-22%);
}
#chair_3{
    left: 50%;
    top: 22%;
    transform: translate(-50%, -22%);
}
#chair_4{
    right: calc(80vw / 3);
    top: 22%;
    transform: translateY(-22%);
}
#chair_5{
    right: 2%;
    top: 50%;
    transform: translateY(-50%);
}
#chair_6{
    right: calc(80vw / 3);
    bottom: 20%;
}
#chair_7{
    left: 50%;
    bottom: 20%;
    transform: translateX(-50%);
}
#chair_8{
    left: calc(80vw / 3);
    bottom: 20%;
}
</style>
