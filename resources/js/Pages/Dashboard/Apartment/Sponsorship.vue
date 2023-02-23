<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

export default {
    name: 'Sponsorship',
    components:{
        AuthenticatedLayout,
        Head
    }
}
</script>

<template>

    <Head title="Sponsorship" />

    <AuthenticatedLayout>

        <template v-slot:header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sponsorships
            </h2>
        </template>

        <div class="py-6 mt-12 max-w-[76rem] mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4" >
            <h1>Sponsorship</h1>
        </div>

    </AuthenticatedLayout>

</template>

<style>

</style>
