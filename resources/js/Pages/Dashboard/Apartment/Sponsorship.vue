<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { store } from "@/data/store";
import Payment from "@/Components/Payment.vue";

export default {
    name: "Sponsorship",
    data() {
        return {
            showModal: false,
            store
        };
    },
    components: {
        AuthenticatedLayout,
        Head,
        Payment,
    },
    computed:{
        handleModal(){
            return this.showModal;
        }
    }
};
</script>

<template>
    <Head title="Sponsorship" />

    <AuthenticatedLayout>
        <template v-slot:header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sponsorships
            </h2>
        </template>

        <div class="py-6 mt-12 max-w-[76rem] mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4">
            <button @click="showModal = true">Proceed to checkout</button>
            <Payment/>
        </div>

    </AuthenticatedLayout>
</template>

<style></style>
