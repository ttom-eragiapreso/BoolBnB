<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head } from '@inertiajs/vue3';

export default {
    name: 'Messages',
    data(){
        return{
            showModal: null,
            apartment_filter: null
        }
    },
    components: {
        AuthenticatedLayout,
        Head,
        Pagination
    },
    props:{
        messages: Object,
        apartments: Array,
        id: Number
    },
    methods:{
        handleDate(date) {
            const data = new Date(date);
            return new Intl.DateTimeFormat('it-IT', { dateStyle: 'short', timeStyle: 'short'}).format(data)
        },
        getApartmentTitle(id){
            return this.apartments.filter((apartment) => {
                return apartment.id == id
            })[0].title
        }
    },
    mounted(){
        this.apartment_filter = this.id;
        console.log(this.messages.data.length);
    }
}
</script>

<template>
    <Head title="Messages" />

    <AuthenticatedLayout>

        <template v-slot:header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Messages
            </h2>
        </template>

        <div v-if="messages.data.length != 0" class="p-6 mt-12 max-w-[95%] mx-auto sm:px-6 lg:px-8 bg-white rounded-xl my-4">
            <div class="flex my-4 items-center">
                <p class="mr-4">Filter per apartments: </p>
                <select v-model="apartment_filter" id="apartment_filter" class="rounded-2xl text-sm w-[100%] sm:w-[30%]">
                    <option :value="null" selected>All</option>
                    <option v-for="apartment in apartments" :key="apartment.id" :value="apartment.id">{{ apartment.title }}</option>
                </select>
            </div>
            <hr class="mt-3 mb-4">
            <div v-for="message in messages.data" :key="'msg' + message.id" v-show="message.apartment_id == apartment_filter || apartment_filter == null">

                <div class="md:grid md:grid-cols-[2fr_3fr_3fr_0.5fr] mb-4 items-center">
                    <h3 class="pb-2"><strong>From: </strong>{{ message.email }}</h3>
                    <h3 class="pb-2"><strong>To: </strong>{{ getApartmentTitle(message.apartment_id) }}</h3>
                    <h3 class="pb-2"><strong>Subjet: </strong>{{ message.name }}</h3>
                    <button @click="showModal = message.id" class="text-blue-500 bg-transparent border border-solid border-blue-500 hover:bg-blue-500 hover:text-white active:bg-blue-600 font-bold uppercase text-sm px-6 py-2 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">Show</button>
                </div>

                <hr class="mt-3 mb-4">

                <div v-if="showModal == message.id" class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
                    <div class="relative w-[50%] my-6 mx-auto max-w-6xl">
                        <!--content-->
                        <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                            <!--header-->
                            <div class="flex items-end justify-between p-5 border-b border-solid border-slate-200 rounded-t">
                                <h3 class="text-xl">
                                    <span class="font-semibold">From:</span> {{message.email}}
                                </h3>
                                <h3 class="ml-6 text-lg"><span class="font-semibold">To:</span> {{ getApartmentTitle(message.apartment_id) }}</h3>
                                <button class="p-1 ml-auto bg-transparent  float-right text-3xl leading-none font-semibold outline-none focus:outline-none items-center" v-on:click="showModal = null">
                                    <span class="bg-transparent h-6 w-6 text-2xl block outline-none focus:outline-none">
                                        ×
                                    </span>
                                </button>
                            </div>
                            <!--body-->
                            <div class="relative p-6 flex-auto text-left">
                                <div>
                                    <h5 class="block mb-2 text-sm font-medium text-slate-500">Subject: </h5>
                                    <p class="mb-5">{{ message.name }}</p>
                                </div>
                                <div class="sm:col-span-2">
                                    <h5 class="block mb-2 text-sm font-medium text-slate-500">Message: </h5>
                                    <p class="mb-5">{{ message.content }}</p>
                                </div>
                                <div class="sm:col-span-2">
                                    <h5 class="block mb-2 text-sm font-medium text-slate-500">Sent: </h5>
                                    <p class="mb-5">{{ handleDate(message.created_at) }}</p>
                                </div>
                            </div>
                            <!--footer-->
                            <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
                                <button class="text-red-500 bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-2 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="showModal = null">
                                    Close
                                </button>
                            </div>
                            </div>
                        </div>
                </div>
                <div v-if="showModal == message.id" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
            </div>
            <Pagination :links="messages.links"/>
        </div>

        <div v-else class="p-6 mt-12 max-w-[95%] mx-auto sm:px-6 lg:px-8 bg-white rounded-xl my-4">
            <p>
                On this page you will see your messages about your apartments. List your first apartment and/or wait to have some messages!
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
