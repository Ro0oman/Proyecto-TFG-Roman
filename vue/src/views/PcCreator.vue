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
    <div>

    </div>
</template>

<script>

import { NSelect } from "naive-ui";
import { ref } from 'vue';
import axiosClient from '../axios';
import draggable from 'vuedraggable'
import store from '../store'


export default {
    components:{
        NSelect,draggable
    },
    setup(){
        const value = ref(null)
        const options = ref([])
        const cpus = ref([])
        const drag = ref(false)
        return{
            options, value,
            drag, cpus
        }
    },
    created(){
        if(Object.keys(store.state.cpus).length){
            this.cpus = store.state.cpus;
        }else{
            axiosClient.get('/cpu')
            .then((response)=>{
                this.options = (response.data);
                this.options.forEach(element => {
                this.cpus.push({label: element.Model, id: element.id})
            });
            store.commit('setCpus', this.options);
        })
      }
       
    }
}
</script>

<style>

</style>