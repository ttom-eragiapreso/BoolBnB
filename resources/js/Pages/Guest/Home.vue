<script>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Slider from '@/Components/Slider.vue';

export default {
    name: 'Home',
    components: {
        GuestLayout,
        Slider
    },
    props:{
        types_of_stay: Array
    }
}
</script>

<template>

    <GuestLayout>

        <h1>home</h1>
        <Slider :types_of_stay="types_of_stay" />
    </GuestLayout>

</template>

<style>

</style>
