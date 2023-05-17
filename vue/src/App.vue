<template>
  <div class="bg-[#222222] min-h-screen overflow-hidden">
    <DefaultLayout></DefaultLayout>
    <n-message-provider>
      <div>
        <router-view></router-view>
      </div>
    </n-message-provider> 
  </div>
  <footer class="w-full h-10 bg-slate-600  border-t-2 text-white flex flex-row justify-between p-4">
        <p class="mb-2">
          Page created by Roman Myziuk 
        </p>
        <p>
          All rights reserver &copy;
        </p>
      </footer>
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
