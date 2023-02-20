<script>

import ApplicationLogo from './ApplicationLogo.vue';
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";

export default {
    name: 'Header',
    data(){
        return{
            open: false,
            var: null
        }
    },
    components:{
        ApplicationLogo,
        Dropdown,
        DropdownLink,
        NavLink
    },
    props:{
        canLogin: Boolean,
        canRegister: Boolean
    },
    methods:{
        // dropDown(){
        //     if(this.open){
        //         this.unOpen();
        //     } else {
        //         this.open = true;
        //         document.addEventListener('click', this.unOpen());
        //     }
        // },
        // unOpen(){
        //     this.open = false;
        //     document.removeEventListener('click', this.unOpen);
        // }
    }
}
</script>

<template>
    <header>
    <div class="h-[80px] border-b-[1px] flex justify-between items-center px-8 lg:px-20">
      <div class="logo h-auto cursor-grab flex items-center">
        <a href="/"><ApplicationLogo /></a>

      </div>

        <div class="relative">
            <input type="search" id="search" class="cursor-pointer px-5 py-3 block w-full border border-slate-200 rounded-full focus:ring-slate-500 focus:border-slate-500 dark:border-gray-200 dark:placeholder-slate-400 dark:text-black dark:focus:ring-slate-500 dark:focus:border-slate-500 shadow hover:shadow-md" placeholder="Città" required>

          <div class="absolute inset-y-0 right-0 flex items-center pr-2 py-2 pointer-events-none">
              <svg aria-hidden="true" class="w-[34px] h-[100%] text-gray-500 dark:text-white bg-[#FB1C4A] p-2 border-transparent rounded-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
          </div>
        </div>

        <div class="relative w-[168px] flex justify-end">
            <!-- <button @click="open = !open" class="animate-pulse hover:animate-bounce border rounded-full hover:border-gray-500 p-2 hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                    </svg>
            </button> -->
            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >


                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('advancedsearch')"
                                            as="button"
                                            >
                                            Advanced Search
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('details')"
                                            as="button"
                                            >
                                            Details
                                        </DropdownLink>

                                        <DropdownLink
                                            v-if="$page.props.auth.user"
                                            :href="route('dashboard.home')"
                                            as="button"
                                            >
                                            Dashboard
                                        </DropdownLink>

                                        <template v-else>
                                            <DropdownLink
                                                :href="route('login')"

                                                >Log in</DropdownLink
                                            >

                                            <DropdownLink
                                                :href="route('register')"

                                                >Register</DropdownLink
                                            >

                                        </template>
                                    </template>
                                </Dropdown>
                            </div>

        </div>
    </div>
   </header>
</template>

<style>

</style>
