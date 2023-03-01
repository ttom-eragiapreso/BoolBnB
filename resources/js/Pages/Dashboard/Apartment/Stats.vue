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
        data_views: Object,
        data_messages: Object
    },
    methods:{
        handleCreateDate(el) {
            const date = new Date(el);
            return date.toLocaleDateString();
        },
    },
    created(){

        let end = new Date();
        let start = new Date(Date.now() - 7 * 24 * 60 * 60 * 1000);
        let dateArray = [];
        for (let d = start; d <= end; d.setDate(d.getDate() + 1)) {
            dateArray.push(new Date(d).toLocaleDateString());
        }

        for(let apartment in this.data_views){
           this.data_views[apartment].forEach(element => {
            element['date'] = this.handleCreateDate(element['date'])
           });
           dateArray.forEach(date => {
                let exists = false;
                this.data_views[apartment].forEach(obj => {
                    if (obj.date === date) {
                    exists = true;
                }
                });
                if (!exists) {
                    this.data_views[apartment].push({ date: date, total: 0 });
                }
            });

            this.data_views[apartment].sort((a, b) => {
                let dateA = new Date(a.date);
                let dateB = new Date(b.date);
                return dateA - dateB;
            });
        }

        for(let apartment in this.data_messages){
           this.data_messages[apartment].forEach(element => {
           element['date'] = this.handleCreateDate(element['date'])
           });
           dateArray.forEach(date => {
                let exists = false;
                this.data_messages[apartment].forEach(obj => {
                    if (obj.date === date) {
                    exists = true;
                }
                });
                if (!exists) {
                    this.data_messages[apartment].push({ date: date, total: 0 });
                }
            });

            this.data_messages[apartment].sort((a, b) => {
                let dateA = new Date(a.date);
                let dateB = new Date(b.date);
                return dateA - dateB;
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

<div class="p-6 mt-12 max-w-[78rem] min-h-[50vh] mx-auto sm:px-6 lg:px-8 bg-white rounded-xl my-4">

    <Chart :my_data="data_views"  />

</div>

<div class="p-6 mt-12 max-w-[78rem] min-h-[50vh] mx-auto sm:px-6 lg:px-8 bg-white rounded-xl my-4">

    <Chart :my_data="data_messages"  />

</div>

</AuthenticatedLayout>
</template>

<style>

</style>
