<template>
    <!-- component -->
    <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css">
    <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">

        <main class="profile-page">
        <section class="relative block h-500-px">
        <div class="absolute top-0 w-full h-full bg-center bg-cover">
            <span id="blackOverlay" class="w-full h-full absolute opacity-50 bg-black"></span>
        </div>
        <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden h-70-px" style="transform: translateZ(0px)">
            <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
            <polygon class="text-blueGray-200 fill-current" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
        </section>
        <section class="relative py-16 bg-blueGray-200">
        <div class="container mx-auto px-4">
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64">
            <div class="px-6">
                <div class="flex flex-wrap justify-center">
                <div class="w-full px-4 lg:order-2 flex justify-center">
                    <div class="">
                    <n-avatar rounded
                    class="absolute -mt-12 -ml-12 bg-[#FF0000] text-yellow-300 rounded-full p-14 text-4xl">
                    R
                  </n-avatar>  
                </div>
                </div>
                <div class="w-full lg:w-4/12 px-4 lg:order-3 lg:text-right lg:self-center">
                    <div class="py-6 px-3 mt-32 sm:mt-0">
                    </div>
                </div>
                
                </div>
                <div class="text-center mt-6 m-auto flex flex-col items-center">
                <h3 class="text-4xl font-semibold">
                    {{ user.name }}
                </h3>
                <div class="text-blueGray-400 font-bold flex items-center w-1/2 mt-4">
                    <p class="m-auto flex">
                        <Icon size="25" color="black">
                            <VideogameAssetTwotone>
                            </VideogameAssetTwotone>
                        </Icon>
                        <div class="mx-2">
                            Favorite videogame: {{'Juego favorito'}}
                        </div>
                    </p>
                </div>
                    <div class="flex justify-center py-4">
                    <div class="p-3 text-center">
                        <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">Computers : {{computers.length}}</span>
                        <span class="text-xl text-blueGray-400 "></span>
                    </div>
                    </div>
                </div>
                <div class="mt-10 py-10 border-t border-blueGray-200 text-center">
                <div class="flex flex-wrap justify-center">
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
                </div>
                </div>
            </div>
            </div>
        </div>
        </section>
        </main>
  </template>
  
  <script>
    import { NAvatar, NCard } from 'naive-ui'
    import store from '../store'
    import PageComponent from '../components/PageComponent.vue'
    import { ref } from 'vue'
    import axiosClient from "../axios";
    import { Icon } from '@vicons/utils'
    import { VideogameAssetTwotone } from '@vicons/material'
    import { People20Filled } from '@vicons/fluent'

  export default {
    components: { 
        PageComponent, NAvatar, NCard,
        Icon, VideogameAssetTwotone,
        People20Filled
    },
    setup(){
        const user = ref({})
        const computers = ref([])

        return{
            user, computers
        }
    },
    async created(){
        // return axiosClient.get('/user')
        //     .then(({data})=>{
        //         console.log(data);
        //     })
        this.user = store.state.user.data;
        console.log(store.state.user.data);
        this.user = store.state.user.data
      // store.commit('setProcess', this.processState);
      if(Object.keys(store.state.computers).length){
        this.computers = store.state.computers;
      }else{
        axiosClient.get(`/computersId/${this.user.id}`)
          .then((response)=>{
              this.numComputers = response.data;
              this.numComputers.forEach(element => {
                console.log(element.id_pc);
               axiosClient.get(`/computer/${element.id_pc}`)
                  .then((response)=>{
                      this.computers.push(response.data);
                      
                  })
              });
              store.commit('setComputers', this.computers);
          })
          console.log(store.state.computers);
      }

    }
  }
  </script>
  
  <style>

  </style>