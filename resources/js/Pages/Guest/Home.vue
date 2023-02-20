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
        <div class="px-8 lg:px-20 bg-white">
            <Slider :types_of_stay="types_of_stay" />
        </div>
    </GuestLayout>

</template>

<style>

</style>
