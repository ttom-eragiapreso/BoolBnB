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
            validExtensions: ['image/jpeg', 'image/jpg', 'image/png'],
            showCancel: true
        };
    },
    methods:{
        removeImage(index){
            this.form.oldGallery[index] = !this.form.oldGallery[index];
        },
        handleGeoData(event){
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
        },
        handleImages(){
            this.apartment.images.forEach((image, index) => {
                this.form.oldGallery[index] = true;
            });
        },
        displayFile(file){
            const dragArea = document.querySelector('#drop_cover');

            let fileType = file.type;

            if(this.validExtensions.includes(fileType)){
                this.form.cover_image = file;

                let fileReader = new FileReader();
                fileReader.onload = () => {
                    let fileUrl = fileReader.result;
                    const imageShow = document.getElementById('imageShow');
                    imageShow.src = fileUrl;
                    dragArea.classList.remove( 'bg-blue-200/50');
                    dragArea.classList.add('bg-gray-200/50');
                }
                fileReader.readAsDataURL(file);
                this.showCancel = true;

            } else {
                alert('This file is not an Image')
                dragArea.classList.remove( 'bg-blue-200/50');
                dragArea.classList.add('bg-gray-200/50');
            }
        },
        resetCoverInput(){
            this.showCancel = false;
            this.form.cover_image = null;
        },
        setUpDragArea(){
            const dragArea = document.querySelector('#drop_cover');
            const dragText = document.querySelector('#drop_text');
            const browseBtn = document.querySelector('#browse_btn');
            const browseInput = document.querySelector('#cover_image');

            let file;

            browseBtn.onclick = () => {
                browseInput.click();
            }

            browseInput.addEventListener('change', (event) => {
                this.displayFile(this.form.cover_image);
            })

            dragArea.addEventListener('dragover', (event) => {
                event.preventDefault();
                dragText.textContent = 'Release to Upload!';
                dragArea.classList.remove('bg-gray-200/50')
                dragArea.classList.add('bg-blue-200/50')
            })

            dragArea.addEventListener('dragleave', () => {
                dragText.textContent = 'Drag an image here!';
                dragArea.classList.remove( 'bg-blue-200/50')
                dragArea.classList.add('bg-gray-200/50')
            })

            dragArea.addEventListener('drop', (event) => {
                event.preventDefault();
                file = event.dataTransfer.files[0];
                this.displayFile(file);
            })
        }
    },
    computed:{
        titleChar(){
            return this.form.title.length;
        },
        descrChar(){
            return this.form.description.length;
        }
    },
    mounted(){
        // popola un oggetto oldGallery che conterrà true se voglio tenere quell'immagine, false se la voglio cancellare
        this.handleImages();

        this.handleFeatures();

        this.setUpDragArea();
    }
};
</script>

<template>

    <Head title="Edit Apartment"></Head>

    <AuthenticatedLayout>

        <template v-slot:header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Your Apartments - Edit {{ apartment.title }}</h2>
        </template>

        <div class="container py-6 mt-12 max-w-[95%] px-4 mx-auto sm:px-6 lg:px-8 bg-white rounded-xl my-4">

            <form
                @submit.prevent="form.post(route('dashboard.apartment.update', apartment))"
                enctype="multipart/form-data"
                class="flex flex-col px-10"
            >

                <p class="mb-6">* Required</p>

                <label for="title" class="mb-1">Title: *</label>
                <div class="mb-3">
                    <input
                        id="title"
                        type="text"
                        v-model="form.title"
                        required
                        minlength="3"
                        maxlength="100"
                        autofocus
                        class="rounded-lg my-2 w-full"
                        placeholder="Ex. Awsome seaside apartment"
                    />
                    <p class=" text-slate-500 text-xs text-right">{{ titleChar }}/100</p>
                </div>
                <div v-if="$page.props.errors.title" class="mb-3 error">
                    {{ $page.props.errors.title }}
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">

                    <div>
                        <label for="rooms" class="mb-1">Rooms: *</label>
                        <div class="mb-3">
                            <button @click.prevent="this.form.rooms--" :disabled="this.form.rooms === 0"><i class="fa-solid fa-minus text-sm text-stone-600 hover:text-stone-800 border-[1px] border-stone-400 hover:border-stone-900 rounded-full w-8 h-8 flex justify-center items-center" :class="{'opacity-30 hover:cursor-not-allowed': this.form.rooms === 0}"></i></button>
                            <input
                            id="rooms"
                            type="number"
                            v-model="form.rooms"
                            required
                            min="0"
                                max="50"
                                class="rounded-lg my-2 mx-1 w-12 text-center border-0 focus:ring-0"
                                />
                                <button @click.prevent="this.form.rooms++" :disabled="this.form.rooms === 50"><i class="fa-solid fa-plus text-sm text-stone-600 hover:text-stone-800 border-[1px] border-stone-400 hover:border-stone-900 rounded-full w-8 h-8 flex justify-center items-center" :class="{'opacity-30 hover:cursor-not-allowed': this.form.rooms === 50}"></i></button>
                        </div>
                        <div v-if="$page.props.errors.rooms" class="mb-3 error">
                            {{ $page.props.errors.rooms }}
                        </div>
                    </div>

                    <div class="sm:justify-self-center">
                        <label for="beds" class="mb-1">Beds: *</label>
                        <div class="mb-3">
                            <button @click.prevent="this.form.beds--" :disabled="this.form.beds === 0"><i class="fa-solid fa-minus text-sm text-stone-600 hover:text-stone-800 border-[1px] border-stone-400 hover:border-stone-900 rounded-full w-8 h-8 flex justify-center items-center" :class="{'opacity-30 hover:cursor-not-allowed': this.form.beds === 0}"></i></button>
                            <input
                            id="beds"
                            type="number"
                            v-model="form.beds"
                            required
                            min="0"
                                max="50"
                                class="rounded-lg my-2 mx-1 w-12 text-center border-0 focus:ring-0"
                                />
                                <button @click.prevent="this.form.beds++" :disabled="this.form.beds === 50"><i class="fa-solid fa-plus text-sm text-stone-600 hover:text-stone-800 border-[1px] border-stone-400 hover:border-stone-900 rounded-full w-8 h-8 flex justify-center items-center" :class="{'opacity-30 hover:cursor-not-allowed': this.form.beds === 50}"></i></button>
                            </div>
                            <div v-if="$page.props.errors.beds" class="mb-3 error">
                            {{ $page.props.errors.beds }}
                        </div>
                    </div>

                    <div class="sm:justify-self-end">
                        <label for="bathrooms" class="mb-1">Bathrooms: *</label>
                        <div class="mb-3">
                            <button @click.prevent="this.form.bathrooms--" :disabled="this.form.bathrooms === 0"><i class="fa-solid fa-minus text-sm text-stone-600 hover:text-stone-800 border-[1px] border-stone-400 hover:border-stone-900 rounded-full w-8 h-8 flex justify-center items-center" :class="{'opacity-30 hover:cursor-not-allowed': this.form.bathrooms === 0}"></i></button>
                            <input
                            id="bathrooms"
                                type="number"
                                v-model="form.bathrooms"
                                required
                                min="0"
                                max="50"
                                class="rounded-lg my-2 mx-1 w-12 text-center border-0 focus:ring-0"
                                />
                                <button @click.prevent="this.form.bathrooms++" :disabled="this.form.bathrooms === 50"><i class="fa-solid fa-plus text-sm text-stone-600 hover:text-stone-800 border-[1px] border-stone-400 hover:border-stone-900 rounded-full w-8 h-8 flex justify-center items-center" :class="{'opacity-30 hover:cursor-not-allowed': this.form.bathrooms === 50}"></i></button>
                        </div>
                        <div v-if="$page.props.errors.bathrooms" class="mb-3 error">
                            {{ $page.props.errors.bathrooms }}
                        </div>
                    </div>

                </div>

                <label for="square_meters" class="mb-1">Square Meters: *</label>
                <div class="mb-3 flex">
                    <input
                    id="square_meters"
                    type="number"
                    v-model="form.square_meters"
                        required
                        min="0"
                        max="60000"
                        class="rounded-l-lg my-2 grow"
                        placeholder="Ex. 30"
                    />
                    <p class="inline-block my-2 py-2 px-3 text-base h-[42px] border-y-[1px] border-r-[1px] rounded-r-lg border-solid border-[#6b7280]">&#13217;</p>
                </div>
                <div v-if="$page.props.errors.square_meters" class="mb-3 error">
                    {{ $page.props.errors.square_meters }}
                </div>

                <label class="mb-1">Address: *</label>
                <AutoSearchTT @geodata="handleGeoData" :address="this.form.full_address" idxSet="Str" class="mb-3"/>
                <div v-if="$page.props.errors.full_address || $page.props.errors.city || $page.props.errors.country || $page.props.errors.latitude || $page.props.errors.longitude" class="mb-3 error">
                    {{ $page.props.errors.full_address }}<br>Please, select an address from the dropdown.
                </div>

                <label for="price" class="mb-1">Price (&euro;): *</label>
                <div class="mb-3">
                    <input
                        id="price"
                        type="number"
                        v-model="form.price"
                        required
                        min="0"
                        max="90000"
                        step=".01"
                        class="rounded-lg my-2 w-full font-semibold"
                        @focusout="setTwoNumberDecimal()"
                        placeholder="Ex. 25.00"
                        />
                    <p class=" text-slate-500 text-sm text-right">/per night</p>
                </div>
                <div v-if="$page.props.errors.price" class="mb-3 error">
                    {{ $page.props.errors.price }}
                </div>


                <label for="cover_image" class="mb-1">Cover Image: *</label>
                <div class="mb-5 mt-2 flex flex-col">
                    <div id="drop_cover" class="w-full bg-gray-200/50 h-80 my-1 border-[1px] border-dashed rounded-lg border-[#6b7280] flex items-center justify-center flex-col">
                        <p v-show="!showCancel" id="drop_text" class="user-select-none">Drag an image here!</p>
                        <p v-show="!showCancel"> or <span id="browse_btn" class="text-blue-500 font-bold cursor-pointer hover:underline">browse.</span></p>
                        <input
                            id="cover_image"
                            type="file"
                            @input="form.cover_image = $event.target.files[0]"
                            accept="image/*"
                            hidden
                        />
                        <img id="imageShow" v-if="showCancel" :src="'/storage/' + apartment.cover_image" alt="Cover image">
                    </div>
                    <button class="text-red-700 underline text-sm cursor-pointer self-end" @click.prevent="resetCoverInput()" :disabled="!showCancel">cancel</button>
                </div>
                <progress
                    v-if="form.progress"
                    id="cover_image_progress"
                    :value="form.progress.percentage"
                    max="100"
                    class="mb-3"
                >
                    {{ form.progress.percentage }}%
                </progress>
                <div v-if="$page.props.errors.cover_image" class="mb-3 error">
                    {{ $page.props.errors.cover_image }}
                </div>


                <label for="gallery" class="mb-1">Additional Images:</label>
                <div class="my-3">
                    <input
                        type="file"
                        id="gallery"
                        multiple
                        @input="form.gallery = $event.target.files"
                        accept="image/*"
                    />
                </div>
                <progress
                    v-if="form.progress"
                    :value="form.progress.percentage"
                    max="100"
                >
                    {{ form.progress.percentage }}%
                </progress>

                <div v-if="apartment.images" class="flex gap-3 mt-2 mb-6">
                    <div class="h-40 relative" :class="{grayscale : !form.oldGallery[index]}" v-for="(image, index) in apartment.images" :key="index">
                        <img
                            :src="'/storage/' + image.url"
                            alt="gallery_image"
                            class="h-full"
                        />
                        <div class="text-red-700 hover:text-red-600 absolute top-[-3px] right-2 font-bold text-5xl cursor-pointer" @click="removeImage(index)">&times;</div>
                    </div>
                </div>

                <label for="description" class="mb-1">Description: *</label>
                <div class="mb-3">
                    <textarea
                        name="description"
                        id="description"
                        cols="30"
                        rows="10"
                        minlength="10"
                        maxlength="1000"
                        required
                        v-model="form.description"
                        class="rounded-lg my-2 w-full"
                        placeholder="Ex. It's a beautiful apartment near the sea."
                    ></textarea>
                    <p class=" text-slate-500 text-xs text-right">{{ descrChar }}/1000</p>
                </div>
                <div v-if="$page.props.errors.description" class="mb-3 error">
                    {{ $page.props.errors.description }}
                </div>

                <label for="features" class="mb-1">Features: </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 mt-1 mb-3">
                    <div v-for="feature in features" :key="feature.id" class="my-1">
                        <input type="checkbox" v-model="form.features" :value="feature.id" :id="feature.name" class="rounded w-5 h-5">
                        <label class="pl-2" :for="feature.name">{{ feature.name.charAt(0).toUpperCase() + feature.name.slice(1) }}</label>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 my-4">

                    <div class="flex items-center mb-4 mr-3">
                        <label for="types" class="pr-4">Type*: </label>
                        <div>
                            <select id="types" v-model="form.type_of_stay_id" class="rounded-lg" required>
                                <option value="" selected disabled>Select a Type</option>
                                <option v-for="elem in type_of_stays" :key="elem.id" :value="elem.id">{{ elem.name }}</option>
                            </select>
                        </div>
                        <div v-if="$page.props.errors.type_of_stay_id" class="mb-3 error">
                            {{ $page.props.errors.type_of_stay_id }}
                        </div>
                    </div>

                    <div class="flex items-center mb-4 mr-1 sm:justify-self-end">
                        <div>
                            <label for="is_visible" class="pr-3 text-black">Public: </label>
                            <input
                                type="checkbox"
                                name="is_visible"
                                id="is_visible"
                                class="rounded w-5 h-5"
                                v-model="form.is_visible"
                            />
                        </div>
                    </div>
                </div>

                <div class="w-full flex gap-2 my-4">
                    <Link :href="route('dashboard.apartment.index')"
                            as="button" class="px-10 py-3 bg-blue-500 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-400 focus:bg-blue-400 active:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Back
                    </Link>

                    <button type="submit" class="px-6 py-3 bg-yellow-500 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 focus:bg-yellow-400 active:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150 grow">Update!</button>
                </div>

            </form>

        </div>

    </AuthenticatedLayout>

</template>

<style>

input + div, textarea + div, #searchbox + div, .error{
    color: red;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number]{
  -moz-appearance: textfield;
  appearance: textfield;
}

#drop_cover img{
    width: 100%;
    height: 100%;
    object-fit: contain;
}

</style>
