<template>
    <!-- <draggable 
        v-model="cpus" 
        @start="drag=true" 
        @end="drag=false" 
        item-key="id">
        <template #item="{element}" >
            <div class="m-2 cursor-grab	">{{element.label}}</div>
        </template>
    </draggable> -->
    <div class="flex flex-col justify-center font-medium " v-if="!showGame">
        <div class="text-3xl textYellow m-auto">
            Select what is your level
        </div>
        <div class="flex flex-row m-auto p-4 mt-10 w-full justify-center">
            <n-button type="success" class="w-2/5 h-40 p-4 mx-4 text-2xl" @click="difficulty(1)">
                Help me 
            </n-button>
            <n-button type="success"  class="w-2/5 h-40 p-4 mx-4 text-2xl" @click="difficulty(2)">
                I dont need help
            </n-button> 
        </div>
    </div>
    <div v-if="showGame" class="flex flex-col justify-center font-medium">
        <div class="text-3xl textYellow m-auto">
            Select what game do you want to play
        </div>
        <div class="flex flex-row m-auto p-4 mt-10 w-full justify-center">
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
            </div>
        </div>
    </div>
</template>

<script>

import { NSelect, NButton } from "naive-ui";
import { ref } from 'vue';
import axiosClient from '../axios';
import draggable from 'vuedraggable'
import store from '../store'
import gameList from '../assets/steamgames.json'

export default {
    components:{
        NSelect,draggable,NButton
    },
    setup(){
        const value = ref(null)
        const options = ref([])
        const cpus = ref([])
        const drag = ref(false)
        const difficulty = ref(false)
        const games = ref(gameList)
        const searchInput = ref()
        const selectedGame = ref([])

        return{
            options, value,
            drag, cpus, difficulty, 
            games, searchInput,
            selectedGame
        }
    },
    created(){
        console.log(this.difficulty);
        if(Object.keys(store.state.cpus).length){
            this.cpus = store.state.cpus;
        }else{
            axiosClient.get('/cpu')
            .then((response)=>{
                this.options = (response.data);
            //     this.options.forEach(element => {
            //     this.cpus.push({label: element.Model, id: element.id})
            // });
            // store.commit('setCpus', this.options);

            
        })
      }
       
    }, 
    methods:{
        difficulty(param){
            this.difficulty = param
            console.log(this.difficulty);
        },
        search() {
            console.log(this.computers)
            this.computers = this.computers.filter(computer => {
                return computer.pcVideogames[0].id_videogame == this.selectedGame
            });
        },
    },
    computed:{
        showGame(){
            if(this.difficulty == false){
                return false
            }else{
                return true
            }
        },
        filteredList() {
            return this.games.filter(game => {
                return game.label.includes(this.searchInput)
            });
        },
    }
}
</script>

<style>
figure {
  display: grid;
  border-radius: 1rem;
  overflow: hidden;
  cursor: pointer;
}
figure > * {
  grid-area: 1/1;
  transition: .4s;
}
figure figcaption {
  display: grid;
  align-items: end;
  font-family: sans-serif;
  font-size: 2.3rem;
  font-weight: bold;
  color: #0000;
  padding: .75rem;
  background: var(--c,#0009);
  clip-path: inset(0 var(--_i,100%) 0 0);
  -webkit-mask:
    linear-gradient(#000 0 0),
    linear-gradient(#000 0 0);
  -webkit-mask-composite: xor;
  -webkit-mask-clip: text, padding-box;
}
figure:hover figcaption{
  --_i: 0%;
}
figure:hover img {
  transform: scale(1.2);
}
@supports not (-webkit-mask-clip: text) {
  figure figcaption {
   -webkit-mask: none;
   color: #fff;
  }
}

</style>