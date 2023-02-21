<script>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Slider from "@/Components/Slider.vue";
import tt from "@tomtom-international/web-sdk-maps";
import Card from "@/Components/Card.vue";
import TextInput from '@/Components/TextInput.vue';
import {Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import Checkbox from '@/Components/Checkbox.vue';


export default {
    name: "AdvancedSearch",
    components: {
        GuestLayout,
        Slider,
        Card
    },
    data(){
        return {
            form: useForm({

            })
        }
    },
    props: {
        types_of_stay: Array,
        apartments: Array,
    },
    mounted() {
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
            }).setText('Colosseo');
            let marker = new tt.Marker()
                .setLngLat([12.492230901450688, 41.89027805140671])
                .setPopup(popup);
            marker.addTo(map);
            map.addControl(new tt.FullscreenControl);
            map.addControl(new tt.NavigationControl);
        });

    },
};
</script>
<!-- 41.89027805140671, 12.492230901450688 -->

<template>
    <GuestLayout>
        <div class="bg-white">

            <Slider :types_of_stay="types_of_stay" />
            <div class="py-4 lg:px-20 px-8  flex w-full">
                <div class=" w-2/3">
                    <form action="">

                    </form>

                    <div class="flex gap-4 flex-wrap">
                        <Card
                            v-for="apartment in apartments"
                            :key="apartment.id"
                            :apartment="apartment"
                            class="w-auto"
                        />
                    </div>
                </div>
                <div class="w-1/3">

                    <div
                    id="map"
                    class=" my-0 h-[500px]  rounded-2xl shadow-2xl"
                    >
                    </div>
                </div>

            </div>
        </div>

    </GuestLayout>
</template>

<style></style>
