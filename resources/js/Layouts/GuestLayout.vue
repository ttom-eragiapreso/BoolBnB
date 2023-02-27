<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Header from '@/Components/Header.vue';
import Footer from '@/Components/Footer.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>

    <Header/>


    <div class=" mt-[80px] min-h-screen pt-6 sm:pt-0 pb-10 bg-white">

    <div class="min-h-screen pt-6 sm:pt-0 bg-white">

        <!-- Message box -->
        <div
                v-if="$page.props.flash.message"
                class="container py-6 max-w-[76rem] mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl mt-4 mb-[-32px] flex justify-between items-center"
            >
                <h5
                    class="align-middle font-semibold"
                    :class="
                        $page.props.flash.message.includes('sent')
                            ? 'text-green-600'
                            : 'text-red-600'
                    "
                >
                    {{ $page.props.flash.message }}
                </h5>

                <button
                    class="text-xl border border-slate-300 text-slate-400 px-2.5 py-[0.1rem] rounded-md hover:text-slate-700 hover:border-slate-500"
                    @click="$page.props.flash.message = null"
                >
                    &times;
                </button>
            </div>
            <slot />

    </div>

    </div>

    <Footer/>

</template>
