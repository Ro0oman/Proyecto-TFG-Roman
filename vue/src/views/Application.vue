<template>
  <loading :active="isLoading" :can-cancel="true">
    <div class="text-xl p-4 bg-black text-white rounded-lg ">
      <Icon class="animate-spin">
        <SpinnerIos20Filled />
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
  <div v-if="info">
    <n-alert title="Success" type="success">
      <div>
        {{ info }}
      </div>
    </n-alert>
  </div>
  <page-component title="PC-Builder">
    <div class="flex flex-wrap justify-center font-medium ">
      <div class="w-full m-auto px-4 my-4 p-4 rounded-lg  min-h-[80vh]">
        <div class="flex justify-between font-bold">
          <div class="text-white m-auto text-center text-3xl font-sans">Your computers</div>
        </div>
        <div class="flex flex-wrap justify-center font-medium " v-if="computers.length">
          <div class="w-2/3 m-auto px-4 my-4 p-4 rounded-lg  min-h-[80vh]">
            <div class="flex justify-between font-bold">
              <div class="ml-4 text-center text-2xl textYellow">Community computers</div>
              <div>
                <n-button type="success" ghost @click="$router.push('/pccreator')" color="yellow">
                Create your PC
              </n-button>
              <n-button type="info" ghost @click="reload" color="#ADD8E6" class="mx-1">
                Reload
              </n-button>
              </div>
            </div>
            <div class="grid lg:grid-cols-3 grid-cols-1 sm:grid-cols-1 gap-4 w-full mt-4 justify-items-strech">
              <div v-for="(computer, index) in getComputers" :key="computer">
                <n-card class="bg-slate-600 w-full cursor-pointer transition hover:scale-110" :bordered="false"
                  @click="goToComputer(computer)">
                  <template #cover v-if="computer.pcVideogames.length">
                    <img :src="computer.pcVideogames[0].imageUrl">
                  </template>
                  <div>
                    <div class="text-xl flex fler-row">
                      <span class="w-full truncate">
                        {{ computer.pc_name }}
                      </span>
                      <span>
                        <small class="text-xs truncate link">
                          {{ computer.user.name }}
                        </small>
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
                <div class="w-full flex justify-center my-2 bg-slate-400 p-2 rounded items-center">
                  <n-button text-color="yellow" @click="destroyComputer(computer.id)">
                    Delete computer
                  </n-button>
                  <n-switch 
                  v-model:value="computer.visible" 
                  @update:value="changeVisibility(computer, index)">
                    <template #checked>
                      Visible
                    </template>
                    <template #unchecked>
                      Invisible
                    </template>
                  </n-switch>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-else class="w-full">
          <div class="m-auto">
            <n-alert class="bg-slate-500 rounded-lg p-2">
              <template #icon>
                <n-icon class="text-3xl text-white">
                  <EmojiSad20Regular />
                </n-icon>
              </template>
              <p class="text-white text-xl font-bold ">
                You have not created any computer yet
              </p>
              <div class="text-xl textYellow  flex-col m-auto items-center justify-center mt-4">
                <p class="m-auto">
                  Create one Here :D
                </p>
                <n-button class="m-auto" type="success" ghost @click="$router.push('/pccreator')" color="yellow">
                  Create your PC
                </n-button>
              </div>
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
import { Cpu } from '@vicons/tabler'
import { EditRegular } from '@vicons/fa'
import { Icon } from '@vicons/utils'
import { SpinnerIos20Filled } from '@vicons/fluent'
import loading from 'vue3-loading-overlay'
import axios from 'axios'

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
  setup() {
    const user = ref({})
    const computers = ref([])
    const rawComputers = ref([])
    const numComputers = ref()
    const isLoading = ref(true)
    const id = ref()
    const error = ref()
    const info = ref()
    return {
      user, computers, numComputers,
      isLoading, id, error, info,
      rawComputers
    }
  },
  created() {
    /* Get user data with api petition */
      this.id = parseInt(sessionStorage.getItem('ID'));
      axiosClient.get(`/userPCS/${this.id}`)
        .then((response) => {
          store.commit('setComputers', response.data)
          this.computers = response.data
          this.computers.forEach(computer=> {
            if(computer.visible == 1){
              computer.visible = true
            }else{
              computer.visible = false
            }
          })
          this.getImages()
          this.isLoading = false;
        })
        .catch((error) => {
          this.error = error
        })
  },
  methods: {
    changeVisibility(computer, indice){
        axiosClient.put(`computer/${computer.id}`, {visible:this.computers[indice].visible})
        .then(response =>{
          console.log(response)
        }) 
    },
    goToComputer(computer) {
      store.commit('setComputerId', computer);
      this.$router.push({
        path: '/computer/' + computer.id
      })
    },
    destroyComputer(id) {
      axiosClient.delete(`computer/${id}`)
        .then(response => {
          this.info = 'Computer deleted'
          setTimeout(() => {
            window.location.reload()
          }, 500);
        })
    },
    getImages() {
      this.computers.forEach(element => {
        element.pcVideogames.forEach(game => {
          axiosClient.get(`/getGameID/${game.id_videogame}`)
            .then((response) => {
              game.imageUrl = response.data[game.id_videogame].data.header_image;
              return true
            })
        })
      });
    },
    reload(){
      window.location.reload()
    }
  },
  computed: {
    getComputers() {
      return this.computers
    }
  }
}
</script>
  
<style scoped>
span {
  color: yellow;
}
</style>