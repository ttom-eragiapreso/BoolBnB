<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";

export default {
    name: "Edit",
    layout: AuthenticatedLayout,
    props: {
        apartment: Object,
    },
    components: {
        Link,
    },
    data() {
        return {
            form: useForm({
                title: this.apartment.title,
                rooms: this.apartment.rooms,
                beds: this.apartment.beds,
                bathrooms: this.apartment.bathrooms,
                square_meters: this.apartment.square_meters,
                city: this.apartment.city,
                country: this.apartment.country,
                full_address: this.apartment.full_address,
                price: this.apartment.price,
                cover_image: null,
                description: this.apartment.description,
                is_visible: this.apartment.is_visible,
                gallery: null,
                errors: null,
                _method: "patch",
            }),
        };
    },
    methods: {
        submit() {},
    },
};
</script>

<template>
    <h1>Edit</h1>
    <form
        @submit.prevent="
            form.post(route('dashboard.apartment.update', apartment))
        "
        enctype="multipart/form-data"
        class="flex flex-col gap-5 px-10"
    >
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

        <img :src="'/storage/' + apartment.cover_image" alt="" class="w-20" />

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

        <div v-if="apartment.images" class="flex">
            <img
                v-for="image in apartment.images"
                :src="'/storage/' + image.url"
                alt=""
                class="w-20 px-3"
            />
        </div>

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

        <label for="title">Public</label>
        <input
            type="checkbox"
            name="is_visible"
            id="is_visible"
            v-model="form.is_visible"
        />

        <!-- submit -->
        <!-- <Link
            as="button"
            :href="route('dashboard.apartment.update', apartment)"
            method="PATCH"
            :data="form"
            :disabled="form.processing"
            >Create!</Link> -->
        <button type="submit">Vai</button>
    </form>
</template>

<style></style>
