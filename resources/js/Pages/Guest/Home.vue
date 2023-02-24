<script>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import Slider from "@/Components/Slider.vue";
import Card from "@/Components/Card.vue";
import {store} from '../../data/store';

export default {
    name: "Home",
    components: {
        GuestLayout,
        Slider,
        Card,
    },
    data(){
        return{
            filtered_sponsored_apartments: [],
            filtered_non_sponsored_apartments: [],
            store,
        }
    },
    props: {
        types_of_stay: Array,

        non_sponsored_apartments: Object,
        sponsored_apartments: Array,
    },
    computed:{
        handleFilters(){

            this.filtered_sponsored_apartments = this.sponsored_apartments.filter((sponsored_apartment) => {
                return (this.store.filtered_type == null ? true : sponsored_apartment.type_of_stay_id == this.store.filtered_type)
            });

            this.filtered_non_sponsored_apartments = Object.values(this.non_sponsored_apartments).filter((non_sponsored_apartment) => {
                return (this.store.filtered_type == null ? true : non_sponsored_apartment.type_of_stay_id == this.store.filtered_type)
            })

            return [
                this.filtered_sponsored_apartments,
                this.filtered_non_sponsored_apartments
            ]
        }
    },
    mounted(){
        this.filtered_sponsored_apartments = this.sponsored_apartments;
        this.filtered_non_sponsored_apartments = this.non_sponsored_apartments;
    }
};
</script>

<template>
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

        <div class=" w-full px-6 sm:px-6 lg:px-8 mt-[180px] py-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">
            <Card
                v-for="apartment in handleFilters[0]"
                :key="apartment.id"
                :apartment="apartment"
                :is_sponsored="true"
                class="w-auto justify-self-center mb-8"
            />
            <Card
                v-for="non_sponsored_apartment in handleFilters[1]"
                :key="non_sponsored_apartment.id"
                :apartment="non_sponsored_apartment"
                :is_sponsored="false"
                class="w-auto justify-self-center mb-8"
            />
        </div>
    </GuestLayout>
</template>

<style></style>
