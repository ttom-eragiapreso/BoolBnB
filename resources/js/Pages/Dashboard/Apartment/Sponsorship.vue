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
        id: Number,
    },
    components: {
        AuthenticatedLayout,
        Head,
        Payment,
    },
    methods:{
        checkInput(){
            this.showError = false;
            if(this.target.apartment_id != null && this.target.sponsorship_id != null && this.checkCorrectOwner()){
                store.target.apartment_id = this.target.apartment_id;
                store.target.sponsorship_id = this.target.sponsorship_id;
                this.showModal = true;
            } else {
                this.showError = true;
            }
        },
        checkCorrectOwner(){
            return this.user_apartments.some((apartment) => {
                return apartment.id == this.target.apartment_id
            })
        }
    },
    mounted(){
        this.target.apartment_id = this.id
        store.isProcessing = false;
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

        <div v-show="!showModal" class="py-6 mt-12 max-w-[78rem] mx-auto px-4 sm:px-6 lg:px-8 bg-white rounded-xl my-4 text-center">

            <p class="font-semibold text-lg">Sponsor your apartments to increase their visibility, choose the best plan for you:</p>

            <div class="flex flex-wrap w-full gap-6 my-8 text-left">
                <div v-for="sponsor in sponsorships" :key="sponsor.id" class="border-4 p-6 rounded-3xl grow" :class="target.sponsorship_id == sponsor.id ? 'border-emerald-600' : 'shadow-sm'">
                    <h2 class="font-bold text-lg" :class="{'text-emerald-700' : target.sponsorship_id == sponsor.id}">{{ sponsor.name.toUpperCase() }}</h2>
                    <hr class="mb-2 mt-1">
                    <p><span class="text-slate-800">Price:</span> {{ sponsor.price }} &euro;</p>
                    <p><span class="text-slate-800">Length:</span> {{ sponsor.length_hours }} hours</p>
                    <div class="w-full flex justify-center user-select-none">
                        <button class="mt-6 px-3 py-2 cursor-pointer inline-block bg-emerald-500 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-emerald-400 focus:bg-emerald-400 active:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150" @click="target.sponsorship_id = sponsor.id">{{ target.sponsorship_id == sponsor.id ? 'Selected' : 'Select'}}</button>
                    </div>
                </div>
            </div>

            <div class="my-6" >
                <select name="sponsorship_select" id="sponsorships" v-model="target.apartment_id" class="rounded-lg focus:border-emerald-600 focus:ring-emerald-600">
                    <option value="null" selected disabled>Select an Apartment to sponsor</option>
                    <option v-for="apartments in user_apartments" :key="apartments.id" :value="apartments.id">{{ apartments.title }}</option>
                </select>
            </div>

            <a class="inline-block px-6 py-3 bg-blue-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-emerblueald-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 transition ease-in-out duration-150 grow" @click="checkInput()">Proceed to checkout</a>

            <p v-show="showError" class="text-red-500 mt-4">Please, select one of your apartments and a payment plan.</p>
        </div>

        <div id="payment" v-show="showModal" class="my-8">
            <Payment/>
        </div>

    </AuthenticatedLayout>
</template>

<style></style>
