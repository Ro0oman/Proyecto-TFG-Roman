<template>
  <loading :active="isLoading" :can-cancel="true">
    <div class="text-xl p-4 bg-white text-black rounded-lg">
      <Icon class="animate-spin">
        <SpinnerIos20Filled />
      </Icon>
      Loading community computers
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
  <page-component title="Community content">
    <div class="flex flex-col">
      <div class="w-2/3 m-auto" >
        <div class="text-xl font-bold text-[#eded00] py-4">
          Search settings
        </div>
        <div class="rounded-lg bg-[#4c4c4c] p-4">
          <div class="font-bold text-[#eded00]">
            Filter by Game
          </div>
          <input v-model="searchInput" type="text" class="w-full rounded my-2" placeholder="Search any STEAM game" />
          <div class="flex w-full" v-if="searchInput">
            <n-select v-model:value="selectedGame" :options="filteredList" @update:value="search" />
            <button class="w-1/3 rounded border bg-slate-400" @click="search">
              Search
            </button>
            <button class="w-1/3 rounded border bg-blue-400" @click="clear">
              Clear
            </button>
          </div>
        </div>
      </div>
      <div class="flex flex-wrap justify-center font-medium " v-if="computers.length">
        <div class="w-2/3 m-auto px-4 my-4 p-4 rounded-lg  min-h-[80vh]">
          <div class="flex justify-between font-bold">
            <div class="ml-4 text-center text-2xl text-[#eded00]">Community computers</div>
            <n-button type="success" ghost @click="$router.push('/pccreator')">
              Create your PC
            </n-button>
          </div>
          <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-4 w-full mt-4 justify-items-strech">
            <div v-for="computer in getComputers" :key="computer" >
              <n-card class="bg-slate-600 w-full"  :bordered="false">
                <template #cover v-if="computer.pcVideogames.length">
                  <img :src="computer.pcVideogames[0].imageUrl" >
                </template>
                <div>
                  <div class="text-xl flex fler-row">
                    <span class="w-full">
                      {{ computer.name }}
                    </span>
                  </div>
                  <div>
                    <p class="text-lg text-slate-400 truncate">
                      {{ computer.description }}
                    </p>
                    <div class="text-lg grid">
                    </div>
                  </div>
                </div>
              </n-card>
            </div>
          </div>
        </div>
      </div>
      <div class="w-[70vw]" v-else>
        <span>
          No match found, Be the fisrt to create this PC
        </span>
      </div>
    </div>
  </page-component>
</template>

<script>
import axiosClient from "../axios";
import PageComponent from '../components/PageComponent.vue'
import { ref } from 'vue'
import { Icon } from '@vicons/utils'
import { NCard, NAlert, NButton, NIcon, NInput, NSelect, NImage } from "naive-ui";
import store from '../store'
import loading from 'vue3-loading-overlay'
import { SpinnerIos20Filled } from '@vicons/fluent'
import { Cpu } from '@vicons/tabler'
import { EditRegular } from '@vicons/fa'
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
    NSelect, NImage
  },
  setup() {
    const computers = ref({})
    const isLoading = ref(true)
    const error = ref()
    const searchInput = ref()
    const games = ref(gameList)
    const filteredGames = ref([])
    const selectedGame = ref([])
    return {
      computers, isLoading, error,
      searchInput, games, filteredGames,
      selectedGame
    }
  },
  created() {
    if (Object.keys(store.state.allComputers).length) {
      this.computers = store.state.allComputers;
      this.isLoading = false;
      this.getImages()
    } else {
      axiosClient.get(`/computer`)
        .then((response) => {
          this.computers = response.data
          this.getImages()
          store.commit('setAllComputers', response.data)
          this.isLoading = false;
        })
        .catch((error) => {
          this.error = error
          this.isLoading = false;
        })
    }
  },
  methods: {
    search() {
      console.log(this.computers)
      this.computers = this.computers.filter(computer => {
        return computer.pcVideogames[0].id_videogame == this.selectedGame
      });
    },
    clear() {
      this.computers = store.state.allComputers;
      this.selectedGame = ''
      this.searchInput = ''
    },
    getImages() {
      this.computers.forEach(element => {
        element.pcVideogames.forEach(game => {
          axios.get(`https://store.steampowered.com/api/appdetails?appids=${game.id_videogame}`)
            .then((response) => {
              game.imageUrl = response.data[game.id_videogame].data.header_image;
              console.log(this.computers);
              return true
            })
        })
      });
    },

  },
  computed: {
    filteredList() {
      return this.games.filter(game => {
        return game.label.includes(this.searchInput)
      });
    },
    getComputers() {
      return this.computers
    }
  }


}
</script>

<style>

</style>
