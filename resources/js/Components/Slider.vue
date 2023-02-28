<script>

import SliderItem from './SliderItem.vue';
import { Link } from "@inertiajs/vue3";


export default {
    name: 'Slider',
    components: {
        SliderItem,
        Link
    },
    props:{
        types_of_stay: Array
    },
    data(){
      return {
        scroll_positionX: 0,
        scroll_positionY: 0
      }

    },
    methods: {
        scroll_left() {
        let content = document.querySelector(".wrapper-box");
        content.scrollLeft -= 400;
        },
        scroll_right() {
        let content = document.querySelector(".wrapper-box");
        content.scrollLeft += 400;
        },
        scrollHandle() {
        let content = document.querySelector(".wrapper-box");
        this.scroll_positionX = content.scrollLeft;
        return this.scroll_positionX
        },
        shadowHandle(){

            this.scroll_positionY = window.scrollY;
        },
    },
    mounted(){

        window.addEventListener('scroll', this.shadowHandle)
    },
    computed: {
  showPart() {
    if(this.$page.url.includes('/advanced-search')){
        return false
    }else{
        return true
    }
  }
}

}

</script>

<template>
    <div class="bg-white lg:px-20 sm:px-8 wrapper fixed top-[80px] right-0 z-10 w-screen flex items-center" :class="{'shadow': this.scroll_positionY > 15}">

        <div class="flex relative  w-full" :class="{'content-wrap': showPart}">
            <div class="btn-wrap-l sm:flex hidden absolute z-10 left-0" v-if="this.scroll_positionX > 30">
                <button @click="scroll_left"><i class="fa-solid fa-chevron-left"></i></button>
            </div>
            <div @scroll="scrollHandle()" class="flex wrapper-box hide-scroll w-screen overflow-auto">
                <SliderItem :item="{icon: 'fa-solid fa-mountain-city', name: 'All Types', id: null}"/>
                <SliderItem  v-for="item in types_of_stay" :item="item" :key="item.id"/>
                <SliderItem  v-for="item in types_of_stay" :item="item" :key="item.id"/>
            </div>
            <div class="sm:flex hidden btn-wrap-r absolute z-10 right-0">

                <button class="sm:block hidden" @click="scroll_right"><i class="fa-solid fa-chevron-right z-20"></i></button>
            </div>


        </div>
    <Link
        v-if="showPart"
        :href="route('advancedsearch')"
        class="sm:inline-block hidden h-full w-[80px] border ml-[20px] text-sm rounded-xl border-slate-300 py-2 my-2 text-center hover:bg-slate-100 bg-white ">
        <i class="fa-solid fa-sliders"></i> Filters
    </Link>
    </div>
</template>

<style scoped lang="scss">

.content-wrap{
    @media (min-width: 640px){
        width: calc(100% - 100px);

    }
}

.shadow{
    box-shadow: rgba(33, 35, 38, 0.1) 0px 12px 5px -10px;
}

.hide-scroll::-webkit-scrollbar {
    display: none;
  }

.hide-scroll{
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
    scroll-behavior: smooth;

}

button {
  border: 1px solid lightgray;
  border-radius: 50%;
  height: 28px;
  width: 28px;
  line-height: 28px;

  transition: all 300ms;
  &:hover{
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    scale: 1.05;

  }
}

.btn-wrap-l{

  align-items: center;
  height: 100%;
  padding-right: 50px;
  background: rgb(255,255,255);
background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 55%, rgba(255,255,255,0.9) 70%, rgba(255,255,255,0.7) 85%, rgba(255,255,255,0) 100%);
}

.btn-wrap-r{

  align-items: center;

  height: 100%;
  padding-left:50px;
  background: rgb(255,255,255);
background: linear-gradient(270deg, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 55%, rgba(255,255,255,0.9) 70%, rgba(255,255,255,0.7) 85%, rgba(255,255,255,0) 100%);
}

</style>
