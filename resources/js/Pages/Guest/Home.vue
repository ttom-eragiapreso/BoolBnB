<script>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Slider from "@/Components/Slider.vue";
import Card from "@/Components/Card.vue";
import { store } from "../../data/store";
import { Head } from "@inertiajs/vue3";

export default {
    name: "Home",
    components: {
        GuestLayout,
        Slider,
        Card,
        Head,
    },
    data() {
        return {
            filtered_sponsored_apartments: [],
            filtered_non_sponsored_apartments: [],
            store,
            lower_limit: 0,
            upper_limit: 24,
        };
    },
    props: {
        types_of_stay: Array,
        non_sponsored_apartments: Object,
        sponsored_apartments: Object,
    },
    computed: {
        handleFilters() {
            this.filtered_sponsored_apartments = Object.values(
                this.sponsored_apartments
            ).filter((sponsored_apartment) => {
                return this.store.filtered_type == null
                    ? true
                    : sponsored_apartment.type_of_stay_id ==
                          this.store.filtered_type;
            });

            this.filtered_non_sponsored_apartments = Object.values(
                this.non_sponsored_apartments
            ).filter((non_sponsored_apartment) => {
                return this.store.filtered_type == null
                    ? true
                    : non_sponsored_apartment.type_of_stay_id ==
                          this.store.filtered_type;
            });

            return [
                this.filtered_sponsored_apartments,
                this.filtered_non_sponsored_apartments,
            ];
        },
        showLoad() {
            return (
                this.filtered_non_sponsored_apartments.length > this.upper_limit
            );
        },
    },
    created() {
        this.filtered_sponsored_apartments = this.sponsored_apartments;
        this.filtered_non_sponsored_apartments = this.non_sponsored_apartments;
    },
    methods: {
        loadMore() {
            this.filtered_non_sponsored_apartments.length - this.upper_limit >
            24
                ? (this.upper_limit += 24)
                : (this.upper_limit =
                      this.filtered_non_sponsored_apartments.length);
        },
    },
};
</script>

<template>
    <Head title="Vacation Homes & Condo Rentals" />
    <GuestLayout>
        <Slider :types_of_stay="types_of_stay" />
        <div
            v-if="$page.props.flash.message"
            class="container py-6 max-w-[76rem] mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl mt-[180px] mb-[-32px] flex justify-between items-center"
        >
            <h5 class="align-middle font-semibold text-red-600">
                {{ $page.props.flash.message }}
            </h5>
        </div>

        <div
            class="w-full px-6 sm:px-6 lg:px-8 mt-[180px] py-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6"
        >
            <Card
                v-for="apartment in handleFilters[0].slice(0, upper_limit)"
                :key="apartment.id"
                :apartment="apartment"
                :is_sponsored="true"
                class="w-auto justify-self-center mb-8"
            />
            <Card
                v-for="non_sponsored_apartment in handleFilters[1].slice(
                    0,
                    upper_limit
                )"
                :key="non_sponsored_apartment.id"
                :apartment="non_sponsored_apartment"
                :is_sponsored="false"
                class="w-auto justify-self-center mb-8"
            />
        </div>
        <button @click="loadMore" class="py-4" v-if="showLoad">
            Load More
        </button>
    </GuestLayout>
</template>

<style></style>
