<template>
  <loading :active="isLoading" :can-cancel="true">
    <div class="text-xl p-4 bg-black text-white rounded-lg">
      <Icon class="animate-spin">
        <SpinnerIos20Filled />
      </Icon>
      Loading profile
    </div>
  </loading>
  <!-- component -->
  <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css">
  <link rel="stylesheet"
    href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">

  <main class="profile-page">
    <section class="relative block h-500-px">
      <div class="absolute top-0 w-full h-full bg-center bg-cover">
        <span id="blackOverlay" class="w-full h-full absolute opacity-50 bg-black"></span>
      </div>
      <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden h-70-px"
        style="transform: translateZ(0px)">
        <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
          version="1.1" viewBox="0 0 2560 100" x="0" y="0">
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
                    {{ getCharAt }}
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
                <n-input class="text-4xl font-semibold p-1" v-model:value="user.name" type="text" placeholder="Change your name" />
              </h3>
              <n-button type="info" text-color="black" @click="updateProfile" class="bg-blue-300  p-2 my-2">
                Update profile
              </n-button>
              <div class="flex justify-center py-4">
                <div class="p-3 text-center">
                  <p class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">Computers :
                    {{ computers.length }}</p>
                  <span class="text-xl text-blueGray-400 "></span>
                </div>
              </div>
            </div>
            <div class="mt-10 py-10 border-t border-blueGray-200 text-center">
              <div class="flex flex-wrap justify-center">
                <div class="flex flex-wrap justify-center font-medium ">
                  <div class="w-full m-auto px-4 my-4 p-4 rounded-lg  min-h-[80vh]">
                    <div class="flex justify-between font-bold">
                      <div class="text-black  ml-4 text-center text-2xl">Your computers</div>
                    </div>
                    <div class="grid lg:grid-cols-2 sm:grid-cols-2 gap-4 w-full mt-4 justify-items-strech" v-if="getComputers">
                      <div v-for="computer in getComputers" :key="computer">
                        <n-card class="bg-slate-600 w-full cursor-pointer transition hover:scale-105"
                          @click="goToComputer(computer)" :bordered="false">
                          <template #cover v-if="computer.pcVideogames.length">
                            <img :src="computer.pcVideogames[0].imageUrl">
                          </template>
                          <div>
                            <div class="text-xl flex fler-row truncate">
                              <span class="w-full">
                                {{ computer.pc_name }}
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
                    <div v-else>
                      <div class="flex justify-between font-bold">
                        <div class="text-black  ml-4 text-center text-2xl">You dont have any computer</div>
                      </div>
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
import { NAvatar, NButton, NCard, NIcon, NAlert, NInput } from "naive-ui";
import store from "../store";
import PageComponent from "../components/PageComponent.vue";
import { ref } from "vue";
import axiosClient from "../axios";
import { Icon } from "@vicons/utils";
import { VideogameAssetTwotone } from "@vicons/material";
import { EmojiSad20Regular } from "@vicons/fluent";
import { People20Filled } from "@vicons/fluent";
import loading from 'vue3-loading-overlay'
import { SpinnerIos20Filled } from '@vicons/fluent'
import axios from 'axios'
import { useMessage } from 'naive-ui'

export default {
  components: {
    PageComponent,
    NAvatar,
    NCard,
    Icon,
    VideogameAssetTwotone,
    People20Filled,
    NButton,
    NIcon,
    NAlert,
    EmojiSad20Regular,
    loading,
    SpinnerIos20Filled,
    NInput,
  },
  setup() {
    const message = useMessage()
    const user = ref({name:'User'});
    const computers = ref([]);
    const isLoading = ref(true)
    return {
      user,
      computers,
      isLoading,
      message,
    };
  },
  async created() {
    axiosClient.get(`user/${sessionStorage.getItem("ID")}`)
    .then(response=>{
      this.user = response.data
      this.isLoading = false;
    })
    if (Object.keys(store.state.computers).length) {
      this.computers = store.state.computers;
      console.log(this.computers);
      this.getImages();
    } else {
      this.id = parseInt(sessionStorage.getItem("ID"));
      axiosClient
        .get(`/userPCS/${this.id}`)
        .then((response) => {
          store.commit("setComputers", response.data);
          this.computers = response.data;
          console.log(this.computers);
          this.getImages();
          this.isLoading = false;
        })
        .catch((error) => {
          this.error = error;
        });
        
    }
  },
  computed: {
    getComputers() {
      return this.computers;
    },
    getCharAt(){
      return this.user.name.charAt(0)
    }

  },
  methods: {
    updateProfile(){
      axiosClient.put(`user/${sessionStorage.getItem("ID")}`, {name:this.user.name})
        .then(response =>{
          this.message.success(
            "Profile updated"
          )
        })
        .catch(error =>{
          this.message.error(
            "Something went wrong"
          )
        }) 
    },
    getImages() {
      this.computers.forEach((element) => {
        element.pcVideogames.forEach((game) => {
          axios
            .get(
              `https://store.steampowered.com/api/appdetails?appids=${game.id_videogame}`,
              {
                headers: {
                  "Access-Control-Allow-Origin": "*",
                },
              }
            )
            .then((response) => {
              game.imageUrl =
                response.data[game.id_videogame].data.header_image;
              console.log(this.computers);
              return true;
            });
        });
      });
    },
    goToComputer(computer) {
      store.commit('setComputerId', computer);
      this.$router.push({
        path: '/computer/' + computer.id
      })
    },
  },
};
</script>
  
<style scoped>
span {
  color: yellow;
}
</style>