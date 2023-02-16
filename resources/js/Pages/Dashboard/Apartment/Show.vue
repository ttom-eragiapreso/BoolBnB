<script>
import AuthenticatedLayoutVue from "@/Layouts/AuthenticatedLayout.vue";
import tt from "@tomtom-international/web-sdk-maps";

export default {
    name: "Show",
    layout: AuthenticatedLayoutVue,
    props: {
        apartment: Object,
    },
    data() {
        return {
            center: [12.4924, 41.8901],
        };
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
        });
    },
};
</script>

<template>
    <div class="container">
        <h1>{{ apartment.title }}</h1>
        <div class="gallery">
            <img :src="'/storage/' + apartment.cover_image" alt="cover" />
        </div>
        <p>Rooms: {{ apartment.rooms }}</p>
        <p>Beds: {{ apartment.beds }}</p>
        <p>Bathrooms: {{ apartment.bathrooms }}</p>
        <p>Square Meters: {{ apartment.square_meters }}</p>
        <p>
            {{ apartment.full_address }}, {{ apartment.city }},
            {{ apartment.country }}
        </p>

        <div id="map" class="mx-auto my-8 w-10/12 h-[500px]"></div>

        <h5>Price: {{ apartment.price }}</h5>
        <p>{{ apartment.description }}</p>
        <p>Creato il {{ apartment.created_at }}</p>
        <p>Ultima modifica il {{ apartment.updated_at }}</p>
    </div>

    <img
        v-for="image in apartment.images"
        :src="'/storage/' + image.url"
        alt=""
    />
</template>

<style lang="scss" scoped></style>
