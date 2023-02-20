<script>
import GuestLayout from "@/Layouts/GuestLayout.vue";
export default {
    name: "Details",
    components: {
        GuestLayout,
    },
    props: {
        apartment: Object,
    },
};
</script>

<template>
    <GuestLayout>
        <h1>Details</h1>
    </GuestLayout>
</template>

<style></style>
