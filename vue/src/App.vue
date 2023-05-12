<template>
  <div class="bg-[#222222] min-h-screen overflow-hidden">
    <DefaultLayout></DefaultLayout>
    <n-message-provider>
      <div>
        <router-view></router-view>
      </div>
    </n-message-provider> 
  </div>
</template>

<script>
  import DefaultLayout from './components/DefaultLayout.vue'
  import 'vue3-loading-overlay/dist/vue3-loading-overlay.css';
  import { NMessageProvider } from 'naive-ui'
  export default{
    setup(){

    },
    components:{
      DefaultLayout, NMessageProvider
    }
  }

</script>
