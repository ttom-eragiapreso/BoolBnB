<script>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Slider from "@/Components/Slider.vue";
import tt from "@tomtom-international/web-sdk-maps";
import Card from "@/Components/Card.vue";

export default {
    name: "AdvancedSearch",
    components: {
        GuestLayout,
        Slider,
        Card,
    },
    data() {
        return {
            filters: {
                beds: 0,
                rooms: 0,
                bathrooms: 0,
                type_of_stay: null,
                features: [],
            },
            filtered_apartments: [],
        };
    },
    props: {
        types_of_stay: Array,
        apartments: Array,
        features: Array,
    },
    mounted() {
        this.filtered_apartments = this.apartments;

        const map = tt.map({
            key: "LyiQawx4xo4FpPG8VKyj3yHadh1WEDRM",
            container: "map",
            center: [12.492230901450688, 41.89027805140671],
            zoom: 15,
            style: "/satellitemap.json",
        });

        map.on("load", () => {
            let popup = new tt.Popup({
                closeButton: false,
                offset: 35,
                anchor: "bottom",
            }).setText("Colosseo");
            let marker = new tt.Marker()
                .setLngLat([12.492230901450688, 41.89027805140671])
                .setPopup(popup);
            marker.addTo(map);
            map.addControl(new tt.FullscreenControl());
            map.addControl(new tt.NavigationControl());
        });
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
        }
    },
    computed:{
        handleFilters(){

            this.filtered_apartments = this.apartments.filter((apartment) => {
                return apartment.beds >= this.filters.beds
                        && apartment.rooms >= this.filters.rooms
                        && apartment.bathrooms >= this.filters.bathrooms
                        && this.checkFeature(apartment)
            })
            return this.filtered_apartments;
        }
    },
};
</script>

<template>
    <GuestLayout>
        <div>
            <Slider :types_of_stay="types_of_stay" />
            <div class="py-4 lg:px-20 px-8 flex w-full">
                <div class="w-2/3">
                    <div>
                        <h3 class="text-2xl mb-3">Features:</h3>
                        <button
                            :class="{'text-red-500': this.filters.features.includes(feature.id)}"
                            @click="addFeature(feature.id)"
                            class="px-3 mr-3 mb-3 py-1 border rounded-full border-slate-300 capitalize hover:border-black"
                            v-for="feature in features"
                            :key="feature.id"
                        >
                            {{ feature.name }}
                        </button>

                        <h3 class="text-2xl mb-3">Rooms:</h3>

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

                        <h3 class="text-2xl mb-3">Beds:</h3>
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

                        <h3 class="text-2xl mb-3">Bathrooms:</h3>
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
                    </div>

                    <hr class="mr-4 mb-12 mt-4">

                    <div class="flex gap-4 flex-wrap">
                        <Card
                            v-for="apartment in handleFilters"
                            :key="apartment.id"
                            :apartment="apartment"
                            class="w-auto"
                        />
                    </div>
                </div>
                <div class="w-1/3">
                    <div
                        id="map"
                        class="my-0 h-[500px] rounded-2xl shadow-2xl"
                    ></div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<style></style>
