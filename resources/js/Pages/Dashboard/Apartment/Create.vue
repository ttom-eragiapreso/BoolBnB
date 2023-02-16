<script>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";

export default {
    name: "Create",
    components: {
        Link,
        AuthenticatedLayout
    },
    data() {
        return {
            form: useForm({
                title: null,
                rooms: null,
                beds: null,
                bathrooms: null,
                square_meters: null,
                city: null,
                country: null,
                full_address: null,
                price: null,
                cover_image: null,
                description: null,
                is_visible: null,
                gallery: null,
                errors: null,
            }),
        };
    },
};
</script>

<template>

    <AuthenticatedLayout>

        <template v-slot:header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Your Apartments - Add New</h2>
        </template>

        <div class="container py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4">

            <form @submit.prevent="" class="flex flex-col gap-5 px-10">
                <label for="title">Title</label>
                <input id="title" type="text" v-model="form.title" />
                <div v-if="$page.props.errors.title">
                    {{ $page.props.errors.title }}
                </div>

                <label for="title">Rooms</label>
                <input type="number" v-model="form.rooms" />
                <div v-if="$page.props.errors.rooms">
                    {{ $page.props.errors.rooms }}
                </div>

                <label for="title">Beds</label>
                <input type="number" v-model="form.beds" />
                <div v-if="$page.props.errors.beds">{{ $page.props.errors.beds }}</div>

                <label for="title">Bathrooms</label>
                <input type="number" v-model="form.bathrooms" />
                <div v-if="$page.props.errors.bathrooms">
                    {{ $page.props.errors.bathrooms }}
                </div>

                <label for="title">Square Meters</label>
                <input type="number" v-model="form.square_meters" />
                <div v-if="$page.props.errors.square_meters">
                    {{ $page.props.errors.square_meters }}
                </div>

                <label for="title">City</label>
                <input type="text" v-model="form.city" />
                <div v-if="$page.props.errors.city">{{ $page.props.errors.city }}</div>

                <label for="title">Country</label>
                <input type="text" v-model="form.country" />
                <div v-if="$page.props.errors.country">
                    {{ $page.props.errors.country }}
                </div>

                <label for="title">Address</label>
                <input type="text" v-model="form.full_address" />
                <div v-if="$page.props.errors.full_address">
                    {{ $page.props.errors.full_address }}
                </div>

                <label for="title">Price</label>
                <input type="text" v-model="form.price" />
                <div v-if="$page.props.errors.price">
                    {{ $page.props.errors.price }}
                </div>

                <label for="title">Cover Image</label>
                <input type="file" @input="form.cover_image = $event.target.files[0]" />
                <progress
                    v-if="form.progress"
                    :value="form.progress.percentage"
                    max="100"
                >
                    {{ form.progress.percentage }}%
                </progress>

                <label for="title">Additional Images</label>
                <input
                    type="file"
                    multiple
                    @input="form.gallery = $event.target.files"
                />
                <progress
                    v-if="form.progress"
                    :value="form.progress.percentage"
                    max="100"
                >
                    {{ form.progress.percentage }}%
                </progress>

                <label for="title">Description</label>
                <textarea
                    name="description"
                    id="description"
                    cols="30"
                    rows="10"
                    v-model="form.description"
                ></textarea>
                <div v-if="$page.props.errors.description">
                    {{ $page.props.errors.description }}
                </div>

                <div>
                    <label for="is_visible" class="pr-3">Public: </label>
                    <input
                        type="checkbox"
                        name="is_visible"
                        id="is_visible"
                        v-model="form.is_visible"
                    />
                </div>

                <!-- submit -->
                <Link
                    as="button"
                    :href="route('dashboard.apartment.store')"
                    method="POST"
                    :data="this.form"
                    :disabled="form.processing"
                    class="px-6 py-3 bg-green-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >Create!
                </Link>

            </form>

        </div>

    </AuthenticatedLayout>

</template>

<style></style>
