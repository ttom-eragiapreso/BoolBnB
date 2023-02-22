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

        <div class=" mt-[180px] py-4 flex gap-4 flex-wrap">
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
