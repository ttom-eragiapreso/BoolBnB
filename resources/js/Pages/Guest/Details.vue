<script>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import tt from "@tomtom-international/web-sdk-maps";

export default {
    name: "Details",
    components: {
        GuestLayout,
    },
    props: {
        apartment: Object,
        user: Object,
        features: Object,
        name: String,
        date: String
    },
    methods:{
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
                        <p>2 guests &middot; {{ apartment.rooms }} room &middot; {{ apartment.beds }} bed &middot; {{ apartment.bathrooms }} &middot; bathroom &middot; {{ apartment.square_meters }}&#13217;</p>
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
                        <p class="text-slate-500 text-sm">Joined in {{date}}</p>
                        <h2 class="font-bold text-base mt-4">During your stay</h2>
                        <p>In order to make your stay as pleasant as possible, we personally prepare the apartment and make sure that everything is in order for your arrival, down to the smallest detail.

                        We will be present on your arrival to welcome you and introduce you to the apartment. We will provide you with any information you may need. We will be in regular contact with you during your stay.</p>
                        <button class="font-bold w-full border border-black rounded-xl mt-8 py-2 hover:bg-black hover:text-white">Contact host</button>
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
