<script>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { store } from "@/data/store";
import Payment from "@/Components/Payment.vue";

export default {
    name: "Sponsorship",
    data() {
        return {
            showModal: false,
            showError: false,
            store,
            target: {
                apartment_id: null,
                sponsorship_id: null
            }
        };
    },
    props:{
        user_apartments: Array,
        sponsorships: Array,
        id: Number
    },
    components: {
        AuthenticatedLayout,
        Head,
        Payment,
    },
    methods:{
        checkInput(){
            this.showError = false;
            if(this.target.apartment_id != null && this.target.sponsorship_id != null){
                store.target.apartment_id = this.target.apartment_id;
                store.target.sponsorship_id = this.target.sponsorship_id;
                this.showModal = true;
            } else {
                this.showError = true;
            }
        },
        handleEmit(){
            this.showModal = false
        }
    },
    mounted(){
        this.target.apartment_id = this.id
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

        <div class="py-6 mt-12 max-w-[76rem] mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4 text-center">

            <p class="font-semibold text-lg">Sponsor your apartments to increase their visibility, choose the best plan for you:</p>

            <div class="flex w-full gap-6 my-8">
                <div v-for="sponsor in sponsorships" :key="sponsor.id" class="border-2 cursor-pointer p-6 rounded-3xl grow text-center" @click="target.sponsorship_id = sponsor.id" :class="target.sponsorship_id == sponsor.id ? 'border-green-700 shadow-lg bg-green-300/25' : 'shadow-sm'">
                    <h2 class="mb-2" :class="{'font-bold' : target.sponsorship_id == sponsor.id}">{{ sponsor.name.toUpperCase() }}</h2>
                    <p>Price: {{ sponsor.price }} &euro;</p>
                    <p>Length: {{ sponsor.length_hours }} hours</p>
                </div>
            </div>

            <div class="my-6" >
                <select name="sponsorship_select" id="sponsorships" v-model="target.apartment_id" class="rounded-lg focus:border-green-700 focus:ring-green-700">
                    <option value="null" selected disabled>Select an Apartment to sponsor</option>
                    <option v-for="apartments in user_apartments" :key="apartments.id" :value="apartments.id">{{ apartments.title }}</option>
                </select>
            </div>

            <button class="px-6 py-3 bg-green-500 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-green-400 focus:bg-green-400 active:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150 grow" @click="checkInput()">Proceed to checkout</button>

            <p v-show="showError" class="text-red-500 mt-4">Please, select one of your apartments and a payment plan.</p>
        </div>

        <div v-show="showModal" class="p-10 mt-12 max-w-[76rem] mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4">
            <Payment @closeMyself="handleEmit"/>
        </div>

    </AuthenticatedLayout>
</template>

<style></style>
