<template>
  <loading :active="isLoading" 
  :can-cancel="true" >
    <div class="text-xl p-4 bg-black text-white rounded-lg ">
      <Icon class="animate-spin">
        <SpinnerIos20Filled/>
      </Icon>
      Loading your computers...
    </div>
  </loading>
  <div v-if="error">
    <n-alert title="Error Text" type="error">
      {{ error }}
      <div>
        
      </div>
      <br>
      Please, reload the page or contact to <a class="text-blue-600 font-bold"
        href="mailto:romainot99@gmail.com">romainot99@gmail.com</a> explaining whats the error :(
    </n-alert>
  </div>
    <page-component
    title="PC-Builder">
    <div class="flex flex-wrap justify-center font-medium ">
        <div class="w-full m-auto px-4 my-4 p-4 rounded-lg  min-h-[80vh]">
          <div class="flex justify-between font-bold">
            <div class="text-white  ml-4 text-center text-2xl">Your computers</div>
            <n-button type="success" ghost @click="$router.push('/pccreator')">
              Create your PC
            </n-button>
          </div>
          <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-4 w-full mt-4 justify-items-center" v-if="computers.length>0">
            <div class="w-4/5" v-for="computer in getComputers" :key="computer">
              <n-card class="bg-slate-800 text-white ">
                <div>
                  <div class="text-xl flex fler-row">
                    <span class="m-auto w-full">
                      {{ computer.name }}
                    </span>
                  </div>
                  <div>
                    <p class="text-lg text-slate-400 truncate">
                      {{ computer.description }}
                    </p>
                    <div class="text-lg grid">
                      <div class="list">
                        <ul>
                          <!-- <li>
                                    <Icon>
                                      <Cpu/>
                                    </Icon>
                                    <span>CPU:</span>
                                     {{ computer.cpu.Model }}
                                  </li>
                                  <li><span>Motherboard</span>: {{ computer.motherboard.modelMotherboard}}</li>
                                  <li><span>GPU</span>: {{ computer.gpu.modelGPU }}</li>
                                  <li><span>RAM</span>
                                    <li v-for="ramModule in computer.pcRam">
                                      {{ ramModule.quantity }}GB - {{ ramModule.type_ram }}
                                    </li>
                                  </li>
                                  <li><span>Power supply</span>: {{ computer.psu.power }}W</li>
                                  <li><span>Storage</span>:
                                    <li class="ml-2">{{ computer.storage.quantity }}GB {{ computer.storage.type_storage }}</li>
                                  </li> -->
                          <li v-if="computer.pcVideogames.length">
                            <span>Videogames</span>
                          <li v-for="game in computer.pcVideogames">
                            <img :src="game.imageUrl" alt="">
                          </li>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </n-card>
            </div>
          </div>
          <div v-else class="flex w-full">
            <div class="m-auto">
              <n-alert class="bg-black ">
                <template #icon>
                    <n-icon class="text-3xl text-white" >
                      <EmojiSad20Regular />
                    </n-icon>
                  </template>
                <p class="text-white text-xl font-bold ">
                  You have not created any computer yet
                </p>
              </n-alert>
            </div>
          </div>
        </div>
      </div>
</page-component>
</template>
  
  <script>
  import axiosClient from "../axios";
  import { ref } from 'vue'
  import store from '../store'
  import PageComponent from '../components/PageComponent.vue'
  import { NButton, NCard, NSkeleton, NSwitch, NIcon, NAlert } from 'naive-ui'
  import { EmojiSad20Regular } from "@vicons/fluent";
  import {Cpu} from '@vicons/tabler'
  import {EditRegular} from '@vicons/fa'
  import { Icon } from '@vicons/utils'
  import {SpinnerIos20Filled} from '@vicons/fluent'
  import axios from 'axios'
  import loading from 'vue3-loading-overlay'

  

  export default {
    components: { 
      PageComponent,
      NButton,
      NCard, NSkeleton,
      NSwitch, loading,
      Icon, Cpu, EditRegular,
      SpinnerIos20Filled, 
      NIcon, NAlert, EmojiSad20Regular
    },
    setup(){
      const user = ref({})
      const computers = ref([])
      const numComputers = ref()
      const isLoading = ref(true)
      const id = ref()
      const error = ref()
      return{
        user, computers, numComputers,
        isLoading, id, error
      }
    },
    created(){
      /* Get user data with api petition */
        if(Object.keys(store.state.computers).length){
          this.computers = store.state.computers;
          this.isLoading = false;
          console.log(this.computers);
          this.getImages()

        }else{
          this.id = parseInt(sessionStorage.getItem('ID'));
          axiosClient.get(`/userPCS/${this.id}`)
            .then((response)=>{
              store.commit('setComputers', response.data)
              this.computers = response.data
              console.log(this.computers);
              this.isLoading = false;
              this.getImages()
            })
            .catch((error)=>{
              this.error = error
            })
        }
    },
    methods:{
      getPCs(){
         
      },
    getImages() {
      this.computers.forEach(element => {
        element.pcVideogames.forEach(game => {
          axios.get(`https://store.steampowered.com/api/appdetails?appids=${game.id_videogame}`)
            .then((response) => {
              game.imageUrl = response.data[game.id_videogame].data.header_image;
              return true
            })
        })
      });
    },
    },
    computed:{
      getComputers() {
        return this.computers
      }
    }
  }
  </script>
  
  <style>
  
  
  </style>