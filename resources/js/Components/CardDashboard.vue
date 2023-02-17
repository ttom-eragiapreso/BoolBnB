<template>
    <div class="container mx-auto flex">
        <!-- Img container -->
        <div class="w-72 aspect-square border rounded-xl overflow-hidden">
            <img
                :src="'/storage/' + apartment.cover_image"
                alt="cover image"
                class="h-full w-full object-cover"
            />
        </div>

        <div class="px-7 py-2 grow flex flex-col">
            <!-- Title -->
            <div class="flex justify-between">
                <h2 class="font-bold text-3xl">{{ apartment.title }}</h2>
            </div>
            <!-- Location -->
            <h5 class="text-slate-600">{{ apartment.full_address }}, {{ apartment.city }},  {{ apartment.country }}</h5>
            <!-- Price -->
            <h5 class="">
                <strong>{{ apartment.price }} &euro;</strong> / night
            </h5>
            <!-- Public -->
            <h5 class="text-slate-600 mb-auto">
                Is Public: <strong>{{ apartment.is_visible ? "Yes" : "No" }}</strong>
            </h5>
            <!-- Date -->
            <h5 class="text-slate-600">Created at: {{ apartment.created_at }}</h5>
            <h5 class="text-slate-600">Last update at: {{ apartment.updated_at }}</h5>
        </div>

        <div class="px-7 flex flex-col gap-5 justify-center">
            <Link
                :href="route('dashboard.apartment.show', apartment.slug)"
                as="button"
                class="px-6 py-3 bg-cyan-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-cyan-500 focus:bg-cyan-500 active:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                Show
            </Link>
            <Link
                :href="route('dashboard.apartment.edit', apartment.slug)"
                as="button"
                class="px-6 py-3 bg-amber-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-amber-500 focus:bg-amber-500 active:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                Edit
            </Link>
            <Link
                :href="route('dashboard.apartment.destroy', apartment)"
                method="delete"
                as="button"
                class="px-6 py-3 bg-red-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                Delete
            </Link>
        </div>
    </div>
</template>

<script>

import { Link } from "@inertiajs/vue3";

export default {
    name: "CardDashboard",
    props: {
        apartment: Object,
    },
    components: {
        Link,
    },
};
</script>
