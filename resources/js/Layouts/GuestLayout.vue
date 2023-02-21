<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>

    <Header/>


    <div class="min-h-screen pt-6 sm:pt-0 pb-10 bg-gray-100">

    <div class="min-h-screen pt-6 sm:pt-0 bg-white">


            <slot />

    </div>

    <Footer/>

</template>
