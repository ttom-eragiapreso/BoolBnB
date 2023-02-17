<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CardDashboard from "@/Components/CardDashboard.vue";
import { Link } from "@inertiajs/vue3";

export default {
    name: "Index",
    components: {
        CardDashboard,
        AuthenticatedLayout,
        Link,
    },
    props: {
        user_apartments: Array,
    },
};
</script>

<template>
    <AuthenticatedLayout>
        <template v-slot:header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Your Apartments
            </h2>
        </template>

        <div class="py-12" v-if="user_apartments.length > 0">
            <div
                class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-2"
                v-for="apartment in user_apartments"
                :key="apartment.id"
            >
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-4"
                >
                    <CardDashboard :apartment="apartment" />
                </div>
            </div>
        </div>
        <div v-else class="container mx-auto py-12">
            <p class="text-2xl">
                List your first apartment
                <Link
                    :href="route('dashboard.apartment.create')"
                    class="px-2 py-1 bg-amber-600 border border-transparent rounded-md font-bold text-white uppercase tracking-widest hover:bg-amber-500 focus:bg-amber-500 active:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >here!</Link
                >
            </p>
        </div>
    </AuthenticatedLayout>
</template>

<style></style>
