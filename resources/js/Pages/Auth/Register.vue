<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from '@vue/runtime-core';


const form = useForm({
    name: '',
    surname: '',
    date_of_birth: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    if(form.password === form.password_confirmation){

        form.post(route('register'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    }
};

const checkDisable = computed(() => {
    return (form.processing || form.password != form.password_confirmation || (!form.email.includes('@') || !form.email.includes('.')) || !form.name.length > 0 || !form.password.length >0 )
})

</script>

<template>
    <GuestLayout>

        <Head title="Register" />

        <div class="flex justify-center items-center box">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="name" value="Name *" />

                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                            minlength="3"
                        />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="surname" value="Surname" />

                        <TextInput
                            id="surname"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.surname"

                            autofocus
                            autocomplete="surname"
                        />

                        <InputError class="mt-2" :message="form.errors.surname" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="date_of_birth" value="Date of birth" />

                        <TextInput
                            id="date_of_birth"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="form.date_of_birth"

                            autofocus
                            autocomplete="date_of_birth"
                        />

                        <InputError class="mt-2" :message="form.errors.date_of_birth" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="email" value="Email *" />

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                        />
                        <p class="text-red-600 text-sm pt-2" v-if="(!form.email.includes('@') || !form.email.includes('.')) && form.email.length > 1">Please insert a valid email address.</p>
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password" value="Password *" />

                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="new-password"
                            minlength="8"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password_confirmation" value="Confirm Password *" />

                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                        />
                        <p class="text-red-600 text-sm pt-2" v-if="form.password != form.password_confirmation">The two passwords must match.</p>
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <Link
                            :href="route('login')"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Already registered?
                        </Link>

                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': checkDisable}" :disabled="checkDisable">
                            Register
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>


    </GuestLayout>
</template>

<style>

.box{
    height: calc(100vh - 130px);
}

</style>
