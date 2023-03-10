<script>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Slider from "@/Components/Slider.vue";
import tt from "@tomtom-international/web-sdk-maps";
import Card from "@/Components/Card.vue";
import { store } from "../../data/store";
import { Head } from "@inertiajs/vue3";

export default {
    name: "AdvancedSearch",
    components: {
        GuestLayout,
        Slider,
        Card,
        Head,
    },
    data() {
        return {
            upper_limit: 12,
            filters: {
                beds: 0,
                rooms: 0,
                bathrooms: 0,
                features: [],
                range: 20000,
                // price: 0,
                ignoreLocations: true,
            },
            filtered_sponsored_apartments: [],
            filtered_non_sponsored_apartments: [],
            center: {
                latitude: null,
                longitude: null,
            },
            store,
            UpdateMap: new CustomEvent("UpdateMap"),
            markers: [],
            hideFilters: true,
            zoomValue: 3,
        };
    },
    props: {
        types_of_stay: Array,
        non_sponsored_apartments: Object,
        sponsored_apartments: Object,
        features: Array,
        lat: String,
        lng: String,
    },
    methods: {
        addFeature(id) {
            if (this.filters.features.includes(id)) {
                this.filters.features = this.filters.features.filter((elem) => {
                    return elem != id;
                });
            } else {
                this.filters.features.push(id);
            }
        },
        checkFeature(apartment) {
            let flag = 1;
            this.filters.features.forEach((filteredFeatureId) => {
                if (apartment.features.length != 0) {
                    if (
                        !apartment.features.some((presentFeature) => {
                            return presentFeature.id == filteredFeatureId;
                        })
                    ) {
                        flag = 0;
                    }
                } else {
                    flag = 0;
                }
            });
            return flag;
        },
        distanceInMeters(p1, p2) {
            const R = 6371000; // Earth's radius in meters
            const dLat = this.toRadians(p2.latitude - p1.latitude);
            const dLon = this.toRadians(p2.longitude - p1.longitude);
            const lat1 = this.toRadians(p1.latitude);
            const lat2 = this.toRadians(p2.latitude);
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.sin(dLon / 2) *
                    Math.sin(dLon / 2) *
                    Math.cos(lat1) *
                    Math.cos(lat2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        },
        toRadians(degrees) {
            return (degrees * Math.PI) / 180;
        },
        filterLocations(apartment) {
            const coord = {
                latitude: apartment.latitude,
                longitude: apartment.longitude,
            };
            const distance = this.distanceInMeters(this.center, coord);
            return distance <= this.filters.range;
        },
        removeAllFilters() {
            this.filters.beds = 0;
            this.filters.rooms = 0;
            this.filters.bathrooms = 0;
            this.filters.features = [];
            this.filters.range = 20000;
            this.store.filtered_type = null;
        },
        loadMore() {
            this.filtered_non_sponsored_apartments.length + this.filtered_sponsored_apartments.length - this.upper_limit >
            10
                ? (this.upper_limit += 10)
                : (this.upper_limit =
                      this.filtered_non_sponsored_apartments.length + this.filtered_sponsored_apartments.length);
        },
    },
    computed: {
        handleFilters() {
            this.filtered_sponsored_apartments = Object.values(
                this.sponsored_apartments
            ).filter((sponsored_apartment) => {
                return (
                    sponsored_apartment.beds >= this.filters.beds &&
                    sponsored_apartment.rooms >= this.filters.rooms &&
                    sponsored_apartment.bathrooms >= this.filters.bathrooms &&
                    this.checkFeature(sponsored_apartment) &&
                    (this.store.filtered_type == null
                        ? true
                        : sponsored_apartment.type_of_stay_id ==
                          this.store.filtered_type) &&
                    (this.filterLocations(sponsored_apartment) ||
                        this.filters.ignoreLocations)
                );
            });

            this.filtered_non_sponsored_apartments = Object.values(
                this.non_sponsored_apartments
            ).filter((non_sponsored_apartment) => {
                return (
                    non_sponsored_apartment.beds >= this.filters.beds &&
                    non_sponsored_apartment.rooms >= this.filters.rooms &&
                    non_sponsored_apartment.bathrooms >=
                        this.filters.bathrooms &&
                    this.checkFeature(non_sponsored_apartment) &&
                    (this.store.filtered_type == null
                        ? true
                        : non_sponsored_apartment.type_of_stay_id ==
                          this.store.filtered_type) &&
                    (this.filterLocations(non_sponsored_apartment) ||
                        this.filters.ignoreLocations)
                );
            });

            window.dispatchEvent(this.UpdateMap);

            return [
                this.filtered_sponsored_apartments,
                this.filtered_non_sponsored_apartments,
            ];
        },
        handleZoom() {
            // y=-0.00005 x+12
            return Math.round(-0.00005 * this.filters.range + 12);
        },
        showLoad() {
            return (
                this.filtered_non_sponsored_apartments.length + this.filtered_sponsored_apartments.length > this.upper_limit
            );
        },
        howManyMore(){
            // console.log(this.handleFilters[0].length - this.upper_limit);
            if(this.upper_limit > this.handleFilters[0].length){
                return this.upper_limit - this.handleFilters[0].length;
            } else {
                return 0
            }
        }
    },
    mounted() {
        this.filtered_sponsored_apartments = this.sponsored_apartments;
        this.filtered_non_sponsored_apartments = this.non_sponsored_apartments;

        this.center.longitude = this.lng ?? 12.5;
        this.center.latitude = this.lat ?? 49;

        if (this.lat != null && this.lng != null) {
            this.filters.ignoreLocations = false;
            this.zoomValue = this.handleZoom;
        }

        const map = tt.map({
            key: store.API_Key_TomTom,
            container: "map",
            center: [this.center.longitude, this.center.latitude],
            zoom: this.zoomValue,
            style: "/satellitemap.json",
        });

        map.on("load", () => {
            map.addControl(new tt.FullscreenControl());
            map.addControl(new tt.NavigationControl());
        });

        window.addEventListener("UpdateMap", () => {
            if (!this.filters.ignoreLocations) {
                map.flyTo({ zoom: this.handleZoom });
            }

            this.markers.forEach((marker) => {
                marker.remove();
            });
            map.resize();

            this.markers = [];

            this.filtered_sponsored_apartments.forEach((apartment) => {
                let popup = new tt.Popup({
                    closeButton: false,
                    offset: 35,
                    anchor: "bottom",
                }).setText(apartment.title);
                let marker = new tt.Marker()
                    .setLngLat([apartment.longitude, apartment.latitude])
                    .setPopup(popup);
                marker.addTo(map);
                this.markers.push(marker);
            });

            this.filtered_non_sponsored_apartments.forEach((apartment) => {
                let popup = new tt.Popup({
                    closeButton: false,
                    offset: 35,
                    anchor: "bottom",
                }).setText(apartment.title);
                let marker = new tt.Marker()
                    .setLngLat([apartment.longitude, apartment.latitude])
                    .setPopup(popup);
                marker.addTo(map);
                this.markers.push(marker);
            });
        });
    },
    unmounted() {
        this.store.searched_address = null;
    },
};
</script>

<template>
    <Head title="Advanced Search" />
    <GuestLayout>
        <div>
            <Slider
                :types_of_stay="types_of_stay"
                class="border border-b-1 border-b-slate-200 border-t-white"
            />
            <div class="mt-12 sm:mt-[180px] w-[100%] py-4 lg:px-20 px-8 flex">
                <div class="w-[100%] lg:w-[66%]">
                    <div :class="{ hide: hideFilters }" id="boxfilters">
                        <div v-if="!this.filters.ignoreLocations">
                            <h3 class="text-xl mb-3">Range:</h3>
                            <div class="flex">
                                <input
                                    type="range"
                                    class="w-96 mr-4 mb-2"
                                    min="1000"
                                    max="100000"
                                    step="1000"
                                    v-model="this.filters.range"
                                />
                                <p>{{ this.filters.range / 1000 }} Km</p>
                            </div>
                        </div>

                        <!-- <h3 class="text-xl mb-3">Max Price:</h3>
                        <div class="flex ">
                            <input type="range" class=" w-96 mr-4 mb-2" min="1000" max="100000" step="1000" v-model="this.filters.price">
                            <p>{{ this.filters.price}} &euro;</p>
                        </div> -->

                        <h3 class="text-xl mb-3">Features:</h3>
                        <button
                            @click="addFeature(feature.id)"
                            class="px-3 mr-3 mb-3 py-1 border rounded-full border-slate-300 capitalize hover:border-red-800"
                            :class="{
                                'bg-red-800/80 border-red-800 text-white hover:bg-red-800/70':
                                    this.filters.features.includes(feature.id),
                            }"
                            v-for="feature in features"
                            :key="feature.id"
                        >
                            {{ feature.name }}
                        </button>

                        <h3 class="text-xl mb-3">Rooms:</h3>

                        <button
                            @click="this.filters.rooms = i"
                            :class="{
                                'bg-red-800/80 border-red-800 text-white hover:bg-red-800/70':
                                    this.filters.rooms === i,
                            }"
                            v-for="i in 7"
                            :key="i"
                            class="px-3 mr-3 mb-3 py-1 border rounded-full border-slate-300 capitalize hover:border-red-800"
                        >
                            {{ i }}
                        </button>
                        <button
                            @click="this.filters.rooms = 8"
                            :class="{
                                'bg-red-800/80 border-red-800 text-white hover:bg-red-800/70':
                                    this.filters.rooms === 8,
                            }"
                            class="px-3 mr-3 mb-3 py-1 border rounded-full border-slate-300 capitalize hover:border-red-800"
                        >
                            8+
                        </button>
                        <button
                            @click="this.filters.rooms = 0"
                            class="pl-1 mb-3 py-1 capitalize hover:border-black"
                        >
                            &times;
                        </button>

                        <h3 class="text-xl mb-3">Beds:</h3>
                        <button
                            @click="this.filters.beds = i"
                            :class="{
                                'bg-red-800/80 border-red-800 text-white hover:bg-red-800/70':
                                    this.filters.beds === i,
                            }"
                            v-for="i in 7"
                            :key="i"
                            class="px-3 mr-3 mb-3 py-1 border rounded-full border-slate-300 capitalize hover:border-red-800"
                        >
                            {{ i }}
                        </button>
                        <button
                            @click="this.filters.beds = 8"
                            :class="{
                                'bg-red-800/80 border-red-800 text-white hover:bg-red-800/70':
                                    this.filters.beds === 8,
                            }"
                            class="px-3 mr-3 mb-3 py-1 border rounded-full border-slate-300 capitalize hover:border-red-800"
                        >
                            8+
                        </button>
                        <button
                            @click="this.filters.beds = 0"
                            class="pl-1 mb-3 py-1 capitalize hover:border-black"
                        >
                            &times;
                        </button>

                        <div>
                            <h3 class="text-xl mb-3">Bathrooms:</h3>
                            <button
                                @click="this.filters.bathrooms = i"
                                :class="{
                                    'bg-red-800/80 border-red-800 text-white hover:bg-red-800/70':
                                        this.filters.bathrooms === i,
                                }"
                                v-for="i in 3"
                                :key="i"
                                class="px-3 mr-3 mb-3 py-1 border rounded-full border-slate-300 capitalize hover:border-red-800"
                            >
                                {{ i }}
                            </button>
                            <button
                                @click="this.filters.bathrooms = 4"
                                :class="{
                                    'bg-red-800/80 border-red-800 text-white hover:bg-red-800/70':
                                        this.filters.bathrooms === 4,
                                }"
                                class="px-3 mr-3 mb-3 py-1 border rounded-full border-slate-300 capitalize hover:border-red-800"
                            >
                                4+
                            </button>
                            <button
                                @click="this.filters.bathrooms = 0"
                                class="pl-1 mb-3 py-1 capitalize hover:border-black"
                            >
                                &times;
                            </button>
                        </div>

                        <div class="flex justify-end items-center">
                            <div
                                class="group text-right cursor-pointer mr-3 border-2 rounded-xl px-3 py-1 text-slate-800 hover:text-white hover:bg-red-900 hover:border-red-900"
                                @click="removeAllFilters()"
                            >
                                Remove Filters
                                <i
                                    class="px-1 fa-solid fa-trash text-lg text-slate-400 group-hover:text-white"
                                ></i>
                            </div>

                            <div
                                class="group text-right cursor-pointer"
                                @click="hideFilters = !hideFilters"
                            >
                                Close:
                                <i
                                    class="px-1 fa-solid fa-chevron-up text-lg text-slate-400 group-hover:text-black"
                                ></i>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="hideFilters"
                        class="group text-right cursor-pointer"
                        @click="hideFilters = !hideFilters"
                    >
                        Additional Filters:
                        <i
                            class="px-1 fa-solid fa-chevron-down text-lg text-slate-400 group-hover:text-black"
                        ></i>
                    </div>

                    <hr class="mr-4 mb-12 mt-4" />

                    <div
                        class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-x-6 gap-y-12"
                        v-if="handleFilters[0].length != 0 || handleFilters[1].length != 0"
                    >
                        <Card
                            v-for="apartment in handleFilters[0].slice(
                                0,
                                upper_limit
                            )"
                            :key="apartment.id"
                            :apartment="apartment"
                            :is_sponsored="true"
                            class="mb-8"
                        />
                        <Card
                            v-for="apartment in handleFilters[1].slice(
                                0,
                                howManyMore
                            )"
                            :key="apartment.id"
                            :apartment="apartment"
                            :is_sponsored="false"
                            class="mb-8"
                        />

                    </div>

                    <div v-else>
                        <p>No apartments found.</p>
                    </div>
                    <div class="w-full text-center">
                        <button @click="loadMore" class="mb-8 py-3 px-6 border-2 rounded-3xl font-semibold border-slate-300 text-slate-700 hover:text-slate-900 hover:border-slate-400 hover:bg-slate-100" v-if="showLoad">
                            Load More
                        </button>
                    </div>
                </div>
                <div
                    class="hidden lg:block w-1/3 fixed top-[163px] right-0 border-l border-gray-200"
                >
                    <div id="map" class="my-0 shadow"></div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<style>
#boxfilters {
    transition: 0.8s ease all;
}

#boxfilters.hide {
    transform: translateY(-100%);
    display: none;
}

#map {
    height: calc(100vh - 212px);
}
</style>
