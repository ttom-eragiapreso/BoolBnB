<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import PieChart from "@/Components/PieChart.vue";

export default {
    name: "Home",
    components: {
        Head,
        AuthenticatedLayout,
        PieChart,
        PieChart,
    },
    props: {
        num_apartments: Number,
        num_messages: Number,
        num_active_apartments: Number,
        num_messages_today: Number,
        data: Object,
    },
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="pt-12">
            <div class="max-w-7xl mx-2 sm:mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6 text-lg font-semibold">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div>

        <div
            class="pt-4 gap-4 my_container md:max-w-7xl mx-2 sm:mx-auto sm:px-6 lg:px-8 text-gray-900"
        >
            <div
                id="box-a"
                class="w-full bg-white overflow-hidden shadow-sm rounded-lg"
            >
                <div class="p-6">
                    <p class="flex justify-center sm:justify-start items-center py-2 text-lg">
                        <i
                            class="fa-solid fa-comment text-5xl mr-4 text-yellow-400"
                        ></i
                        ><span class="hidden md:block">have received</span><span class="font-bold mx-2">
                            {{ num_messages_today }}
                        </span>
                        <span class="hidden sm:block">message{{ num_messages_today > 1 ? "s" : "" }} today!</span>
                    </p>
                    <p class="flex justify-center sm:justify-start items-center py-2 text-lg">
                        <i
                            class="fa-solid fa-comments text-5xl mr-4 text-orange-700"
                        ></i
                        ><span class="hidden md:block">In total you have received</span>
                        <span class="font-bold mx-2"> {{ num_messages }} </span>
                        <span class="hidden sm:block">message{{ num_messages > 1 ? "s" : "" }}.</span>
                    </p>
                </div>
            </div>
            <div
                id="box-b"
                class="w-full bg-white overflow-hidden shadow-sm rounded-lg"
            >
                <div class="p-6 text-gray-900">
                    <h2 class="text-center text-xl sm:text-3xl">
                        Number of views per apartment
                    </h2>
                    <PieChart :my_data="data" />
                </div>
            </div>
            <div
                id="box-c"
                class="w-full bg-white overflow-hidden shadow-sm rounded-lg"
            >
                <div class="p-6">
                    <p class="flex justify-center sm:justify-start items-center py-2 text-lg">
                        <i
                            class="fa-solid fa-house text-5xl mr-4 text-blue-700"
                        ></i
                        ><span class="hidden md:block">You have a total of</span>
                        <span class="font-bold mx-2">
                            {{ num_apartments }}
                        </span>
                        <span class="hidden sm:block">apartment{{ num_apartments > 1 ? "s" : "" }} registered!</span>
                    </p>
                    <p class="flex justify-center sm:justify-start items-center py-2 text-lg">
                        <i
                            class="fa-solid fa-house-circle-check text-5xl mr-4 text-emerald-700"
                        ></i
                        ><span class="hidden md:block">Of these apartment{{
                            num_active_apartments > 1 ? "s" : ""
                        }}</span>
                        <span class="font-bold mx-2">
                            {{ num_active_apartments }}
                        </span>
                        <span class="hidden sm:block">are public!</span>
                    </p>
                </div>
            </div>
            <div
                id="box-d"
                class="w-full bg-white overflow-hidden shadow-sm sm:rounded-lg"
            >
                <div class="p-6 text-gray-900">D</div>
            </div>
            <div
                id="box-e"
                class="w-full bg-white overflow-hidden shadow-sm sm:rounded-lg"
            >
                <div class="p-6 text-gray-900">E</div>
            </div>
            <div
                id="box-f"
                class="w-full bg-white overflow-hidden shadow-sm sm:rounded-lg"
            >
                <div class="p-6 text-gray-900">F</div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
#box-a {
    grid-area: a;
}
#box-b {
    grid-area: b;
}
#box-c {
    grid-area: c;
}
#box-d {
    grid-area: d;
}
#box-e {
    grid-area: e;
}
#box-f {
    grid-area: f;
}

.my_container {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    grid-template-rows: auto;
    grid-template-areas:
        "a a b b"
        "c c b b"
        "c c d d"
        "e f d d";
}
</style>
