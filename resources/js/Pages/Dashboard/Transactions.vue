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
        },
        checkIfAnyTransaction(){
            let flag = false;
            this.user_apartments.forEach(apartment => {
                console.log(apartment.sponsorships.length)
                if(apartment.sponsorships.length > 0){
                    flag = true;
                }
            });
            return flag
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

        <div class="p-2 mt-12 max-w-[76rem] overflow-x-auto rounded-xl mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4 text-center">

            <table class="w-full" v-if="checkIfAnyTransaction()">
                <thead>
                    <tr>
                        <th class="px-3">Type of Plan</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Target</th>
                        <th class="px-3">Amount</th>
                        <th>Date of transaction</th>
                    </tr>
                </thead>
                <div class="table-row-group" v-for="apartment in user_apartments" :key="apartment.slug">
                    <tr v-for="sponsor in apartment.sponsorships" :key="sponsor.id">
                        <td class="table-cell text-left">Sponsorship - {{ sponsor.name }}</td>
                        <td class="table-cell text-left">{{ handleDate(sponsor.pivot.start) }}</td>
                        <td class="table-cell text-left">{{ handleDate(sponsor.pivot.end) }}</td>
                        <td class="table-cell text-left">{{ apartment.title }}</td>
                        <td class="table-cell text-left">{{ sponsor.price }} &euro;</td>
                        <td class="table-cell text-left">{{ handleDate(sponsor.created_at) }}</td>
                    </tr>
                </div>
            </table>

            <div v-else class="py-3">No transactions have been made so far.</div>

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
