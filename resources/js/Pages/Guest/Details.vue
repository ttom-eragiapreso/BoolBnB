<script>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import tt from "@tomtom-international/web-sdk-maps";

export default {
    name: "Details",
    name: "large-modal",
    components: {
        GuestLayout,
    },
    data() {
        return {
        showModal: false
        }
    },
    props: {
        apartment: Object,
        user: Object,
        features: Object,
        name: String,
        date: String,
        email: String
    },
    methods:{
        toggleModal: function(){
        this.showModal = !this.showModal;
        }
    },
    handleCreateDate() {
            const data = new Date(this.apartment.created_at);
            return data.toLocaleDateString("it-IT", { dateStyle: "short" });
        },
        handleUpdateDate() {
            const data = new Date(this.apartment.updated_at);
            return data.toLocaleDateString("it-IT", { dateStyle: "short" });
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
    <GuestLayout>



        <div
            class="container max-w-7xl mx-auto sm:px-6 bg-white sm:rounded-xl px-8 lg:px-20 py-8"
        >
            <h1 class="text-3xl pb-2 font-bold">{{ apartment.title }}</h1>
            <a href="#" class=" mb-4 font-bold underline"> &#8669;
                {{ apartment.full_address }}, {{ apartment.city }},
                {{ apartment.country }}
            </a>

            <div class="flex">
                <div class="pb-2 mb-8 w-[50%]">
                    <img
                        :src="'/storage/' + apartment.cover_image"
                        alt="cover"
                        class="w-full h-[350px] rounded-l-2xl p-1 hover:brightness-75"
                    />
                </div>
                <div class="w-[50%] flex flex-wrap rounded-r-3xl overflow-hidden h-[350px]">
                        <img
                            v-for="(image, id) in apartment.images"
                            :key="id"
                            :src="'/storage/' + image.url"
                            alt="image_galler"
                            class="w-[50%] h-[175px] p-1 hover:brightness-75"
                        />
                </div>
            </div>

            <div class="flex gap-20">
                <div class="w-[60%]">
                    <div class="pb-4 mb-4 border-b">
                        <h2 class="text-2xl pb-2 font-bold">Apartment hosted by: {{ name }}</h2>
                        <p>2 guests &middot; {{ apartment.rooms }} {{apartment.rooms > 1 ? 'rooms' : 'room'}} &middot; {{ apartment.beds }} {{apartment.rooms > 1 ? 'beds' : 'bed'}} &middot; {{ apartment.bathrooms }} &middot; {{apartment.rooms > 1 ? 'bathrooms' : 'bathroom'}} &middot; {{ apartment.square_meters }}&#13217;</p>
                    </div>
                    <div class="pb-4 mb-4 border-b">
                        <h2 class="text-2xl pb-2 font-bold">Description</h2>
                        <p>{{ apartment.description }}</p>
                    </div>
                    <div class="pb-4 mb-4 border-b">
                        <h2 class="text-2xl pb-2 font-bold">What this place offers</h2>
                        <ul v-for="features in features" :key="features.id">
                            <li>{{ features.name }}</li>
                        </ul>
                    </div>
                </div>
                <div class="w-[40%]">
                    <div class="border rounded-xl p-8 shadow-lg hover:shadow-xl">
                        <h2 class="font-bold text-xl">&euro; {{ apartment.price }} <span class="font-thin text-base">night</span></h2>
                        <p class="text-sm text-slate-500">Fees included</p>
                        <button class="text-white font-bold w-full rounded-xl mt-8 py-2 bg-gradient-to-br from-pink-800 to-pink-600 hover:bg-gradient-to-bl">Reserve</button>
                        <hr class="my-8">
                        <h2 class="font-bold text-lg">Host: {{ name }}</h2>
                        <p class="text-slate-500 text-sm">Joined in:{{ apartment.created_at }}</p>
                        <h2 class="font-bold text-base mt-4">During your stay</h2>
                        <p>In order to make your stay as pleasant as possible, we personally prepare the apartment and make sure that everything is in order for your arrival, down to the smallest detail.

                        We will be present on your arrival to welcome you and introduce you to the apartment. We will provide you with any information you may need. We will be in regular contact with you during your stay.</p>
                        <div>
                        <button v-on:click="toggleModal()" type="button" class="font-bold w-full border border-black rounded-xl mt-8 py-2 hover:bg-black hover:text-white">Contact host
                        </button>
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
                                    <div>
                                        <label for="email" class="block mb-2 text-sm font-medium text-slate-500">Your email</label>
                                        <input type="email" id="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-slate-500 focus:border-slate-500 block w-full p-2.5 mb-2" placeholder="name@email.com" required>
                                    </div>
                                    <div>
                                        <label for="subject" class="block mb-2 text-sm font-medium text-slate-500">Subject</label>
                                        <input type="text" id="subject" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-slate-500 focus:border-slate-500 mb-2" placeholder="Let us know how we can help you" required>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="message" class="block mb-2 text-sm font-medium text-slate-500">Your message</label>
                                        <textarea id="message" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-slate-500 focus:border-slate-500" placeholder="Leave a message..."></textarea>
                                    </div>
                                </div>
                                <!--footer-->
                                <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
                                    <button class="text-red-500 bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-2 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="toggleModal()">
                                    Close
                                    </button>
                                    <button class="text-green-500 border border-solid border-green-500 background-transparent  hover:bg-green-500 hover:text-white rounded font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">
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

            <h2 class="font-bold text-2xl mt-8 text-center">Where you’ll be</h2>
            <div
                id="map"
                class="mx-auto my-8 max-w-5xl h-[500px] rounded-2xl shadow-2xl">
            </div>



    </GuestLayout>
</template>

<style></style>
