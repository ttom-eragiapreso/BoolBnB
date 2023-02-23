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
        <div
            v-if="$page.props.flash.message"
            class="container py-6 max-w-[76rem] mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl mt-[180px] mb-[-32px] flex justify-between items-center"
        >
            <h5 class="align-middle font-semibold text-red-600">
                {{ $page.props.flash.message }}
            </h5>
        </div>

        <div class=" w-full px-6 sm:px-6 lg:px-8 mt-[180px] py-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">
            <Card
                v-for="apartment in apartments"
                :key="apartment.id"
                :apartment="apartment"
                class="w-auto justify-self-center mb-8"
            />
        </div>
    </GuestLayout>
</template>

<style></style>
