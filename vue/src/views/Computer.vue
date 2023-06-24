<template >
    <div v-if="mostrar">
        <div class="bg-cover" v-bind:style="{ backgroundImage: 'url(' + videogameData.background + ')' }">
            <div class="pt-6">
                <!-- Image gallery -->
                <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-x-8 lg:px-8">
                    <div class="aspect-h-4 aspect-w-3 hidden overflow-hidden rounded-lg lg:block">
                        <n-image object-fit="cover" class="h-full w-full" :src="videogameData.screenshots[0].path_full" />
                    </div>
                    <div class="hidden lg:grid lg:grid-cols-1 lg:gap-y-8">
                        <div class="aspect-h-2 aspect-w-3 overflow-hidden rounded-lg">
                            <n-image object-fit="cover" class="h-full w-full"
                                :src="videogameData.screenshots[1].path_full" />
                        </div>
                        <div class="aspect-h-2 aspect-w-3 overflow-hidden rounded-lg">
                            <n-image object-fit="cover" class="h-full w-full"
                                :src="videogameData.screenshots[2].path_full" />
                        </div>
                    </div>
                    <div class="aspect-h-5 aspect-w-4 lg:aspect-h-4 lg:aspect-w-3 sm:overflow-hidden sm:rounded-lg">
                        <n-image object-fit="cover" class="h-full w-full" :src="videogameData.screenshots[3].path_full" />
                    </div>
                </div>

                <!-- Product info -->
                <div
                    class=" max-w-2xl m-auto px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16">
                    <div class="lg:col-span-2 my-2 lg:border-gray-200 lg:pr-8">
                        <h1 class="text-2xl font-bold tracking-tight textYellow sm:text-3xl">{{ storeComputerId.pc_name }}
                        </h1>
                    </div>

                    <!-- Options -->
                    <div class="mt-4 lg:row-span-3 lg:mt-0">
                        <h2 class="textYellow">Created by:</h2>
                        <p class="text-3xl tracking-tight textYellow">{{ storeComputerId.user.name }} at <br>
                            <span class="text-sm">
                                {{ storeComputerId.created_at}}
                            </span> 
                        </p>
                        <div class="mt-10">
                            <button role="link" @click="getUrl(videogameData.steam_appid)"
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
                        </div>
                    </div>

                    <div
                        class="py-10 w-full lg:col-span-2 text-black lg:col-start-1 lg:border-r lg:border-gray-200 lg:pb-16 lg:pr-8 lg:pt-6 textYellow mx-auto bg-slate-200 rounded-lg p-3 bg-opacity-75">
                        <!-- Description and details -->
                        <n-tabs type="line" animated class="w-full" >
                            <n-tab-pane name="Computer" tab="Computer" >
                                <n-list hoverable class="bg-transparent">
                                    <n-list-item>
                                        <n-thing title="Description" content-style="margin-top: 10px;">
                                            {{ storeComputerId.description }}
                                        </n-thing>
                                    </n-list-item>
                                    <n-list-item>
                                        <n-thing title="Components" content-style="margin-top: 10px;">
                                            <div class="mt-4 text-black">
                                                <div>
                                                    CPU: {{ storeComputerId.cpu.Model }}
                                                </div>
                                                <div>
                                                    Motherboard{{ storeComputerId.motherboard.modelMotherboard }}
                                                </div>
                                                <div>
                                                    GPU
                                                </div>
                                                {{ storeComputerId.gpu.modelGPU }}
                                                <div>
                                                    Power supply {{ storeComputerId.psu.power }}W
                                                </div>
                                                <div>
                                                    Storage {{ storeComputerId.storage.quantity }}GB {{
                                                        storeComputerId.storage.type_storage
                                                    }}
                                                </div>
                                            </div>
                                        </n-thing>
                                    </n-list-item>
                                </n-list>
                            </n-tab-pane>
                            <n-tab-pane name="Game" tab="Game">
                                <div>
                                    Game data
                                    <div class="mt-10">
                                        <h2 class="text-sm font-medium text-gray-900">Game description</h2>
                                        <div class="mt-4 space-y-6">
                                            <p class="text-sm text-gray-600" v-html="videogameData.about_the_game">
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-10">
                                        <h2 class="text-sm font-medium text-gray-900">PC requierements</h2>
                                        <div class="mt-4 space-y-6">
                                            <p>
                                                Minimum Req.
                                            </p>
                                            <p class="text-sm text-gray-600" v-html="videogameData.pc_requirements.minimum">
                                            </p>
                                            <p>
                                                Recomended Req.
                                            </p>
                                            <p class="text-sm text-gray-600"
                                                v-html="videogameData.pc_requirements.recommended">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </n-tab-pane>
                        </n-tabs>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import { ref } from 'vue'
import store from '../store'
import { NButton, NCard, NImage, NList, NListItem, NThing, NTabs, NTabPane, NSwitch } from 'naive-ui'
import axios from 'axios'
import axiosClient from "../axios";

export default {
    components: {
        NButton, NCard, NImage, NList, NListItem, NThing, NTabs, NTabPane, NSwitch
    },
    setup() {
        const routeComputerId = ref()
        const storeComputerId = ref()
        const mostrar = ref(false)
        const videogameData = ref({})
        return {
            routeComputerId,
            storeComputerId,
            mostrar, videogameData
        }
    },
    created() {
        this.storeComputerId = store.state.computerId;
        if (Object.keys(store.state.computerId).length) {
            this.storeComputerId = store.state.computerId;
            let gameId = this.storeComputerId.pcVideogames[0].id_videogame;
            axiosClient.get(`/getGameID/${gameId}`)
                .then((response) => {
                    this.videogameData = response.data[gameId].data;
                    if(this.videogameData.background == undefined){
                        this.$router.push({
                            name: 'Dashboard'
                        })
                    }
                    return true
                })
                .catch(error=>{
                    this.$router.push({
                        name: 'Dashboard'
                    })
                })
            this.mostrar = true;
            
        } else {
            this.mostrar = false;
            this.$router.push({
                name: 'Dashboard'
            })
        }
    },
    methods: {
        getUrl(id) {
            window.open(`https://store.steampowered.com/app/${id}`, '_blank', 'noreferrer');
        },
        getUserData(id){

        }
    }
}

</script>
<style>

</style>