<script>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Slider from "@/Components/Slider.vue";
import tt from "@tomtom-international/web-sdk-maps";
import Card from "@/Components/Card.vue";
import {store} from '../../data/store';
import { Head } from '@inertiajs/vue3';

export default {
    name: "AdvancedSearch",
    components: {
        GuestLayout,
        Slider,
        Card,
        Head
    },
    data() {
        return {
            filters: {
                beds: 0,
                rooms: 0,
                bathrooms: 0,
                features: [],
                range: 20000,
                ignoreLocations: true
            },
            filtered_sponsored_apartments: [],
            filtered_non_sponsored_apartments: [],
            center: {
                latitude: null,
                longitude: null
            },
            store,
            UpdateMap: new CustomEvent('UpdateMap'),
            markers: [],
            hideFilters: true,
            zoomValue: 3
        };
    },
    props: {
        types_of_stay: Array,
        non_sponsored_apartments: Object,
        sponsored_apartments: Array,
        features: Array,
        lat: String,
        lng: String
    },
    methods: {
        addFeature(id) {
            if(this.filters.features.includes(id)){
                this.filters.features = this.filters.features.filter((elem)=>{
                    return elem != id
                })
            } else {
                this.filters.features.push(id);
            }
        },
        checkFeature(apartment){
            let flag = 1;
            this.filters.features.forEach(filteredFeatureId => {

                if(apartment.features.length != 0){

                    if (!apartment.features.some(presentFeature => {
                        return presentFeature.id == filteredFeatureId
                    })){
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
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        },
        toRadians(degrees) {
            return degrees * Math.PI / 180;
        },
        filterLocations(apartment){
            const coord = {
                latitude: apartment.latitude,
                longitude: apartment.longitude
            };
            const distance = this.distanceInMeters(this.center, coord);
            return distance <= this.filters.range;
        }
    },
    computed:{
        handleFilters(){

            this.filtered_sponsored_apartments = Object.values(this.sponsored_apartments).filter((sponsored_apartment) => {
                return sponsored_apartment.beds >= this.filters.beds
                        && sponsored_apartment.rooms >= this.filters.rooms
                        && sponsored_apartment.bathrooms >= this.filters.bathrooms
                        && this.checkFeature(sponsored_apartment)
                        && (this.store.filtered_type == null ? true : sponsored_apartment.type_of_stay_id == this.store.filtered_type)
                        && (this.filterLocations(sponsored_apartment) || this.filters.ignoreLocations)
            })

            this.filtered_non_sponsored_apartments = Object.values(this.non_sponsored_apartments).filter((non_sponsored_apartment) => {
                return non_sponsored_apartment.beds >= this.filters.beds
                        && non_sponsored_apartment.rooms >= this.filters.rooms
                        && non_sponsored_apartment.bathrooms >= this.filters.bathrooms
                        && this.checkFeature(non_sponsored_apartment)
                        && (this.store.filtered_type == null ? true : non_sponsored_apartment.type_of_stay_id == this.store.filtered_type)
                        && (this.filterLocations(non_sponsored_apartment) || this.filters.ignoreLocations)
            })

            window.dispatchEvent(this.UpdateMap);

            return[ this.filtered_sponsored_apartments, this.filtered_non_sponsored_apartments]
        },
        handleZoom(){
            // y=-0.00005 x+12
            return Math.round((-0.00005 * this.filters.range) + 12);
        }
    },
    mounted() {
        this.filtered_sponsored_apartments = this.sponsored_apartments;
        this.filtered_non_sponsored_apartments = this.non_sponsored_apartments;

        this.center.longitude = this.lng ?? 12.5;
        this.center.latitude = this.lat ?? 49;

        if(this.lat != null && this.lng != null){
            this.filters.ignoreLocations = false;
            this.zoomValue = this.handleZoom;
        }

        const map = tt.map({
            key: "LyiQawx4xo4FpPG8VKyj3yHadh1WEDRM",
            container: "map",
            center: [this.center.longitude, this.center.latitude],
            zoom: this.zoomValue,
            style: "/satellitemap.json",
        });

        map.on("load", () => {
            map.addControl(new tt.FullscreenControl());
            map.addControl(new tt.NavigationControl());
        });

        window.addEventListener('UpdateMap', () => {

            if(!this.filters.ignoreLocations){
                map.flyTo({zoom: this.handleZoom});
            }

            this.markers.forEach(marker => {
                marker.remove();
            })
            map.resize();

            this.markers = [];

            this.filtered_sponsored_apartments.forEach(apartment => {
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

            this.filtered_non_sponsored_apartments.forEach(apartment => {
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
    unmounted(){
        this.store.searched_address = null;
    }
};
</script>

<template>
    <Head title="Advanced Search" />
    <GuestLayout>
        <div>
            <Slider :types_of_stay="types_of_stay" />
            <div class="mt-12 sm:mt-[180px] py-4 lg:px-20 px-8 flex w-full">
                <div class="w-2/3">
                    <div :class="{'hide': hideFilters}" id="boxfilters">

                        <div v-if="!this.filters.ignoreLocations">
                            <h3 class="text-xl mb-3">Range:</h3>
                            <div class="flex ">
                                <input type="range" class=" w-96 mr-4 mb-2" min="1000" max="100000" step="1000" v-model="this.filters.range">
                                <p>{{ this.filters.range / 1000 }} Km</p>
                            </div>
                        </div>

                        <h3 class="text-xl mb-3">Features:</h3>
                        <button
                            :class="{'text-red-500': this.filters.features.includes(feature.id)}"
                            @click="addFeature(feature.id)"
                            class="px-3 mr-3 mb-3 py-1 border rounded-full border-slate-300 capitalize hover:border-black"
                            v-for="feature in features"
                            :key="feature.id"
                        >
                            {{ feature.name }}
                        </button>

                        <h3 class="text-xl mb-3">Rooms:</h3>

                        <button
                            @click="this.filters.rooms = i"
                            :class="{ 'text-red-500': this.filters.rooms === i }"
                            v-for="i in 7"
                            :key="i"
                            class="px-3 mr-3 mb-3 py-1 border rounded-full border-slate-300 capitalize hover:border-black"
                        >
                            {{ i }}
                        </button>
                        <button
                            @click="this.filters.rooms = 8"
                            :class="{ 'text-red-500': this.filters.rooms === 8 }"
                            class="px-3 mr-3 mb-3 py-1 border rounded-full border-slate-300 capitalize hover:border-black"
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
                            :class="{ 'text-red-500': this.filters.beds === i }"
                            v-for="i in 7"
                            :key="i"
                            class="px-3 mr-3 mb-3 py-1 border rounded-full border-slate-300 capitalize hover:border-black"
                        >
                            {{ i }}
                        </button>
                        <button
                            @click="this.filters.beds = 8"
                            :class="{ 'text-red-500': this.filters.beds === 8 }"
                            class="px-3 mr-3 mb-3 py-1 border rounded-full border-slate-300 capitalize hover:border-black"
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
                                :class="{ 'text-red-500': this.filters.bathrooms === i }"
                                v-for="i in 3"
                                :key="i"
                                class="px-3 mr-3 mb-3 py-1 border rounded-full border-slate-300 capitalize hover:border-black"
                            >
                                {{ i }}
                            </button>
                            <button
                                @click="this.filters.bathrooms = 4"
                                :class="{ 'text-red-500': this.filters.bathrooms === 4 }"
                                class="px-3 mr-3 mb-3 py-1 border rounded-full border-slate-300 capitalize hover:border-black"
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


                        <div class="text-right cursor-pointer" @click="hideFilters = !hideFilters">
                            Close: <i class="px-1 fa-solid fa-chevron-up text-lg text-slate-400 hover:text-black"></i>
                        </div>
                    </div>

                    <div v-if="hideFilters" class="text-right cursor-pointer" @click="hideFilters = !hideFilters">
                        Additional Filters: <i class="px-1 fa-solid fa-chevron-down text-lg text-slate-400 hover:text-black"></i>
                    </div>

                    <hr class="mr-4 mb-12 mt-4">

                    <div class=" grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4" v-if="handleFilters.length != 0">
                        <Card
                            v-for="apartment in handleFilters[0]"
                            :key="apartment.id"
                            :apartment="apartment"
                            :is_sponsored="true"
                            class="mb-8"
                        />
                        <Card
                            v-for="apartment in handleFilters[1]"
                            :key="apartment.id"
                            :apartment="apartment"
                            :is_sponsored="false"
                            class="mb-8"
                        />
                    </div>
                    <div v-else>
                        <p>No apartments found.</p>
                    </div>

                </div>
                <div class="w-1/3 fixed top-[163px] right-0 border-l border-gray-200">
                    <div
                        id="map"
                        class="my-0 ml-3 lg:mr-20 rounded-2xl shadow"
                    ></div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<style>

#boxfilters{
    transition: 0.8s ease all;
}

#boxfilters.hide{
    transform: translateY(-100%);
    display: none;
}

#map{
    height: calc(100vh - 213px);
}

</style>
