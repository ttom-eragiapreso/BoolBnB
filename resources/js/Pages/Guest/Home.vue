<script>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Slider from "@/Components/Slider.vue";
import Card from "@/Components/Card.vue";

export default {
    name: "Home",
    components: {
        GuestLayout,
        Slider,
        Card,
    },
    props: {
        types_of_stay: Array,
        apartments: Array,
    },
};
</script>

<template>
    <GuestLayout>
        <Slider :types_of_stay="types_of_stay" />

        <div class=" py-4 flex gap-4 flex-wrap">
            <Card
                v-for="apartment in apartments"
                :key="apartment.id"
                :apartment="apartment"
                class="w-auto"
            />
        </div>
    </GuestLayout>
</template>

<style></style>
