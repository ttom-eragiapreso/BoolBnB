<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import tt from "@tomtom-international/web-sdk-maps";
import { Link, Head, router } from "@inertiajs/vue3";
import { store } from "@/data/store";
import Modal from "@/Components/Modal.vue";
import DeleteButton from "@/Components/DeleteButton.vue";

export default {
    name: "Show",
    props: {
        apartment: Object,
    },
    components: {
        AuthenticatedLayout,
        Link,
        Head,
        Modal,
        DeleteButton,
    },
    data() {
        return {
            showModal: false,
            store
        };
    },
    mounted() {
        const map = tt.map({
            key: store.API_Key_TomTom,
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
            map.addControl(new tt.FullscreenControl());
            map.addControl(new tt.NavigationControl());
        });
    },
    computed: {
        handleCreateDate() {
            const data = new Date(this.apartment.created_at);
            return data.toLocaleDateString("it-IT", { dateStyle: "short" });
        },
        handleUpdateDate() {
            const data = new Date(this.apartment.updated_at);
            return data.toLocaleDateString("it-IT", { dateStyle: "short" });
        },
    },
    methods: {
        remove(apartment) {
            router.delete(route("dashboard.apartment.destroy", apartment));
        },
    },
};
</script>

<template>
    <Modal v-if="showModal" :show="showModal" @close="showModal = false">
        <div class="container min-h-[20vh] p-10">
            <h3 class="text-3xl">
                Are you sure you want to remove this apartment?
            </h3>
            <div class="mt-10 flex justify-end">
                <button
                    class="px-3 py-3 bg-cyan-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-cyan-500 focus:bg-cyan-500 active:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mx-4"
                    @click="showModal = false"
                >
                    Go Back
                </button>
                <button
                    class="px-1 md:px-8 py-3 bg-red-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    @click="remove(apartment)"
                >
                    Delete
                </button>
            </div>
        </div>
    </Modal>
    <Head title="Show Apartment" />

    <AuthenticatedLayout>
        <template v-slot:header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Your Apartment - {{ apartment.title }}
            </h2>
        </template>
        <!-- max-w-[95%] -->
        <div
            class="container py-6 max-w-[78rem] mx-auto px-4 sm:px-6 lg:px-8 bg-white rounded-xl mt-12 mb-4"
        >
            <h1 class="text-center sm:text-start text-3xl pb-2">{{ apartment.title }}</h1>
            <div class="pb-8 sm:pb-2 text-center">
                <img
                    :src="'/storage/' + apartment.cover_image"
                    alt="cover"
                    class="w-96 mx-auto rounded-xl mb-2 mt-4"
                />
            </div>

            <p><strong>Type:</strong> {{ apartment.type_of_stay.name }}</p>
            <p>
                <strong>Currently Public:</strong>
                {{ apartment.is_visible ? "Yes" : "No" }}
            </p>
            <p><strong>Price:</strong> {{ apartment.price }} &euro;</p>
            <hr class="my-2" />
            <p><strong>Rooms:</strong> {{ apartment.rooms }}</p>
            <p><strong>Beds:</strong> {{ apartment.beds }}</p>
            <p><strong>Bathrooms:</strong> {{ apartment.bathrooms }}</p>
            <p>
                <strong>Square Meters:</strong>
                {{ apartment.square_meters }} &#13217;
            </p>
            <hr class="my-2" />
            <p><strong>Description:</strong> {{ apartment.description }}</p>
        </div>

        <div
            v-if="apartment.features.length != 0"
            class="container py-6 max-w-[78rem] mx-auto px-4 sm:px-6 lg:px-8 bg-white rounded-xl my-4"
        >
            <p class="mb-3"><strong>Features:</strong></p>
            <div class="flex gap-2 flex-wrap">
                <div
                    v-for="feature in apartment.features" :key="feature.id"
                    class="border rounded-xl border-stone-700 py-1 px-4 w-fit hover:bg-slate-100"
                >
                    {{ feature.name }}
                </div>
            </div>
        </div>

        <div
            class="container py-6 max-w-[78rem] mx-auto px-4 sm:px-6 lg:px-8 bg-white rounded-xl my-4"
        >
            <h5 class="font-bold pb-4">Gallery:</h5>

            <div class="flex flex-wrap gap-3">
                <div
                    class="flex flex-wrap justify-center gap-3 items-center"
                    v-if="apartment.images.length > 0"
                >
                    <div v-for="(image, id) in apartment.images" :key="id">
                        <img
                            :src="'/storage/' + image.url"
                            alt="image_galler"
                            class="rounded-2xl max-h-64"
                        />
                    </div>
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
            class="container py-6 max-w-[78rem] mx-auto px-4 sm:px-6 lg:px-8 bg-white rounded-xl my-4"
        >
            <h5 class="font-bold pb-4">Position:</h5>

            <p>
                <strong>Address:</strong> {{ apartment.full_address }},
                {{ apartment.city }},
                {{ apartment.country }}
            </p>
            <p><strong>Latitude:</strong> {{ apartment.latitude }}</p>
            <p><strong>Longitude:</strong> {{ apartment.longitude }}</p>

            <div
                id="map"
                class="mx-auto my-8 w-10/12 h-[500px] rounded-2xl shadow-2xl"
            ></div>
        </div>

        <div
            class="container py-6 max-w-[78rem] mx-auto px-4 sm:px-6 lg:px-8 bg-white rounded-xl my-4"
        >
            <p>Created at: {{ handleCreateDate }}</p>
            <p>Last update: {{ handleUpdateDate }}</p>
        </div>

        <div
            class="container py-6 max-w-[78rem] mx-auto px-16 lg:px-8 bg-white rounded-xl my-4 items-center gap-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6"
        >
            <Link
                :href="route('dashboard.apartment.index')"
                as="button"
                class="sm:w-auto px-10 py-3 bg-cyan-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-cyan-500 focus:bg-cyan-500 active:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                Back
            </Link>
            <Link
                :href="route('dashboard.apartment.edit', apartment.slug)"
                as="button"
                class="sm:w-auto px-10 py-3 bg-amber-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-amber-500 focus:bg-amber-500 active:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                Edit
            </Link>
            <Link
                :href="route('dashboard.apartment.stats', apartment.slug)"
                as="button"
                class="sm:w-auto px-10 py-3 bg-green-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                Stats
            </Link>
            <Link
                :href="route('dashboard.apartment.messages', apartment.id)"
                as="button"
                class="sm:w-auto px-10 py-3 bg-blue-500 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-400 focus:bg-blue-400 active:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                Messages
            </Link>
            <DeleteButton @click="showModal = true" :showBin="false" />
            <Link
            :href="route('dashboard.apartment.sponsorship', apartment.id)"
            as="button"
            class="sm:w-auto px-10 py-3 bg-indigo-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
            Sponsor
        </Link>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="scss" scoped></style>
