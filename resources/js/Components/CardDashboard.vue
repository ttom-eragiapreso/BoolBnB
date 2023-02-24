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
    <div class="mx-auto flex flex-col md:flex-row flex-wrap">
        <!-- Img container -->
        <div
            class="w-72 aspect-square border rounded-xl overflow-hidden md:m-2 mx-auto"
        >
            <img
                :src="'/storage/' + apartment.cover_image"
                alt="cover image"
                class="h-full w-full object-cover"
            />
        </div>

        <div
            class="px-2 lg:px-7 py-4 grow flex flex-col md:w-[280px] lg:w-[26rem] xl:w-[32rem]"
        >
            <!-- Title -->
            <div>
                <h2 class="font-bold text-3xl">
                    {{ apartment.title }}
                    <i v-if="handleSponsor" class="fa-solid fa-circle-up text-green-600"></i>
                </h2>
            </div>
            <!-- Location -->
            <h5 class="text-slate-600">
                {{ apartment.full_address }}, {{ apartment.city }},
                {{ apartment.country }}
            </h5>
            <!-- Price -->
            <h5 class="">
                <strong>{{ apartment.price }} &euro;</strong> / night
            </h5>
            <!-- Public -->
            <h5 class="text-slate-600 mb-auto">
                Is Public:
                <strong>{{ apartment.is_visible ? "Yes" : "No" }}</strong>
            </h5>
            <!-- Dates -->
            <h5 class="text-slate-600">Created at: {{ handleCreateDate }}</h5>
            <h5 class="text-slate-600">
                Last update at: {{ handleUpdateDate }}
            </h5>
        </div>

        <div
            class="lg:ml-auto py-2 sm:py-4 px-2 grid grid-cols-4 lg:flex lg:flex-col grow lg:grow-0 gap-4 justify-center"
        >
            <Link
                :href="route('dashboard.apartment.show', apartment.slug)"
                as="button"
                class="py-3 bg-cyan-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-cyan-500 focus:bg-cyan-500 active:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                <i class="fa-solid fa-circle-info text-sm"></i>
                <span class="hidden sm:inline">Show</span>
            </Link>
            <Link
                :href="route('dashboard.apartment.edit', apartment.slug)"
                as="button"
                class="py-3 bg-amber-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-amber-500 focus:bg-amber-500 active:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                <i class="fa-solid fa-sliders text-sm"></i>
                <span class="hidden sm:inline">Edit</span>
            </Link>
            <Link
                :href="route('dashboard.apartment.edit', apartment.slug)"
                as="button"
                class="py-3 bg-green-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                <i class="fa-solid fa-chart-simple text-sm"></i>
                <span class="hidden sm:inline">Stats</span>
            </Link>
            <!-- <button
            @click.prevent="remove(apartment)"
            class="px-1 md:px-8 py-3 bg-red-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                <i class="fa-solid fa-trash text-sm"></i> <span class="hidden sm:inline">Delete</span>
            </button> -->
            <DeleteButton @click="showModal = true" />
        </div>
    </div>
</template>

<script>
import { Link, router } from "@inertiajs/vue3";
import DeleteButton from "./DeleteButton.vue";
import Modal from "@/Components/Modal.vue";

export default {
    name: "CardDashboard",
    props: {
        apartment: Object,
    },
    data() {
        return {
            showModal: false,
        };
    },
    components: {
        Link,
        DeleteButton,
        Modal,
    },
    methods: {
        remove(apartment) {
            router.delete(route("dashboard.apartment.destroy", apartment));
        },
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
        handleSponsor(){
            return true
        }
    },
};
</script>
