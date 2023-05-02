<template>
  <loading :active="isLoading" 
  :can-cancel="true" ></loading>
    <page-component
    title="Community content">
      Community page
      <div class="grid grid-cols-2 w-full mt-4 justify-items-center">
        <div class="w-4/5" v-for="computer in computers" :key="computer.id" >
          <n-card class="bg-slate-500" >
              <div>
                <div class="text-white text-lg " >
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
                        <!-- <li><span>RAM</span>
                            <li class="ml-2">{{ computer[0].quantity }}GB {{ computer[0].type_ram }}</li>
                            <li class="ml-2">{{ computer[1].quantity }}GB {{ computer[1].type_ram }}</li>
                        </li> -->
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
    </page-component>
  </template>
  
  <script>
    import axiosClient from "../axios";
    import PageComponent from '../components/PageComponent.vue'
    import { ref } from 'vue'
    import {Cpu} from '@vicons/tabler'
    import {EditRegular} from '@vicons/fa'
    import { Icon } from '@vicons/utils'
    import { NCard } from "naive-ui";
    import store from '../store'
    import loading from 'vue3-loading-overlay'

  export default {
    components: { 
      PageComponent,
      EditRegular,
      Cpu, Icon, 
      NCard, loading
     },
     setup(){
      const computers = ref({})
      const isLoading = ref(true)
      return{
        computers, isLoading
      }

     },
     created(){
      if(Object.keys(store.state.allComputers).length){
        this.computers = store.state.allComputers;
        this.isLoading = false;
      }
      axiosClient.get(`/computer`)
            .then((response)=>{
             this.computers = response.data
             store.commit('setAllComputers', response.data)
             console.log(this.computers);
             this.isLoading = false;
            //  debugger
            })
     }
  }
  </script>
  
  <style>
  
  </style>