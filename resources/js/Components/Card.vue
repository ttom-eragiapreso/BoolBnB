<template>
    <div class="container">
        <Link :href="route('details', apartment.slug)">
            <!-- Img container -->
            <div
                class="aspect-square border rounded-xl overflow-hidden relative cursor-pointer"
            >
                <swiper
                    class="w-full h-full"
                    :loop="true"
                    :mousewheel="{
                        forceToAxis: true,
                    }"
                    :pagination="{
                        clickable: true,
                        dynamicBullets: true,
                    }"
                >
                    <swiper-slide>
                        <img
                            :src="'/storage/' + apartment.cover_image"
                            alt="Immagine"
                            class="h-full w-full object-cover"
                        />
                    </swiper-slide>
                    <swiper-slide
                        v-for="image in apartment.images"
                        :key="image.id"
                    >
                        <img
                            :src="'/storage/' + image.url"
                            alt="Immagine"
                            class="h-full w-full object-cover"
                        />
                    </swiper-slide>
                </swiper>

                <div class="absolute top-0 right-0 z-10 text-white p-3 text-xl">
                    <i v-if="is_sponsored" class="fa-solid fa-award"></i>
                </div>
            </div>
            <!-- Title and rating -->
            <div class="flex justify-between mt-3">
                <h2 class="font-bold">
                    {{ apartment.city }}, {{ apartment.country }}
                </h2>
            </div>
            <!-- Vista -->
            <h5 class="text-slate-600 truncate">{{ apartment.title }}</h5>
            <!-- Price -->
            <h5 class="underline underline-offset-2">
                <strong>{{ apartment.price }} &euro; </strong> night
            </h5>
        </Link>
    </div>
</template>

<script>
import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Pagination } from "swiper";
import { Link, router } from "@inertiajs/vue3";

import "swiper/scss";
import "swiper/scss/navigation";
import "swiper/scss/pagination";
import "swiper/scss/scrollbar";
import "swiper/scss/mousewheel";

export default {
    components: {
        Swiper,
        SwiperSlide,
        Navigation,
        Pagination,
        Link,
    },
    props: {
        apartment: Object,
        is_sponsored: Boolean,
    },
    methods: {
        goToPage() {
            router.get(route("details", this.apartment.slug));
        },
    },
    created() {},
};
</script>
<style lang="scss">

.swiper-pagination-bullet-active {
    background-color: #fff !important;
    opacity: 1 !important;
    width: 9px;
    height: 9px;
}

.swiper-pagination-bullet{
    background-color: rgba(255, 255, 255);
    opacity: 0.7;
}

</style>
