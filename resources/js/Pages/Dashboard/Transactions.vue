<script>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

export default {
    name: "Transactions",
    props:{
        user_apartments: Array
    },
    components: {
        AuthenticatedLayout,
        Head,
    },
    methods:{
        handleDate(date) {
            const data = new Date(date);
            return new Intl.DateTimeFormat('it-IT', { dateStyle: 'short', timeStyle: 'short'}).format(data)
        }
    }
};

</script>

<template>
    <Head title="Transactions" />

    <AuthenticatedLayout>

        <template v-slot:header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Transactions history
            </h2>
        </template>

        <div class="py-6 mt-12 max-w-[76rem] mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4 text-center">

            <table class="w-full">
                <thead>
                    <tr>
                        <th class="px-3">Type of Plan</th>
                        <th>Target</th>
                        <th class="px-3">Amount</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Date of transaction</th>
                    </tr>
                </thead>
                <div class="table-row-group" v-for="apartment in user_apartments" :key="apartment.slug">
                    <tr v-for="sponsor in apartment.sponsorships" :key="sponsor.id">
                        <td class="table-cell text-left">Sponsorship - {{ sponsor.name }}</td>
                        <td class="table-cell text-left">{{ apartment.title }}</td>
                        <td class="table-cell text-left">{{ sponsor.price }} &euro;</td>
                        <td class="table-cell text-left">{{ handleDate(sponsor.pivot.start) }}</td>
                        <td class="table-cell text-left">{{ handleDate(sponsor.pivot.end) }}</td>
                        <td class="table-cell text-left">{{ handleDate(sponsor.created_at) }}</td>
                    </tr>
                </div>
            </table>

        </div>

    </AuthenticatedLayout>
</template>

<style>

table {
  border-collapse: collapse;
}

table th{
    padding-bottom: 10px;
    position: relative;
}

table th::before{
    content: '';
    width: 100%;
    background-color: rgb(80, 80, 80);
    height: 2px;
    position: absolute;
    bottom: 0;
    left: 0;
}

table td {
    padding: 20px;
    position: relative;
}

table td:not(:last-of-type)::after, table th:not(:last-of-type)::after{
    content: '';
    height: 100%;
    background-color: rgb(80, 80, 80);
    width: 2px;
    position: absolute;
    top: 0;
    right: 0;
}

</style>
