<script>

import AutoSearchTT from '../../../Components/AutoSearchTT.vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link, Head } from "@inertiajs/vue3";

export default {
    name: "Create",
    components: {
        Link,
        AuthenticatedLayout,
        AutoSearchTT,
        Head
    },
    props:{
        features: Array,
        type_of_stays: Array
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
                latitude: null,
                longitude: null,
                price: null,
                cover_image: null,
                description: null,
                is_visible: true,
                gallery: null,
                errors: null,
                type_of_stay_id: '',
                features: []
            })
        };
    },
    methods:{
        handleGeoData(event){
            this.form.city = event.city;
            this.form.country = event.country;
            this.form.full_address = event.full_address;
            this.form.latitude = event.lat;
            this.form.longitude = event.lng;
        },
        setTwoNumberDecimal(){
            this.form.price = parseFloat(this.form.price).toFixed(2);
        }
    }
};
</script>

<template>

    <Head title="Create Apartment" />

    <AuthenticatedLayout>

        <template v-slot:header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Your Apartments - Add New</h2>
        </template>

        <div class="container py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4">

            <form @submit.prevent="form.post(route('dashboard.apartment.store', form))" class="flex flex-col gap-5 px-10">

                <p>* Required</p>

                <label for="title">Title *</label>
                <input
                    id="title"
                    type="text"
                    v-model="form.title"
                    required
                    minlength="3"
                    maxlength="100"
                />
                <div v-if="$page.props.errors.title">
                    {{ $page.props.errors.title }}
                </div>

                <label for="rooms">Rooms *</label>
                <input
                    id="rooms"
                    type="number"
                    v-model="form.rooms"
                    required
                    min="0"
                    max="50"
                />
                <div v-if="$page.props.errors.rooms">
                    {{ $page.props.errors.rooms }}
                </div>

                <label for="beds">Beds *</label>
                <input
                    id="beds"
                    type="number"
                    v-model="form.beds"
                    required
                    min="0"
                    max="50"
                />
                <div v-if="$page.props.errors.beds">
                    {{ $page.props.errors.beds }}
                </div>

                <label for="bathrooms">Bathrooms *</label>
                <input
                    id="bathrooms"
                    type="number"
                    v-model="form.bathrooms"
                    required
                    min="0"
                    max="50"
                />
                <div v-if="$page.props.errors.bathrooms">
                    {{ $page.props.errors.bathrooms }}
                </div>

                <label for="square_meters">Square Meters *</label>
                <input
                    id="square_meters"
                    type="number"
                    v-model="form.square_meters"
                    required
                    min="0"
                    max="60000"
                />
                <div v-if="$page.props.errors.square_meters">
                    {{ $page.props.errors.square_meters }}
                </div>

                <label>Address *</label>
                <AutoSearchTT @geodata="handleGeoData"/>
                <div v-if="$page.props.errors.full_address || $page.props.errors.city || $page.props.errors.country || $page.props.errors.latitude || $page.props.errors.longitude">
                    {{ $page.props.errors.full_address }}
                    <br>
                    Please, select an address from the dropdown.
                </div>

                <label for="price">Price (&euro;) *</label>
                <input
                    id="price"
                    type="number"
                    v-model="form.price"
                    required
                    min="0"
                    max="90000"
                    step=".01"
                    @focusout="setTwoNumberDecimal()"
                    />
                <div v-if="$page.props.errors.price">
                    {{ $page.props.errors.price }}
                </div>

                <label for="cover_image">Cover Image *</label>
                <input
                    id="cover_image"
                    type="file"
                    @input="form.cover_image = $event.target.files[0]"
                    required
                    accept="image/*"
                />
                <progress
                    v-if="form.progress"
                    id="cover_image_progress"
                    :value="form.progress.percentage"
                    max="100"
                >
                    {{ form.progress.percentage }}%
                </progress>
                <div v-if="$page.props.errors.cover_image">
                    {{ $page.props.errors.cover_image }}
                </div>

                <label for="gallery">Additional Images</label>
                <input
                    type="file"
                    id="gallery"
                    multiple
                    @input="form.gallery = $event.target.files"
                    accept="image/*"
                />
                <progress
                    v-if="form.progress"
                    :value="form.progress.percentage"
                    max="100"
                >
                    {{ form.progress.percentage }}%
                </progress>

                <label for="description">Description *</label>
                <textarea
                    name="description"
                    id="description"
                    cols="30"
                    rows="10"
                    minlength="10"
                    required
                    v-model="form.description"
                ></textarea>
                <div v-if="$page.props.errors.description">
                    {{ $page.props.errors.description }}
                </div>

                <label for="features">Features: </label>
                <div class="grid grid-cols-4">
                    <div v-for="feature in features" :key="feature.id">
                        <input type="checkbox" v-model="form.features" :value="feature.id" :id="feature.name">
                        <label class="pl-2" :for="feature.name">{{ feature.name.charAt(0).toUpperCase() + feature.name.slice(1) }}</label>
                    </div>
                </div>

                <label for="types">Type*: </label>
                <div>
                    <select id="types" v-model="form.type_of_stay_id" required>
                        <option value="" selected disabled>Select a Type</option>
                        <option v-for="elem in type_of_stays" :key="elem.id" :value="elem.id">{{ elem.name }}</option>
                    </select>
                </div>
                <div v-if="$page.props.errors.type_of_stay_id">
                    {{ $page.props.errors.type_of_stay_id }}
                </div>

                <div>
                    <label for="is_visible" class="pr-3 text-black">Public: </label>
                    <input
                        type="checkbox"
                        name="is_visible"
                        id="is_visible"
                        v-model="form.is_visible"
                    />
                </div>

                <button type="submit" class="px-6 py-3 bg-yellow-500 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 focus:bg-yellow-400 active:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">Vai</button>

            </form>

        </div>

    </AuthenticatedLayout>

</template>

<style>

input + div, textarea + div, #searchbox + div{
    color: red;
}

</style>
