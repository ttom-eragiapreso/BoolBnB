<script>
import {store} from '../data/store';

export default {
    name: 'SliderItem',
    data(){
        return{
            store
        }
    },
    props:{
        item: Object
    },
    methods:{
        handleClick(){
            if(this.store.filtered_type == this.item.id){
                this.store.filtered_type = null;
            } else {
                this.store.filtered_type = this.item.id
            }
        }
    }
}
</script>

<template>

    <div class=" cursor-pointer flex flex-col text-lg items-center mx-8 pt-5 pb-2  hover:text-slate-700 transition duration-300 hover:ease-in border-b-4 hover:border-gray-400" @click="handleClick()" :class="this.store.filtered_type == item.id ? 'text-black border-black' : 'text-slate-500  border-transparent'">
        <i :class=" item.icon "></i>
        <span class="inline-block mt-1 font-bold">{{ item.name }}</span>
    </div>

</template>

<style scoped lang="scss">

@import '../../../node_modules/@fortawesome/fontawesome-free/css/all.min.css';

i{
    font-size: 1.2rem;
}
span{
    font-size: 0.8rem;
    white-space: nowrap;
}
</style>
