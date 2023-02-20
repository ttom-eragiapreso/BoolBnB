<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import tt from "@tomtom-international/web-sdk-maps";
import { Link } from "@inertiajs/vue3";

export default {
    name: "Show",
    props: {
        apartment: Object,
    },
    components: {
        AuthenticatedLayout,
        Link,
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

    },
};
</script>

<template>
    <AuthenticatedLayout>
        <template v-slot:header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Your Apartment - {{ apartment.title }}
            </h2>
        </template>

        <div
            class="container py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4"
        >
            <h1 class="text-3xl pb-2">{{ apartment.title }}</h1>
            <div class="pb-2 text-center">
                <img
                    :src="'/storage/' + apartment.cover_image"
                    alt="cover"
                    class="w-96 mx-auto"
                />
            </div>

            <p>Rooms: {{ apartment.rooms }}</p>
            <p>Beds: {{ apartment.beds }}</p>
            <p>Bathrooms: {{ apartment.bathrooms }}</p>
            <p>Square Meters: {{ apartment.square_meters }} &#13217;</p>
            <p>Price: {{ apartment.price }} &euro;</p>
            <p>Currently Public: {{ apartment.is_visible ? "Yes" : "No" }}</p>
            <p>Description: {{ apartment.description }}</p>
        </div>

        <div
            class="container py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4"
        >
            <h5 class="font-bold pb-4">Gallery:</h5>

            <div class="flex flex-wrap gap-3">
                <div class="flex flex-wrap gap-3" v-if="apartment.images.length > 0">
                    <img

                        v-for="(image, id) in apartment.images"
                        :key="id"
                        :src="'/storage/' + image.url"
                        alt="image_galler"
                        class="rounded-2xl max-h-64"
                    />
                </div>
                <!-- Fare che quando clicchi all'immagine, si mostri sopra a tutto grande -->
                <p v-else>
                    You have not added additional photos to your listing, add
                    some
                    <Link
                        :href="
                            route('dashboard.apartment.edit', apartment.slug)
                        "
                        as="button"
                        class="px-5 py-1 bg-amber-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-amber-500 focus:bg-amber-500 active:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Here!
                    </Link>
                </p>
            </div>
        </div>

        <div
            class="container py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4"
        >
            <p>
                Address: {{ apartment.full_address }}, {{ apartment.city }},
                {{ apartment.country }}
            </p>
            <p>Latitude: {{ apartment.latitude }}</p>
            <p>Longitude: {{ apartment.longitude }}</p>

            <div
                id="map"
                class="mx-auto my-8 w-10/12 h-[500px] rounded-2xl shadow-2xl"
            ></div>
        </div>

        <div
            class="container py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4"
        >
            <p>Created at: {{ apartment.created_at }}</p>
            <p>Last update: {{ apartment.updated_at }}</p>
        </div>

        <div
            class="container py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4 flex gap-4"
        >
            <Link
                :href="route('dashboard.apartment.index')"
                as="button"
                class="px-10 py-3 bg-cyan-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-cyan-500 focus:bg-cyan-500 active:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                Back
            </Link>
            <Link
                :href="route('dashboard.apartment.edit', apartment.slug)"
                as="button"
                class="px-10 py-3 bg-amber-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-amber-500 focus:bg-amber-500 active:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                Edit
            </Link>
            <Link
                :href="route('dashboard.apartment.destroy', apartment)"
                method="delete"
                as="button"
                class="px-10 py-3 bg-red-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                Delete
            </Link>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="scss" scoped></style>
