<template>
    <div v-if="error">
    <n-alert title="Error Text" type="error" closable>
      {{ error }}
      <div>
      </div>
      <br>
      <b>This game is not available right now or doesn't exist, please select other game</b>
    </n-alert>
  </div>
    <div class="flex flex-col justify-center  " v-if="!showGame">
        <div class="text-3xl textYellow m-auto mt-4 ">
            Select what is your level
        </div>
        <div class="lg:flex lg:flex-row m-auto p-4 mt-10 lg:justify-center grid grid-cols-1 gap-8 ">
            <button class="flex-col hover:scale-110 bg-slate-400 transition rounded p-4 mx-4" 
            @click="difficulty('help')">
            <p class="text-2xl mb-2 textYellow">
                I need help
            </p>
            <p class="text-slate-600 text-ellipsis">
                The page will assemble your computer completely, <br>
                following compatibility criteria and we will make sure that everything works correctly.<br>
                <b>Let us take care of everything :D    </b>        
            </p>
                <!-- <img src="../assets/Horrorvideogamerafiki.svg" class="m-auto" width="400" alt=""> -->
            </button>
            <button class="hover:scale-110 flex-col bg-slate-400 transition rounded  p-4 mx-4" 
            @click="difficulty('no')">
            <p class="text-2xl mb-2 textYellow">
                I dont need help
            </p>
            <p class="text-slate-600">
                The page will tell you which components are compatible but you choose them.
                <br> <b>We'll let you have a good time ;) </b>           </p>
                <img src="../assets/noob.png" width="400" class="m-auto" alt="">
            </button> 
        </div>
    </div>
    <div v-if="difficultySelected == 'no'" class="flex flex-col justify-center font-medium ">
        <div class="text-3xl textYellow m-auto mt-2">
            Select what game do you want to play
        </div>
        <div class="flex flex-row m-auto p-4 mt-4 justify-center w-2/3">
            <div class="w-2/3 m-auto" >
                <div class="rounded-lg bg-[#4c4c4c] p-4">
                    <div class="font-bold text-[#eded00]">
                        Filter by Game
                    </div>
                    <input v-model="searchInput" type="text" class="w-full rounded my-2" placeholder="Search STEAM any game" />
                    <div class="flex w-full" v-if="searchInput">
                        <n-select v-model:value="selectedGame" :options="filteredList"/>
                        <button class="w-1/3 rounded border bg-slate-400" @click="search">
                        Select game
                        </button>
                    </div>
                </div>
                <div class="flex m-auto">
                    <button class="bg-slate-300 rounded m-auto w-40 p-2 mt-2" @click='difficultySelected = false'>
                        <i class="arrow left"></i> Go back
                    </button>
                    <button v-if="showedGame" class="bg-slate-300 rounded m-auto w-40 p-2 mt-2" @click='nextStep()'>
                        Next Step <i class="arrow right"></i>
                    </button>
                </div>
                <div v-if="showedGame" class="flex flex-row items-center justify-between my-8">   
                    <div class="w-5/6 m-auto">
                        <n-card :title="showedGame.name" class="flex">
                            <template #cover>
                                <img :src="showedGame.header_image">
                            </template>
                            <button role="link" @click="getUrl(showedGame.steam_appid)"
                                class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mr-4"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 496 512">
                                    <path
                                        d="M496 256c0 137-111.2 248-248.4 248c-113.8 0-209.6-76.3-239-180.4l95.2 39.3c6.4 32.1 34.9 56.4 68.9 56.4c39.2 0 71.9-32.4 70.2-73.5l84.5-60.2c52.1 1.3 95.8-40.9 95.8-93.5c0-51.6-42-93.5-93.7-93.5s-93.7 42-93.7 93.5v1.2L176.6 279c-15.5-.9-30.7 3.4-43.5 12.1L0 236.1C10.2 108.4 117.1 8 247.6 8C384.8 8 496 119 496 256zM155.7 384.3l-30.5-12.6a52.79 52.79 0 0 0 27.2 25.8c26.9 11.2 57.8-1.6 69-28.4c5.4-13 5.5-27.3.1-40.3c-5.4-13-15.5-23.2-28.5-28.6c-12.9-5.4-26.7-5.2-38.9-.6l31.5 13c19.8 8.2 29.2 30.9 20.9 50.7c-8.3 19.9-31 29.2-50.8 21zm173.8-129.9c-34.4 0-62.4-28-62.4-62.3s28-62.3 62.4-62.3s62.4 28 62.4 62.3s-27.9 62.3-62.4 62.3zm.1-15.6c25.9 0 46.9-21 46.9-46.8c0-25.9-21-46.8-46.9-46.8s-46.9 21-46.9 46.8c.1 25.8 21.1 46.8 46.9 46.8z"
                                        fill="currentColor">
                                    </path>
                                </svg>
                                Find in Steam
                            </button>
                            <n-collapse class="mt-6 bg-slate-200 p-4 rounded-lg">
                                <n-collapse-item title="See game details" name="1" class="text-3xl ">
                                    <div v-html="showedGame.detailed_description" class="my-4">
                                    </div>
                                </n-collapse-item>
                            </n-collapse>
                        </n-card>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else-if="difficultySelected == 'help'">
        <div class="w-full text-center my-4 text-3xl textYellow m-auto mt-2">
            What quality is your game?
            </div>
        <div class="w-full grid lg:grid-cols-3 grid-cols-1 place-items-center h-full">
            <button class="hover:scale-105 flex-col bg-slate-400 transition rounded  p-4 mx-4" 
            @click="difficulty('no')">
            <p class="text-2xl mb-2 textYellow">
                Low quality
            </p>
                <img class="rounded-lg" src="../assets/lowQuality.jpg" width="1200" alt="Low quality">
            </button> 
            <button class="hover:scale-105 flex-col bg-slate-400 transition rounded  p-4 mx-4" 
            @click="difficulty('no')">
            <p class="text-2xl mb-2 textYellow">
                Medium quality
            </p>
                <img class="rounded-lg" src="../assets/mediumquality.webp" width="1200" alt="Medium quality">
            </button> 
            <button class="hover:scale-105 flex-col bg-slate-400 transition rounded  p-4 mx-4" 
            @click="difficulty('no')">
            <p class="text-2xl mb-2 textYellow">
                High quality
            </p>                
                <img class="rounded-lg" src="../assets/highquality.jpg" width="1200"  alt="High quality">
            </button> 
        </div>
    </div>
   
</template>

<script>

import { NSelect, NButton, NCard, NCollapseItem, NCollapse, NAlert } from "naive-ui";
import { ref } from 'vue';
import draggable from 'vuedraggable'
import store from '../store'
import gameList from '../assets/steamgames.json'
import loading from 'vue3-loading-overlay'
import { Icon } from '@vicons/utils'
import {SpinnerIos20Filled} from '@vicons/fluent'
import axios from 'axios'
import axiosClient from "../axios";

export default {
    components:{ 
        NSelect,draggable,NButton, loading, Icon, SpinnerIos20Filled,
        NCollapseItem, NCollapse
        ,NCard, NAlert
    },
    setup(){
        const value = ref(null)
        const options = ref([])
        const cpus = ref([])
        const drag = ref(false)
        const difficultySelected = ref(false)
        const games = ref(gameList)
        const searchInput = ref()
        const selectedGame = ref([])
        const showedGame = ref(false)
        const isLoading = ref(false)
        const selectComponents = ref(false)
        const error = ref()
        return{
            options, value,
            drag, cpus, difficultySelected, 
            games, searchInput,
            selectedGame, isLoading,
            showedGame, selectComponents,
            error
        }
    },
    created(){
    }, 
    methods:{
        difficulty(param){
            this.difficultySelected = param
            console.log(this.difficultySelected);
        },
        search() {
            console.log(this.selectedGame)
            axiosClient.get(`/getGameID/${this.selectedGame}`)
                .then((response) => {
                    this.showedGame = response.data[this.selectedGame].data;
                    console.log(this.showedGame);
                    return true
                })
                .catch((error)=> {
                    this.error = error
                })
        },
        nextStep(){
            store.commit('setGame', this.showedGame);
            this.$router.push({
                name:'componentPicker'
            })
        },
        getUrl(id) {
            window.open(`https://store.steampowered.com/app/${id}`, '_blank', 'noreferrer');
        },
    },
    computed:{
        showGame(){
            if(this.difficultySelected == false){
                return false
            }else{
                return true
            }
        },
        filteredList() {
            return this.games.filter(game => {
                return game.label.toLowerCase().includes(this.searchInput.toLowerCase())
            });
        },
    }
}
</script>

<style scoped>
.noob{
   background-image: url('../assets/noob.png') ;
}

.arrow {
  border: solid black;
  border-width: 0 3px 3px 0;
  display: inline-block;
  padding: 3px;
}

.right {
  transform: rotate(-45deg);
  -webkit-transform: rotate(-45deg);
}

.left {
  transform: rotate(135deg);
  -webkit-transform: rotate(135deg);
}

.up {
  transform: rotate(-135deg);
  -webkit-transform: rotate(-135deg);
}

.down {
  transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
}

</style>