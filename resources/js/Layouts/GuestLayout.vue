<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>

    <Header/>


    <div class=" mt-[80px] min-h-screen pt-6 sm:pt-0 pb-10 bg-white">

    <div class="min-h-screen pt-6 sm:pt-0 bg-white">

            <slot />

    </div>

    </div>

    <Footer/>

</template>
