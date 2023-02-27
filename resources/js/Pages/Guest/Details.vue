<script>
import {router} from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import tt from "@tomtom-international/web-sdk-maps";
import { Head, usePage } from '@inertiajs/vue3';

export default {
    name: "Details",
    name: "large-modal",
    components: {
        GuestLayout,
        Head
    },
    data() {
        return {
        showModal: false,
        userEmail: usePage().props.auth.user? usePage().props.auth.user.email : '',
        userSubject: '',
        userMessage: ''
        }
    },
    props: {
        apartment: Object,
        user: Object,
        name: String,
        date: String,
        email: String
    },
    methods:{
        toggleModal: function(){
        this.showModal = !this.showModal;
    },
        sendMessage(){
            this.showModal = !this.showModal;
            router.post(route('store-messages'),
            {
                "userEmail": this.userEmail,
                "userSubject" : this.userSubject,
                "userMessage": this.userMessage,
                "apartmentId": this.apartment.id
            });
        },
    },
    computed:{
        handleCreateDate() {
                const data = new Date(this.date);
                return data.toLocaleDateString("it-IT", { dateStyle: "short" });
            },
        checkDisable(){
                 return ((this.userEmail.includes('@') && this.userEmail.includes('.')) && this.userSubject.length > 5 && this.userMessage.length > 10)
            }
    },
    mounted() {

        const map = tt.map({
            key: "LyiQawx4xo4FpPG8VKyj3yHadh1WEDRM",
            container: "map",
            center: [this.apartment.longitude, this.apartment.latitude],
            zoom: 15,
            style: "/satellitemap.json",
        });

        map.on("load", () => {
            let popup = new tt.Popup({
                closeButton: false,
                offset: 35,
                anchor: "bottom",
            }).setText(this.apartment.title);
            let marker = new tt.Marker()
                .setLngLat([this.apartment.longitude, this.apartment.latitude])
                .setPopup(popup);
            marker.addTo(map);
            map.addControl(new tt.FullscreenControl);
            map.addControl(new tt.NavigationControl);
        });

     }
};
</script>

<template>
    <Head :title="apartment.title" />
    <GuestLayout>



        <div
            class="container md:max-w-7xl mx-auto sm:px-6 bg-white sm:rounded-xl px-8 lg:px-20 py-8"
        >
            <h1 class="text-center md:text-start text-3xl pb-2 font-bold">{{ apartment.title }}</h1>
            <a href="#map" class="flex justify-center md:justify-start mb-4 font-bold underline"> &#8669;
                {{ apartment.full_address }}, {{ apartment.city }},
                {{ apartment.country }}
            </a>

            <div class="md:flex">
                <div class="mx-auto pb-2 md:mb-8 w-[80%] md:w-[50%]">
                    <img
                        :src="'/storage/' + apartment.cover_image"
                        alt="cover"
                        class="md:w-full h-[350px] md:rounded-l-2xl p-1 hover:brightness-75"
                    />
                </div>
                <div class="mx-auto w-[80%] md:w-[50%] flex flex-wrap md:rounded-r-3xl overflow-hidden h-[350px]">
                        <img
                            v-for="(image, id) in apartment.images"
                            :key="id"
                            :src="'/storage/' + image.url"
                            alt="image_galler"
                            class="p-1 hover:brightness-75"
                            :class="
                                apartment.images.length == 1 ? 'w-[100%] h-[100%]'
                                : apartment.images.length == 2 ? 'w-[50%] h-[100%] object-cover'
                                : apartment.images.length == 3 ? 'w-[50%] max-h-[175px] grow object-cover'
                                : 'w-[50%] h-[175px]'
                                "
                        />
                </div>
            </div>

            <div class="md:flex gap-20">
                <div class="md:w-[60%]">
                    <div class="pb-4 mb-4 border-b">
                        <h2 class="text-center md:text-start text-2xl pb-2 font-bold">Apartment hosted by: {{ name }}</h2>
                        <p class="text-center md:text-start">2 guests &middot; {{ apartment.rooms }} {{apartment.rooms > 1 ? 'rooms' : 'room'}} &middot; {{ apartment.beds }} {{apartment.rooms > 1 ? 'beds' : 'bed'}} &middot; {{ apartment.bathrooms }} {{apartment.rooms > 1 ? 'bathrooms' : 'bathroom'}} &middot; {{ apartment.square_meters }}&#13217;</p>
                    </div>
                    <div class="text-center md:text-start pb-4 mb-4 border-b">
                        <h2 class="text-2xl pb-2 font-bold">Description</h2>
                        <p>{{ apartment.description }}</p>
                    </div>
                    <div v-if="apartment.features.length != 0" class="text-center md:text-start pb-4 mb-4 border-b">
                        <h2 class="text-2xl pb-2 font-bold">What this place offers</h2>
                        <ul class="grid md:grid-cols-2">
                            <li v-for="features in apartment.features" :key="features.id" class="border rounded-xl border-stone-700 py-1 my-2 px-4 w-fit hover:bg-slate-100">{{ features.name }}</li>
                        </ul>
                    </div>
                </div>
                <div class="md:w-[40%]">
                    <div class="border rounded-xl p-8 shadow-lg hover:shadow-xl">
                        <h2 class="font-bold text-xl">&euro; {{ apartment.price }} <span class="font-thin text-base">night</span></h2>
                        <p class="text-sm text-slate-500">Fees included</p>
                        <!-- <button class="text-white font-bold w-full rounded-xl mt-8 py-2 bg-gradient-to-br from-pink-800 to-pink-600 hover:bg-gradient-to-bl">Reserve</button> -->
                        <hr class="my-8">
                        <h2 class="font-bold text-lg">Host: {{ name }}</h2>
                        <p class="text-slate-500 text-sm">Joined in: {{ handleCreateDate }}</p>
                        <h2 class="font-bold text-base mt-4">During your stay</h2>
                        <p>In order to make your stay as pleasant as possible, we personally prepare the apartment and make sure that everything is in order for your arrival, down to the smallest detail.

                        We will be present on your arrival to welcome you and introduce you to the apartment. We will provide you with any information you may need. We will be in regular contact with you during your stay.</p>
                        <div>
                        <button v-on:click="toggleModal()" type="button" class="text-white font-bold w-full rounded-xl mt-8 py-2 bg-gradient-to-br from-pink-800 to-pink-600 hover:bg-gradient-to-bl">Contact host
                        </button>
                        <!-- <button v-on:click="toggleModal()" type="button" class="font-bold w-full border border-black rounded-xl mt-8 py-2 hover:bg-black hover:text-white">Contact host
                        </button> -->
                        <div v-if="showModal" class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
                            <div class="relative w-[50%] my-6 mx-auto max-w-6xl">
                                <!--content-->
                                <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                                <!--header-->
                                <div class="flex items-center justify-between p-5 border-b border-solid border-slate-200 rounded-t">
                                    <h3 class="text-3xl font-semibold">
                                    Host: {{name}}
                                    </h3>
                                    <span class="ml-6">to: {{ email }}</span>
                                    <button class="p-1 ml-auto bg-transparent  float-right text-3xl leading-none font-semibold outline-none focus:outline-none items-center" v-on:click="toggleModal()">
                                    <span class="bg-transparent h-6 w-6 text-2xl block outline-none focus:outline-none">
                                        ×
                                    </span>
                                    </button>
                                </div>
                                <!--body-->
                                <div class="relative p-6 flex-auto">
                                    <p class="mb-3 text-right text-sm text-slate-500">* Required fields.</p>
                                    <div>
                                        <label for="email" class="block mb-2 text-sm font-medium text-slate-500">Your email *</label>
                                        <input v-model="userEmail" type="email" id="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5 mb-2" placeholder="name@email.com" required>
                                        <p class="text-red-600 text-sm pt-2" v-if="(!userEmail.includes('@') || !userEmail.includes('.')) && userEmail.length > 1">Please insert a valid email address.</p>
                                    </div>
                                    <div>
                                        <label for="subject" class="block mb-2 text-sm font-medium text-slate-500">Subject *</label>
                                        <input minlength="6" maxlength="50" v-model="userSubject" type="text" id="subject" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-slate-500 focus:border-slate-500 mb-2" placeholder="Let us know how we can help you" required>
                                        <p class="text-red-600 text-sm pb-3" v-if="((userSubject.length < 6 || userSubject.length > 50) && userSubject.length > 3)">Please write between 6 and 50 characters</p>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="message" class="block mb-2 text-sm font-medium text-slate-500">Your message *</label>
                                        <textarea minlength="10" maxlength="500" v-model="userMessage" id="message" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-slate-500 focus:border-slate-500" placeholder="Leave a message..."></textarea>
                                        <p class="text-red-600 text-sm pt-2" v-if="(userMessage.length < 10 || userMessage.length > 500) && userMessage.length > 1">Please write between 10 and 500 characters</p>
                                    </div>
                                </div>
                                <!--footer-->
                                <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
                                    <button class="text-red-500 bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-2 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="toggleModal()">
                                    Close
                                    </button>
                                    <button :disabled="!checkDisable" @click.prevent="sendMessage()" :class="{'opacity-25' : !checkDisable}" class=" border border-solid border-green-500 background-transparent  hover:bg-green-500 hover:text-white rounded font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">
                                    Send message
                                    </button>
                                </div>
                                </div>
                            </div>
                            </div>
                            <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
                        </div>

                    </div>
                </div>


            </div>

        </div>

            <h2 name="map" class="font-bold text-2xl mt-8 text-center">Where you’ll be</h2>
            <div

                id="map"
                class="mx-auto mt-8 mb-[50px] max-w-5xl h-[500px] rounded-2xl shadow-2xl">
            </div>



    </GuestLayout>
</template>

<style></style>
