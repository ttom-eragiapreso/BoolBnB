<template>
    <div class="container mx-auto flex justify-center">
        <div>
            <!-- Img container -->
            <div
                class="w-72 aspect-square border rounded-xl overflow-hidden relative"
            >
                <img
                    src="https://static.designboom.com/wp-content/uploads/2019/12/niko-architect-house-in-the-landscape-moscow-designboom-1800.jpg"
                    alt="Immagine"
                    class="h-full w-full object-cover"
                />

                <div class="absolute top-0 right-0 z-10 text-white p-3 text-xl">
                    <i class="fa-regular fa-heart"></i>
                </div>
            </div>
            <!-- Title and rating -->
            <div class="flex justify-between mt-3">
                <h2 class="font-bold">Roma, Italia</h2>
                <div>
                    <i class="fa-solid fa-star"></i>
                    <span>5</span>
                </div>
            </div>
            <!-- Vista -->
            <h5 class="text-slate-600">Vista sul vigneto</h5>
            <!-- Date -->
            <h5 class="text-slate-600">01-06 apr . Host Privato</h5>
            <!-- Price -->
            <h5 class="underline"><strong>550€ </strong>totale</h5>
        </div>
    </div>
</template>

<script setup></script>
