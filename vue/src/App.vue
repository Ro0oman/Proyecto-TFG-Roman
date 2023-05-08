<template>
  <div class="bg-[#222222] min-h-screen overflow-hidden">
    <DefaultLayout></DefaultLayout>
    <div>
      <router-view></router-view>
    </div>
  </div>
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
