<template>
    <h1>Ciao Houses</h1>
    <h2>{{ message }}</h2>
    <Link :href="route('prova')" :data="{ message: 'ciao' }"> Prova </Link>
    <!-- <Card /> -->
</template>

<script>
import { Link } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";

export default {
    props: {
        message: String,
    },
    components: {
        Link,
    },
    layout: GuestLayout
};
</script>

<!-- <script setup>
import { Link } from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";

let props = defineProps({
    message: String,
});
</script> -->
