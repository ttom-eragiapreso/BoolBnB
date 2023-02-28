<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

import Chart from '@/Components/Chart.vue';

export default {
    name: 'Stats',
    components:{
        Head,
        Chart,
        AuthenticatedLayout
    },
    props:{
        data: Object
    },
    methods:{
        handleCreateDate(el) {
            const date = new Date(el);
            return date.toLocaleDateString("it-IT", { dateStyle: "short" });
        },
    },
    created(){

        for(let apartment in this.data){
           this.data[apartment].forEach(element => {
            element['date'] = this.handleCreateDate(element['date'])
           });
        }

    }

}



</script>

<template>
    <Head title="Statistics" />
    <AuthenticatedLayout>

<template v-slot:header>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Statistics
    </h2>
</template>

<div class="py-6 mt-12 max-w-[76rem] min-h-[50vh] mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4">

<Chart :my_data="data"  />

</div>

</AuthenticatedLayout>
</template>

<style>

</style>
