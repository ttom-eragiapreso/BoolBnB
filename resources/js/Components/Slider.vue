<script>

import SliderItem from './SliderItem.vue';

export default {
    name: 'Slider',
    components: {
        SliderItem
    },
    props:{
        types_of_stay: Array
    },
    data(){
      return {
        scroll_position: 0,
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
      console.log(content.scrollLeft);
      this.scroll_position = content.scrollLeft;
      return this.scroll_position
    }
  },
}

</script>

<template>
  <div class="bg-white lg:px-20 sm:px-8 wrapper">

    <div class="flex relative">
      <div class="btn-wrap-l sm:flex hidden absolute z-10 left-0" v-if="this.scroll_position > 15">
        <button @click="scroll_left"><i class="fa-solid fa-chevron-left"></i></button>
      </div>
      <div @scroll="scrollHandle()" class="px-6 flex wrapper-box hide-scroll w-screen overflow-auto">

        <SliderItem  v-for="item in types_of_stay" :item="item" :key="item.id"/>
        <SliderItem  v-for="item in types_of_stay" :item="item" :key="item.id"/>
      </div>
      <div class="sm:flex hidden btn-wrap-r absolute z-10 right-0">

        <button class="sm:block hidden" @click="scroll_right"><i class="fa-solid fa-chevron-right z-20"></i></button>
      </div>

    </div>
  </div>
</template>

<style scoped lang="scss">

.wrapper{
    box-shadow: rgba(33, 35, 38, 0.1) 0px 10px 10px -10px;
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
