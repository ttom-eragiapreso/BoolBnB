<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";

export default {
    name: "Edit",
    props: {
        apartment: Object,
    },
    components: {
        Link,
        AuthenticatedLayout
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
                oldGallery: {},
                _method: "patch",
            }),
        };
    },
    methods:{
        removeImage(index){
            this.form.oldGallery[index] = !this.form.oldGallery[index];
            // console.log(this.form.oldGallery);
        }
    },
    mounted(){
        // popola un oggetto oldGallery che conterrà true se voglio tenere quell'immagine, false se la voglio cancellare
        this.apartment.images.forEach((image, index) => {
            this.form.oldGallery[index] = true;
        });
        // console.log(this.form.oldGallery);
    }
};
</script>

<template>

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
                <!-- <Link
                    as="button"
                    :href="route('dashboard.apartment.update', apartment)"
                    method="PATCH"
                    :data="form"
                    :disabled="form.processing"
                    >Create!</Link> -->
                <button type="submit" class="px-6 py-3 bg-yellow-500 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 focus:bg-yellow-400 active:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">Vai</button>
            </form>

        </div>

    </AuthenticatedLayout>

</template>

<style>

input + div{
    color: red;
}

</style>
