<script>
import ApplicationLogo from "./ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import { Link, router } from "@inertiajs/vue3";
import AutoSearchTT from '../Components/AutoSearchTT.vue';
import {store} from '../data/store';

export default {
    name: "Header",
    data() {
        return {
            open: false,
            var: null,
            lat: null,
            lng: null,
            address: null,
            store
        };
    },
    components: {
        ApplicationLogo,
        Dropdown,
        DropdownLink,
        NavLink,
        AutoSearchTT
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean
    },
    methods: {
        goToAdvancedSearch(){
            router.get(route('advancedsearch', [this.lat, this.lng]));
        },
        handleGeoData(event){
           this.lat = event.lat;
           this.lng = event.lng;
           this.store.searched_address = event.full_address;

           this.goToAdvancedSearch();
        }
    },
};
</script>

<template>
    <header>
        <div
            class=" fixed top-0 left-0 bg-white z-20 w-screen h-[80px] border-b-[1px] flex justify-between items-center px-8 lg:px-20"
        >
            <div class="logo pr-4 h-auto cursor-grab flex items-center">
                <a href="/"><ApplicationLogo/></a>
            </div>

            <div class="relative">

                <AutoSearchTT @geodata="handleGeoData" idxSet="POI,Geo" class="lg:w-[300px] 2xl:w-[340px]" :address="this.store.searched_address"/>

            </div>

            <div class="relative lg:w-[168px] flex justify-end">

                <div class="ml-3 relative">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-6 h-6"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25"
                                        />
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownLink
                                :href="route('advancedsearch')"
                                as="button"
                            >
                                Advanced Search
                            </DropdownLink>

                            <hr>

                            <DropdownLink
                            v-if="$page.props.auth.user"
                                :href="route('profile.edit')"
                                as="button"
                            >
                                Profile
                            </DropdownLink>


                            <DropdownLink
                                v-if="$page.props.auth.user"
                                :href="route('dashboard.home')"
                                as="button"
                                >
                                Dashboard
                            </DropdownLink>

                            <DropdownLink
                                v-if="$page.props.auth.user"
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="text-red-700"
                            >
                                Log Out
                            </DropdownLink>

                            <template v-else>
                                <DropdownLink :href="route('login')"
                                    >Log in</DropdownLink
                                >

                                <DropdownLink :href="route('register')"
                                    >Register</DropdownLink
                                >
                            </template>
                        </template>
                    </Dropdown>
                </div>
            </div>
        </div>
    </header>
</template>

<style></style>
