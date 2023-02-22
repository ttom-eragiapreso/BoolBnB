<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import Footer from "@/Components/Footer.vue";
import { Link } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('home')">
                                    <ApplicationLogo />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex"
                            >
                                <NavLink
                                    :href="route('dashboard.home')"
                                    :active="route().current('dashboard.home')"
                                >
                                    Dashboard
                                </NavLink>
                                <NavLink
                                    :href="route('dashboard.apartment.index')"
                                    :active="
                                        route().current(
                                            'dashboard.apartment.index'
                                        )
                                    "
                                >
                                    Listings
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                Hi,
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="
                                                route(
                                                    'dashboard.apartment.index'
                                                )
                                            "
                                            as="button"
                                        >
                                            Your Apartments
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="
                                                route(
                                                    'dashboard.apartment.messages'
                                                )
                                            "
                                            as="button"
                                        >
                                            Your Messages
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="
                                                route(
                                                    'dashboard.apartment.stats'
                                                )
                                            "
                                            as="button"
                                        >
                                            Your Statistics
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="
                                                route(
                                                    'dashboard.apartment.create'
                                                )
                                            "
                                            as="button"
                                        >
                                            Add New Apartment
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="
                                                route(
                                                    'dashboard.apartment.index'
                                                )
                                            "
                                            as="button"
                                        >
                                            Transactions history
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="
                                                route(
                                                    'dashboard.apartment.sponsorship'
                                                )
                                            "
                                            as="button"
                                        >
                                            Sponsorships
                                        </DropdownLink>
                                        <hr />
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                            class="text-red-700"
                                        >
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            :href="route('dashboard.home')"
                            :active="route().current('dashboard.home')"
                        >
                            Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('dashboard.apartment.index')"
                            :active="
                                route().current('dashboard.apartment.index')
                            "
                        >
                            Listings
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('dashboard.apartment.create')"
                            :active="
                                route().current('dashboard.apartment.create')
                            "
                        >
                            Add new Apartment
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('dashboard.apartment.messages')"
                            :active="
                                route().current('dashboard.apartment.messages')
                            "
                        >
                            Your Messages
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('dashboard.apartment.stats')"
                            :active="
                                route().current('dashboard.apartment.stats')
                            "
                        >
                            Your Statistics
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('dashboard.apartment.stats')"
                            :active="
                                route().current('dashboard.apartment.stats')
                            "
                        >
                            Transactions history
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Message box -->
            <div
                v-if="$page.props.flash.message"
                class="container py-6 max-w-[76rem] mx-auto sm:px-6 lg:px-8 bg-white sm:rounded-xl mt-4 mb-[-32px] flex justify-between items-center"
            >
                <h5
                    class="align-middle font-semibold"
                    :class="
                        $page.props.flash.message.includes('updated')
                            ? 'text-amber-600'
                            : $page.props.flash.message.includes('created')
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

            <!-- Page Content -->
            <main class="pb-24">
                <slot />
            </main>

            <Footer />
        </div>
    </div>
</template>
