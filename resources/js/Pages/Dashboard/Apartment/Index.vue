<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CardDashboard from "@/Components/CardDashboard.vue";
import { Link, Head } from "@inertiajs/vue3";

export default {
    name: "Index",
    components: {
        CardDashboard,
        AuthenticatedLayout,
        Link,
        Head
    },
    props: {
        user_apartments: Array,
    },
};
</script>

<template>

    <Head title="Apartments" />

    <AuthenticatedLayout>

        <template v-slot:header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Your Apartments
            </h2>
        </template>

        <div class="py-12" v-if="user_apartments.length > 0">
            <div
                class="max-w-7xl mx-4 md:mx-auto md:px-6 lg:px-8 pb-6"
                v-for="apartment in user_apartments"
                :key="apartment.id"
            >
                <div class="bg-white overflow-hidden shadow-sm rounded-xl sm:rounded-2xl p-4 hover:shadow-md">
                    <CardDashboard :apartment="apartment" />
                </div>
            </div>
        </div>

        <div v-else class="py-12">
            <div class="max-w-7xl mx-4 md:mx-auto md:px-6 lg:px-8 pb-6 bg-white overflow-hidden shadow-sm rounded-xl sm:rounded-2xl p-4 flex justify-between items-center">
                <p>
                    On this page you will see all your apartments. List your first apartment!
                </p>
                <Link
                    :href="route('dashboard.apartment.create')"
                    class="px-3 py-2 bg-green-600 border border-transparent rounded-md font-bold text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 text-sm"
                    >here!</Link
                >
            </div>
        </div>

    </AuthenticatedLayout>

</template>

<style></style>
