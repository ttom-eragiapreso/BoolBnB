<script>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CardDashboard from '@/Components/CardDashboard.vue';

export default {
    name: 'Index',
    components:{
        CardDashboard,
        AuthenticatedLayout
    },
    props:{
        user_apartments: Array
    }
}
</script>

<template>

    <AuthenticatedLayout>

        <template v-slot:header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Your Apartments</h2>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-2" v-for="apartment in user_apartments" :key="apartment.id">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-4">
                    <CardDashboard :apartment="apartment"/>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>

</template>

<style>

</style>
