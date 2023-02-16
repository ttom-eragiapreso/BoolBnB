<template>
    <div class="container mx-auto flex my-4">
        <!-- Img container -->
        <div class="w-72 aspect-square border rounded-xl overflow-hidden">
            <img
                :src="'/storage/' + apartment.cover_image"
                alt="cover image"
                class="h-full w-full object-cover"
            />
        </div>
        <div class="p-5">
            <!-- Title and rating -->
            <div class="flex justify-between">
                <h2 class="font-bold">{{ apartment.title }}</h2>
            </div>
            <!-- Vista -->
            <h5 class="text-slate-600">{{ apartment.full_address }}</h5>
            <!-- Date -->
            <h5 class="text-slate-600">
                Is Visible: {{ apartment.is_visible ? "Yes" : "No" }}
            </h5>
            <!-- Price -->
            <h5 class="underline">
                <strong>{{ apartment.price }} &euro;</strong> /night
            </h5>
            <h5 class="text-slate-600">{{ apartment.created_at }}</h5>
        </div>
        <div>
            <Link
                :href="route('dashboard.apartment.show', apartment.slug)"
                as="button"
            >
                Show
            </Link>
            <Link
                :href="route('dashboard.apartment.edit', apartment.slug)"
                as="button"
            >
                Edit
            </Link>
            <Link
                :href="route('dashboard.apartment.destroy', apartment)"
                method="delete"
                as="button"
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
