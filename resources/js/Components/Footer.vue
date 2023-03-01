<script>
export default {
    name: "Footer",
    data() {
        return {
            currentPage: "esplora",
            beforeScroll: 0,
            hideFooterMobile: false,
            hideFooterPopUp: true,
        };
    },
    methods: {
        scrollWindow() {
            if (window.screen.width > 768) return;

            if (window.scrollY >= this.beforeScroll) {
                this.hideFooterMobile = true;
            } else {
                this.hideFooterMobile = false;
            }
            this.beforeScroll = window.scrollY;
        },
    },
    mounted() {
        window.addEventListener("scroll", this.scrollWindow);
    },
};
</script>

<template>
    <footer class="w-full" v-on:scroll.native="scrollWindow">
        <div
            class="flex flex-col md:flex-row px-8 lg:px-20 w-full py-3.5 mt-[46vh] md:mt-0 md:fixed bottom-0 z-20 justify-between text-sm text-[#222222] tracking-wide bg-white border-t-[1px] border-[#dddddd]"
        >
            <div class="order-2">
                <nav class="inline" id="footer_nav_desktop">
                    <ul class="inline-flex flex-wrap">
                        <p class="w-full md:w-auto inline-block pr-2">
                            2023 BoolBnb, Inc.
                        </p>
                        <li class="md:before:content-['\00B7']">
                            <a href="/" class="md:pl-2 pr-2 hover:underline"
                                >Home
                            </a>
                        </li>
                        <li class="before:content-['\00B7']">
                            <a href="/advanced-search" class="px-2 hover:underline"
                                >Advanced Search
                            </a>
                        </li>
                        <li class="before:content-['\00B7']">
                            <a href="/register" class="px-2 hover:underline"
                                >Register
                            </a>
                        </li>
                        <li class="before:content-['\00B7']">
                            <a href="/login" class="px-2 hover:underline"
                                >Log in
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div
                class="font-[500] flex gap-6 flex-shrink-0 order-1 md:order-2 mb-2 md:mb-0 md:ml-2"
            >
                <button class="tracking-wide">
                    <i class="fa-solid fa-globe pr-2"></i>
                    <span class="hover:underline">English (EU)</span>
                </button>
                <button class="tracking-wide">
                    <span class="pr-2">&euro;</span>
                    <span class="hover:underline">EUR</span>
                </button>
                <button
                    class="hidden md:block hover:text-black active:text-[#444444] tracking-wide"
                    @click="hideFooterPopUp = !hideFooterPopUp"
                >
                    <span>About us</span>
                    <i class="fa-solid fa-chevron-up pl-2"></i>
                </button>
            </div>
        </div>

        <div
            id="footerPopUp"
            class="fixed bottom-0 px-20 pt-12 pb-20 grid grid-cols-4 bg-white rounded-t-3xl z-10 w-full"
            :class="{ hide: hideFooterPopUp }"
        >
            <div class="text-center">
                <h5 class="font-bold pb-4 text-center text-lg">Paolo Colombo</h5>
                <div class="w-[100%] flex justify-center pb-4">
                    <img class="w-[30%] rounded-full" src="../../../public/img/paolo.png" alt="user_1">
                </div>
                <a class="hover:text-slate-500 hover:underline" href="https://github.com/clmb00" target="_blank">Link GitHub</a>
            </div>
            <div class="text-center">
                <h5 class="font-bold pb-4 text-center text-lg">Enrico Michelotto</h5>
                <div class="w-[100%] flex justify-center pb-4">
                    <img class="w-[30%] rounded-full" src="../../../public/img/enrico.jpg" alt="user_2">
                </div>
                <a class="hover:text-slate-500 hover:underline" href="https://github.com/ttom-eragiapreso" target="_blank">Link GitHub</a>
            </div>
            <div class="text-center">
                <h5 class="font-bold pb-4 text-center text-lg">Cristina Lietti</h5>
                <div class="w-[100%] flex justify-center pb-4">
                    <img class="w-[30%] rounded-full" src="../../../public/img/cri.jpg" alt="user_3">
                </div>
                <a class="hover:text-slate-500 hover:underline" href="https://github.com/mlietti1" target="_blank">Link GitHub</a>
            </div>
            <div class="text-center">
                <h5 class="font-bold pb-4 text-center text-lg">Lino Pannella</h5>
                <div class="w-[100%] flex justify-center pb-4">
                    <img class="w-[30%] rounded-full" src="../../../public/img/lino.jpg" alt="user_4">
                </div>
                <a class="hover:text-slate-500 hover:underline" href="https://github.com/pannellalino" target="_blank">Link GitHub</a>
            </div>
            <div
                class="absolute top-5 left-7"
                @click="hideFooterPopUp = !hideFooterPopUp"
            >
                <i
                    class="fa-solid fa-xmark text-xl cursor-pointer text-[#a2a2a2] hover:text-black"
                ></i>
            </div>
        </div>

        <!-- <div
            id="footer_mobile"
            class="flex md:hidden fixed bottom-0 justify-center items-center bg-white w-full h-[65px] text-xs border-t-[1px] border-[#dddddd]"
            :class="{ hide: hideFooterMobile }"
        >
            <nav class="flex w-full max-w-sm justify-between">
                <div
                    class="group px-1 flex flex-col items-center grow cursor-pointer"
                >
                    <i
                        class="fa-solid fa-magnifying-glass text-2xl"
                        :class="
                            currentPage === 'esplora'
                                ? 'text-[#ff385c]'
                                : 'text-[#b0b0b0] group-hover:text-[#999999]'
                        "
                    ></i>
                    <span>Esplora</span>
                </div>
                <div
                    class="group px-1 flex flex-col items-center grow cursor-pointer"
                >
                    <i
                        class="fa-regular fa-heart text-2xl"
                        :class="
                            currentPage === 'preferiti'
                                ? 'text-[#ff385c]'
                                : 'text-[#b0b0b0] group-hover:text-[#999999]'
                        "
                    ></i>
                    <span>Preferiti</span>
                </div>
                <div
                    class="group px-1 flex flex-col items-center grow cursor-pointer"
                >
                    <i
                        class="fa-regular fa-circle-user text-2xl"
                        :class="
                            currentPage === 'accedi'
                                ? 'text-[#ff385c]'
                                : 'text-[#b0b0b0] group-hover:text-[#999999]'
                        "
                    ></i>
                    <span>Accedi</span>
                </div>
            </nav>
        </div> -->
    </footer>
</template>

<style scoped>
#footer_mobile {
    transition: 0.5s ease transform;
}

#footerPopUp {
    transition: 0.8s ease transform;
}

.hide {
    transform: translateY(100%);
}
</style>
