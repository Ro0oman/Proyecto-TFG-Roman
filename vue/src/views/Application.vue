<template>
  <loading :active="isLoading" 
  :can-cancel="true" ></loading>
    <page-component
    title="PC-Builder">
    <n-button type="success" ghost @click="$router.push('/pccreator')">
      Create your PC
    </n-button>

    MOSTRAR LOS DATOS

    <!-- <div lass="flex flex-wrap justify-center">
      <div class="w-full lg:w-9/12 px-4 border border-white my-4 p-4 rounded-lg ">
        <div class="text-white text-lg m-auto w-full text-center">Your computers</div>
            <div class="grid grid-cols-2 w-full mt-4 justify-items-center">
              <div class="w-4/5" v-for="computer in computers" :key="computer">
                <n-card class="bg-slate-500 hover:bg-slate-200" >
                    <div>
                      <div class="text-white text-lg ">
                        {{ computer.name }}
                      </div >
                      <div >
                        <p>
                          {{ computer.description }}
                        </p>
                      </div >
                    </div>
                </n-card>
              </div>
            </div>
        </div>
    </div> -->
    </page-component>
  </template>
  
  <script>
  import axiosClient from "../axios";
  import { NButton, NCard, NSkeleton, NSwitch } from 'naive-ui'
  import { ref } from 'vue'
  import store from '../store'
  import PageComponent from '../components/PageComponent.vue'
  import loading from 'vue3-loading-overlay'


  export default {
    components: { 
      PageComponent,
      NButton,
      NCard, NSkeleton,
      NSwitch, loading
    },
    setup(){
      const user = ref({})
      const computers = ref([])
      const numComputers = ref()
      const isLoading = ref(true)
      const id = ref()
      return{
        user, computers, numComputers,
        isLoading, id
      }
    },
    created(){
      /* Get user data with api petition */
        // if(Object.keys(store.state.computers).length){
        //   this.computers = store.state.computers;
        //   this.isLoading = false;
        // }else{
        //   this.id = parseInt(sessionStorage.getItem('ID'));
        //   axiosClient.get(`/user/${this.id}`)
        //   .then((response)=>{
        //     axiosClient.get(`/computersId/${this.id}`)
        //     .then((response)=>{
        //         this.numComputers = response.data;
        //         this.numComputers.forEach(element => {
        //         console.log(element.id_pc);
        //         axiosClient.get(`/computer/${element.id_pc}`)
        //             .then((response)=>{
        //                 this.computers.push(response.data);
        //             })
        //         });
        //         store.commit('setComputers', this.computers);
        //         this.isLoading = false;
        //     })
        //   })
        //   console.log(store.state.computers);
        // }
        
        /* Coger todos los pcs, coger todos los pcs del usuario xd */
        this.id = parseInt(sessionStorage.getItem('ID'));
        axiosClient.get(`/userPCS/${this.id}`)
        .then((response)=>{
          console.log(response.data);
          this.isLoading = false;
        })
        

          
    },
    methods:{
      getPCs(){
         
      }
    }
  }
  </script>
  
  <style>
  
  </style>