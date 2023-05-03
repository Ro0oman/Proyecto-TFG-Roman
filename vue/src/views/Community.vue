<template>
  <loading :active="isLoading" 
  :can-cancel="true" >
  <div class="text-xl p-4 bg-black text-white rounded-lg">
    <Icon class="animate-spin">
      <SpinnerIos20Filled/>
    </Icon>
    Loading community computers
  </div>
</loading>
  <div v-if="error">
    <n-alert title="Error Text" type="error">
      {{ error }}
      <br>
      Please, reload the page or contact to <a class="text-blue-600 font-bold" href="mailto:romainot99@gmail.com">romainot99@gmail.com</a> explaining whats the error :(
    </n-alert>
  </div>
    <page-component
    title="Community content">
      <div class="flex flex-col">
        <div class="w-full m-auto">
          <div class="text-xl font-bold text-white py-4">
            Search settings
          </div>
          <div class="font-bold text-white p-4 border rounded-lg ">
            Filter by Game
            <n-input
              v-model:value="searchInput"
              type="text"
              placeholder="Basic Input" 
              class="bg-black text-black mb-2"
            />
            <div class="flex w-full ">
              <n-select 
                v-model:value="selectedGame" 
                :options="filteredList"
                @update:value="search" />
              <button class="w-1/3 rounded border bg-slate-400" @click="search">
                Search
              </button>
              <button class="w-1/3 rounded border bg-blue-400" @click="clear">
                Clear
              </button>
            </div>
          </div>
        </div>
        <div class="flex flex-wrap justify-center font-medium ">
          <div class="w-full m-auto px-4 border border-white my-4 p-4 rounded-lg overflow-y-scroll max-h-[80vh]">
            <div class="flex justify-between font-bold">
              <div class="text-white  ml-4 text-center text-2xl">Community computers</div>
                <n-button type="success" ghost @click="$router.push('/pccreator')">
                  Create your PC
                </n-button>
              </div>
                <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-4 w-full mt-4 justify-items-center">
                  <div class="w-4/5" v-for="computer in getComputers" :key="computer">
                    <n-card class="bg-slate-800 text-white ">
                        <div>
                          <div class="text-xl flex fler-row">
                            <span class="m-auto w-full">
                              {{ computer.name }}
                            </span>
                          </div >
                          
                          <div >
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
            </div>
        </div> 
      </div>
      <button @click="getImages">
        GET IMAGES
      </button>
    </page-component>
  </template>
  
  <script>
    import axiosClient from "../axios";
    import PageComponent from '../components/PageComponent.vue'
    import { ref } from 'vue'
    import { Icon } from '@vicons/utils'
    import { NCard, NAlert, NButton, NIcon, NInput, NSelect } from "naive-ui";
    import store from '../store'
    import loading from 'vue3-loading-overlay'
    import {SpinnerIos20Filled} from '@vicons/fluent'
    import {Cpu} from '@vicons/tabler'
    import {EditRegular} from '@vicons/fa'
    import gameList from '../assets/steamgames.json'
    import axios from 'axios'
  export default {
    components: { 
      PageComponent,
      EditRegular,
      Cpu, Icon, 
      NCard, loading,
      NAlert, SpinnerIos20Filled,
      NButton, NIcon, NInput,
      NSelect
     },
     setup(){
      const computers = ref({})
      const isLoading = ref(true)
      const error = ref()
      const searchInput = ref()
      const games = ref(gameList)
      const filteredGames = ref([])
      const selectedGame = ref([])
      return{
        computers, isLoading, error,
        searchInput, games, filteredGames,
        selectedGame
      }
     },
      created(){
        if(Object.keys(store.state.allComputers).length){
          this.computers = store.state.allComputers;
          this.isLoading = false;
          this.getImages()
        }else{
          axiosClient.get(`/computer`)
            .then((response)=>{
              this.computers = response.data
              this.getImages()
              store.commit('setAllComputers', response.data)
              this.isLoading = false;
            })
            .catch((error)=>{
              this.error = error
              this.isLoading = false;
              
            })  
        }
        
     },
     methods:{
      search(){
        console.log(this.computers)
        this.computers = this.computers.filter(computer => {
          return computer.pcVideogames[0].id_videogame == this.selectedGame
        });
      },
      clear(){
        this.computers = store.state.allComputers;
        this.selectedGame = ''
        this.searchInput = ''
      },
      getImages(){
        this.computers.forEach(element => {
            element.pcVideogames.forEach(game=>{
              axios.get(`https://store.steampowered.com/api/appdetails?appids=${game.id_videogame}`)
                .then((response)=>{
                  game.imageUrl = response.data[game.id_videogame].data.header_image;
                  return true
                })
            })
          });
      },
     
     },
     computed:{
      filteredList() {
        return this.games.filter(game => {
          return game.label.includes(this.searchInput)
        });
      },
      getComputers(){
        return this.computers
      }
     }

     
  }
  </script>
  
  <style>
    .input{
      background-color: black;
    }
    .input:focus{
      background-color: black;
    }
  </style>