<script>

import AutoSearchTT from '../../../Components/AutoSearchTT.vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link, Head } from "@inertiajs/vue3";

export default {
    name: "Edit",
    props: {
        apartment: Object,
        features: Array,
        type_of_stays: Array
    },
    components: {
        Link,
        AuthenticatedLayout,
        AutoSearchTT,
        Head
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
                latitude: this.apartment.latitude,
                longitude: this.apartment.longitude,
                price: this.apartment.price,
                cover_image: null,
                gallery: null,
                description: this.apartment.description,
                features: [],
                type_of_stay_id: this.apartment.type_of_stay_id,
                is_visible: this.apartment.is_visible ? true : false,
                errors: null,
                oldGallery: {},
                _method: "patch",
            }),
        };
    },
    methods:{
        removeImage(index){
            this.form.oldGallery[index] = !this.form.oldGallery[index];
            // console.log(this.form.oldGallery);
        },
        handleGeoData(event){
            // console.log(event);
            this.form.city = event.city;
            this.form.country = event.country;
            this.form.full_address = event.full_address;
            this.form.latitude = event.lat;
            this.form.longitude = event.lng;
        },
        setTwoNumberDecimal(){
            this.form.price = parseFloat(this.form.price).toFixed(2);
        },
        handleFeatures(){
            this.apartment.features.forEach(feature => {
                this.form.features.push(feature.id)
            });
        }
    },
    mounted(){
        // popola un oggetto oldGallery che conterrà true se voglio tenere quell'immagine, false se la voglio cancellare
        this.apartment.images.forEach((image, index) => {
            this.form.oldGallery[index] = true;
        });

        this.handleFeatures();
    }
};
</script>

<template>

    <Head title="Edit Apartment"></Head>

    <AuthenticatedLayout>

        <template v-slot:header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Your Apartments - Edit {{ apartment.title }}</h2>
        </template>

        <div class="container py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4">

            <form
                @submit.prevent="form.post(route('dashboard.apartment.update', apartment))"
                enctype="multipart/form-data"
                class="flex flex-col gap-5 px-10"
            >

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
                <AutoSearchTT @geodata="handleGeoData" :address="this.form.full_address"/>
                <div v-if="$page.props.errors.full_address || $page.props.errors.city || $page.props.errors.country || $page.props.errors.latitude || $page.props.errors.longitude">
                    {{ $page.props.errors.full_address }}<br>Please, select an address from the dropdown.
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

                <img :src="'/storage/' + apartment.cover_image" alt="" class="w-20" />

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

                <div v-if="apartment.images" class="flex gap-3">
                    <div class="h-40 relative" :class="{grayscale : !form.oldGallery[index]}" v-for="(image, index) in apartment.images" :key="index">
                        <img
                            :src="'/storage/' + image.url"
                            alt="gallery_image"
                            class="h-full"
                        />
                        <div class="text-red-700 hover:text-red-600 absolute top-[-3px] right-2 font-bold text-5xl cursor-pointer" @click="removeImage(index)">&times;</div>
                    </div>
                </div>

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
                        <input type="checkbox" v-model="form.features" :checked="form.features.includes(feature.id)" :value="feature.id" :id="feature.name">
                        <label class="pl-2" :for="feature.name">{{ feature.name.charAt(0).toUpperCase() + feature.name.slice(1) }}</label>
                    </div>
                </div>

                <label for="types">Type*: </label>
                <div>
                    <select id="types" v-model="form.type_of_stay_id" required>
                        <!-- <option value="" selected disabled>Select a Type</option> -->
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

input + div, textarea + div{
    color: red;
}

</style>
