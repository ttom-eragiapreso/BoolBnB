<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, Head } from "@inertiajs/vue3";

import Chart from '@/Components/Chart.vue';

export default {
    name: 'Stats',
    components:{
        Head,
        Link,
        Chart,
        AuthenticatedLayout
    },
    props:{
        data_views: Object,
        data_messages: Object,
        slug: String,
    },
    methods:{
        handleCreateDate(el) {
            const date = new Date(el);
            return date.toLocaleDateString('en-US');
        },
    },
    created(){

        let end = new Date();
        let start = new Date(Date.now() - 7 * 24 * 60 * 60 * 1000);
        let dateArray = [];
        for (let d = start; d <= end; d.setDate(d.getDate() + 1)) {
            dateArray.push(new Date(d).toLocaleDateString('en-US'));
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

        <div v-if="data_views.length != 0 || data_messages.length != 0">
            <div v-if="data_views.length != 0" class="p-6 mt-12 max-w-[78rem] min-h-[50vh] mx-auto sm:px-6 lg:px-8 bg-white rounded-xl my-4">

                <Chart :my_data="data_views" yname="Views" :slug="this.slug" />

            </div>


            <div v-if="data_messages.length != 0" class="p-6 mt-12 max-w-[78rem] min-h-[50vh] mx-auto sm:px-6 lg:px-8 bg-white rounded-xl my-4">

                <Chart :my_data="data_messages" yname="Messages" :slug="this.slug" />

            </div>
        </div>

        <div v-else class="p-6 mt-12 max-w-[78rem] mx-auto sm:px-6 lg:px-8 bg-white rounded-xl my-4 flex items-center justify-between">
            <p>
                On this page you will see your statistics about your apartments. List your first apartment and/or wait to have some data!
            </p>
            <Link
                :href="route('dashboard.apartment.create')"
                class="px-3 py-2 bg-green-600 border border-transparent rounded-md font-bold text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 text-sm"
                >here!</Link
            >
        </div>


    </AuthenticatedLayout>
</template>

<style>

</style>
