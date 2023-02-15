

<script>
import AuthenticatedLayoutVue from '@/Layouts/AuthenticatedLayout.vue';
import CardDashboard from '@/Components/CardDashboard.vue';
export default {
    name: 'Index',
    components:{
        CardDashboard
    },
    layout: AuthenticatedLayoutVue,
    props:{
        user_apartments: Array
    }
}
</script>

<template>

    <div class="">

    </div>

  <h1>You apartments</h1>
  <CardDashboard v-for="apartment in user_apartments" :key="apartment.id" :apartment="apartment"/>
</template>

<style>

</style>
