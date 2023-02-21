<script>
import GuestLayout from "@/Layouts/GuestLayout.vue";
export default {
    name: "Details",
    components: {
        GuestLayout,
    },
    props: {
        apartment: Object,
        user: String
    },
};
</script>

<template>
    <GuestLayout>



        <div
            class="container max-w-7xl mx-auto sm:px-6 bg-white sm:rounded-xl my-4 px-8 lg:px-20 pb-4"
        >
            <h1 class="text-3xl pb-2 font-bold">{{ apartment.title }}</h1>
            <p class=" mb-4 font-bold underline"> &#8669;
                {{ apartment.full_address }}, {{ apartment.city }},
                {{ apartment.country }}
            </p>

            <div class="flex">
                <div class="pb-2 mb-4 w-[50%]">
                    <img
                        :src="'/storage/' + apartment.cover_image"
                        alt="cover"
                        class="w-full h-[350px] rounded-l-2xl p-1 hover:brightness-75"
                    />
                </div>
                <div class="w-[50%] flex flex-wrap rounded-r-2xl overflow-hidden h-[350px]">
                        <img
                            v-for="(image, id) in apartment.images"
                            :key="id"
                            :src="'/storage/' + image.url"
                            alt="image_galler"
                            class="w-[50%] h-[175px] px-1 hover:brightness-75"
                        />
                </div>
            </div>

            <div class="flex gap-20">
                <div class="w-[60%]">
                    <div class="pb-4 mb-4 border-b">
                        <h2 class="text-2xl pb-2 font-bold">Apartment hosted by: {{ user }}</h2>
                        <p>2 guests &middot; {{ apartment.rooms }} room &middot; {{ apartment.beds }} bed &middot; {{ apartment.bathrooms }} &middot; bathroom &middot; {{ apartment.square_meters }}&#13217;</p>
                    </div>
                    <div class="pb-4 mb-4 border-b">
                        <h2 class="text-2xl pb-2 font-bold">Description</h2>
                        <p>{{ apartment.description }}</p>
                    </div>
                </div>
                <div class="w-[40%]">
                    <div class="border rounded-xl h-[500px] p-4 shadow-lg hover:shadow-xl">
                        Prezzo <br>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia, et! Neque molestiae non ipsum nostrum, at dignissimos quasi incidunt similique placeat voluptatum eaque harum pariatur nisi sed minima, quidem libero.
                    </div>
                </div>
            </div>

        </div>

        <div
            class="container py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4">
            <div
                id="map"
                class="mx-auto my-8 w-10/12 h-[500px] rounded-2xl shadow-2xl"
            ></div>
        </div>

        <div
            class="container mb-20 py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl my-4">
            <button>Invia Messaggio</button>
        </div>

    </GuestLayout>
</template>

<style></style>
