<template>
  <loading :active="isLoading" 
  :can-cancel="true" ></loading>
    <page-component
    title="PC-Builder">
    <div lass="flex flex-wrap justify-center font-medium">
      <div class="w-full m-auto lg:w-9/12 px-4 border border-white my-4 p-4 rounded-lg ">
        <div class="flex justify-between">
          <div class="text-white text-lg  ml-4 text-center">Your computers</div>
          <n-button type="success" ghost @click="$router.push('/pccreator')">
            Create your PC
          </n-button>
        </div>
            <div class="grid grid-cols-2 w-full mt-4 justify-items-center">
              <div class="w-4/5" v-for="computer in computers" :key="computer">
                <n-card class="bg-slate-500 " >
                    <div>
                      <div class="text-white text-lg ">
                        {{ computer.name }}
                      </div >
                      <div >
                        <p class="text-lg">
                          {{ computer.description }}
                        </p>
                        <div class="data border border-white p-2 text-lg">
                          <Icon>
                            <EditRegular/>
                          </Icon>
                          <div class="list">
                            <ul>
                              <li><span>CPU:</span>
                                <Icon>
                                  <Cpu/>
                                </Icon> {{ computer.cpu.Model }}</li>
                              <li><span>Motherboard</span>: {{ computer.motherboard.modelMotherboard}}</li>
                              <li><span>GPU</span>: {{ computer.gpu.modelGPU }}</li>
                              <li><span>RAM</span>
                                  <li class="ml-2">{{ computer[0].quantity }}GB {{ computer[0].type_ram }}</li>
                                  <li class="ml-2">{{ computer[1].quantity }}GB {{ computer[1].type_ram }}</li>
                              </li>
                              <li><span>Power supply</span>: {{ computer.psu.power }}W</li>
                              <li><span>Storage</span>: 
                                <li class="ml-2">{{ computer.storage.quantity }}GB {{ computer.storage.type_storage }}</li>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div >
                    </div>
                </n-card>
              </div>
            </div>
        </div>
    </div> 
    </page-component>
  </template>
  
  <script>
  import axiosClient from "../axios";
  import { NButton, NCard, NSkeleton, NSwitch } from 'naive-ui'
  import { ref } from 'vue'
  import store from '../store'
  import PageComponent from '../components/PageComponent.vue'
  import {Cpu} from '@vicons/tabler'
  import {EditRegular} from '@vicons/fa'
  import { Icon } from '@vicons/utils'

  import loading from 'vue3-loading-overlay'


  export default {
    components: { 
      PageComponent,
      NButton,
      NCard, NSkeleton,
      NSwitch, loading,
      Icon, Cpu
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
        if(Object.keys(store.state.computers).length){
          this.computers = store.state.computers;
          this.isLoading = false;
          console.log(this.computers);

        }else{
          this.id = parseInt(sessionStorage.getItem('ID'));
          axiosClient.get(`/userPCS/${this.id}`)
            .then((response)=>{
              store.commit('setComputers', response.data)
              this.computers = response.data
              console.log(this.computers);
              this.isLoading = false;
            })
        }
    },
    methods:{
      getPCs(){
         
      }
    }
  }
  </script>
  
  <style>
  
  
  </style>