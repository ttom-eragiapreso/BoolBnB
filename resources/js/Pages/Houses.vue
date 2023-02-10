<template>
    <h1>Ciao Houses</h1>
    <h2>{{ message }}</h2>
    <Link :href="route('prova')" :data="{ message: 'ciao' }"> Prova </Link>
</template>

<!-- <script>
import { Link } from "@inertiajs/vue3";
export default {
    props: {
        message: String,
    },
    components: {
        Link,
    },
};
</script> -->

<script setup>
import { Link } from "@inertiajs/vue3";

let props = defineProps({
    message: String,
});
</script>
