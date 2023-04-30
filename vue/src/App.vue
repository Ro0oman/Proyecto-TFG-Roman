<template>
  <DefaultLayout></DefaultLayout>
  <router-view></router-view>
</template>

<script>
  import DefaultLayout from './components/DefaultLayout.vue'
  import 'vue3-loading-overlay/dist/vue3-loading-overlay.css';

  export default{
    setup(){

    },
    components:{
      DefaultLayout
    }
  }

</script>

<style>
</style>