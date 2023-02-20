<script>
export default {
    name: 'SliderItem',
    props:{
        item: Object
    }
}
</script>

<template>

    <div class=" cursor-pointer flex flex-col text-lg items-center mx-8 pt-5 pb-3 text-slate-500 hover:text-black transition duration-300 hover:ease-in">
        <i :class=" item.icon "></i>
        <span class="inline-block mt-1 font-bold">{{ item.name }}</span>
    </div>

</template>

<style scoped lang="scss">

@import '../../../node_modules/@fortawesome/fontawesome-free/css/all.min.css';

div{
    border-bottom: 2px solid transparent;
    &:hover{
        border-bottom-color: lightgray;
    }
}

i{
    font-size: 1.2rem;
}
span{
    font-size: 0.8rem;
    white-space: nowrap;
}
</style>
