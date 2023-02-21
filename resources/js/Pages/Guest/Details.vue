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
        user: String
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
            <p class=" mb-4 font-bold underline"> &#8669;
                {{ apartment.full_address }}, {{ apartment.city }},
                {{ apartment.country }}
            </p>

            <div class="flex">
                <div class="pb-2 mb-4 w-[50%]">
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
                        <h2 class="text-2xl pb-2 font-bold">Apartment hosted by: {{ user }}</h2>
                        <p>2 guests &middot; {{ apartment.rooms }} room &middot; {{ apartment.beds }} bed &middot; {{ apartment.bathrooms }} &middot; bathroom &middot; {{ apartment.square_meters }}&#13217;</p>
                    </div>
                    <div class="pb-4 mb-4 border-b">
                        <h2 class="text-2xl pb-2 font-bold">Description</h2>
                        <p>{{ apartment.description }}</p>
                    </div>
                </div>
                <div class="w-[40%]">
                    <div class="border rounded-xl h-[500px] p-4 shadow-lg hover:shadow-xl">
                        Prezzo <br>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia, et! Neque molestiae non ipsum nostrum, at dignissimos quasi incidunt similique placeat voluptatum eaque harum pariatur nisi sed minima, quidem libero.
                    </div>
                </div>
            </div>

        </div>

            <div
                id="map"
                class="mx-auto my-8 max-w-7xl h-[500px] rounded-2xl shadow-2xl">
            </div>

        <div
            class="container mb-20 py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4">
            <button>Invia Messaggio</button>
        </div>

    </GuestLayout>
</template>

<style></style>
