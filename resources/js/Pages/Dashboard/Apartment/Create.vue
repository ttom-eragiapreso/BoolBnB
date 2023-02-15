<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';

export default {
    name: 'Create',
    layout: AuthenticatedLayout,
    components:{
        Link
    },
    data(){
        return{
            form: useForm({
                title: null,
                rooms: null,
                bed: null,
                bathrooms: null,
                square_meters: null,
                city: null,
                country: null,
                full_address: null,
                price: null,
                cover_image: null,
                description: null,
                is_visible: null,
                errors: null
            })
        }
    }
}
</script>

<template>
  <h1>Create</h1>
  <form @submit.prevent="" class="flex flex-col gap-5 px-10">

    <label for="title">Title</label>
    <input id="title" type="text" v-model="form.title">
    <div v-if="$page.props.errors.title">{{ $page.props.errors.title }}</div>

    <label for="title">Rooms</label>
    <input type="number" v-model="form.rooms">
    <div v-if="$page.props.errors.rooms">{{ $page.props.errors.rooms }}</div>

    <label for="title">Beds</label>
    <input type="number" v-model="form.bed">
    <div v-if="$page.props.errors.bed">{{ $page.props.errors.bed }}</div>

    <label for="title">Bathrooms</label>
    <input type="number" v-model="form.bathrooms">
    <div v-if="$page.props.errors.bathrooms">{{ $page.props.errors.bathrooms }}</div>

    <label for="title">Square Meters</label>
    <input type="text" v-model="form.square_meters">
    <div v-if="$page.props.errors.square_meters">{{ $page.props.errors.square_meters }}</div>

    <label for="title">City</label>
    <input type="text" v-model="form.city">
    <div v-if="$page.props.errors.city">{{ $page.props.errors.city }}</div>

    <label for="title">Country</label>
    <input type="text" v-model="form.country">
    <div v-if="$page.props.errors.country">{{ $page.props.errors.country }}</div>

    <label for="title">Address</label>
    <input type="text" v-model="form.full_address">
    <div v-if="$page.props.errors.full_address">{{ $page.props.errors.full_address }}</div>

    <label for="title">Price</label>
    <input type="text" v-model="form.price">
    <div v-if="$page.props.errors.price">{{ $page.props.errors.price }}</div>

    <label for="title">Cover Image</label>
    <input type="file" @input="form.cover_image = $event.target.files[0]" />
    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
      {{ form.progress.percentage }}%
    </progress>

    <label for="title">Description</label>
    <textarea name="description" id="description" cols="30" rows="10" v-model="form.description"></textarea>
    <div v-if="$page.props.errors.description">{{ $page.props.errors.description }}</div>

    <label for="title">Public</label>
    <input type="checkbox" name="is_visible" id="is_visible" v-model="form.is_visible">

    <!-- submit -->
    <Link as="button" :href="route('dashboard.apartment.store')" method="POST" :data="this.form" :disabled="form.processing">Create!</Link>
  </form>
</template>

<style>

</style>
