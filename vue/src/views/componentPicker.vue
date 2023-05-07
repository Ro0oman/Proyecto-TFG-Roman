<template>
    <loading :active="isLoading" :can-cancel="true">
        <div class="text-xl p-4 bg-black text-white rounded-lg ">
            <Icon class="animate-spin">
                <SpinnerIos20Filled />
            </Icon>
            {{ loadingText }}
        </div>
    </loading>
    <div class="flex lg:flex-row flex-col items-center my-10 justify-between w-3/4 m-auto">
        <div v-if="game" class="lg:w-1/3 mx-10 bg-white p-6 m-4 rounded ">
            <p class="text-4xl textYellow my-6 font-bold">
                {{ game.name }}
            </p>
            <div class="textYellow">
                <p>Game requirements</p>
                <n-tabs type="segment" animated class="bg-slate-200 p-4 rounded">
                    <n-tab-pane name="Minimun requirements">
                        <div v-html="game.pc_requirements.minimum" class="textYellow">
                        </div>
                    </n-tab-pane>
                    <n-tab-pane name="Recomended requirements">
                        <div v-html="game.pc_requirements.recommended" class="textYellow">
                        </div>
                    </n-tab-pane>
                </n-tabs>
            </div>
        </div>
        
        <div class="lg:w-1/3 ">
            <n-card>
                <n-transfer ref="transfer" source-filterable v-model:value="value" :options="createOptions" />
            </n-card>
            <div class="flex flex-row w-full items-center justify-center p-4">
                <n-button type="info" @click="nextSteps" class="mx-2">
                    Next Step
                </n-button>
            </div>
        </div>
        <div class="lg:w-1/3 mx-2">
            <n-card>
                Components
                <ul>
                    <li v-for="(component, index) in computer">
                        <span class="capitalize textYellow">{{index}}</span> -> {{component}}    
                        
                    </li>
                </ul>
            </n-card>
        </div>
    </div>
</template>
<script>
import { ref } from 'vue';
import { NTabs, NTabPane, NTransfer, NCard, NButton } from 'naive-ui';
import store from '../store'
import draggable from 'vuedraggable'
import loading from 'vue3-loading-overlay'
import axios from 'axios'
import axiosClient from '../axios';
import { SpinnerIos20Filled } from '@vicons/fluent'
import { Icon } from '@vicons/utils'

export default {
    components: {
        draggable, loading, SpinnerIos20Filled,
        Icon, NTabs, NTabPane, NTransfer, NCard, NButton
    },
    setup() {
        const game = ref()
        const loadingText = ref()
        const isLoading = ref(false)
        const computer =ref({
            cpu:'Incompleted',
            motherboard:'Incompleted',
            gpu:'Incompleted',
            ram:'Incompleted',
            storage:'Incompleted',
            psu:'Incompleted',
        })
        const cpuList = ref({})
        const motherboardList = ref({})
        const gpuList = ref({})
        const ramList = ref({})
        const storageList = ref({})
        const psuList = ref({})
        const value = ref([])
        const actualStep = ref('cpu')
        const steps = ref({
            cpu:false,
            motherboard:false,
            gpu:false,
            ram:false,
            storage:false,
            psu:false,
        })
        return {
            game, loadingText, isLoading, computer, value,
            cpuList, steps, actualStep,motherboardList
            , gpuList, ramList, storageList, psuList
        }
    },
    created() {
        if (Object.keys(store.state.game).length) {
            this.game = store.state.game;
            console.log(this.game)
        } else {
            this.$router.push({
                name: 'PcCreator'
            })
        }
    },
    methods: {
        log(evt) {
            window.console.log(evt);
        },
        nextSteps(){
            debugger
            if(this.actualStep == 'cpu'){
                this.steps.cpu = true
                this.computer.cpu = this.value[0]
                this.actualStep = 'motherboard' 
                return true 
            }
            if(this.actualStep == 'motherboard'){
                this.steps.motherboard = true
                this.computer.motherboard = this.value[0]
                this.actualStep = 'gpu' 
                return true
            }
            if(this.actualStep == 'gpu'){
                this.steps.gpu = true
                this.computer.gpu = this.value[0]
                this.actualStep = 'ram' 
                return true
            }
            if(this.actualStep == 'ram'){
                this.steps.ram = true
                this.computer.ram = this.value[0]
                this.actualStep = 'storage' 
                return true
            }
            if(this.actualStep == 'storage'){
                this.steps.storage = true
                this.computer.storage = this.value[0]
                this.actualStep = 'psu' 
                return true}

            if(this.actualStep == 'psu'){
                this.steps.psu = true
                this.computer.psu = this.value[0]
                this.actualStep = 'end' 
                return true
            }
            if(this.actualStep == 'end'){
                this.computerCompleted = true
            }
        }   
    },
    computed:{
        createOptions(){        
            if(this.actualStep == 'cpu'){
                if(Object.keys(this.cpuList).length){
                    return Array.from(this.cpuList).map((v, i) => ({
                        label: v.BrandCPU+"-"+v.Model,
                        value: v.id,
                        disabled: this.value.length>0 ? (this.value[0]==v.id ? false : true) : false
                    })); 
                }else{
                    axiosClient.get('cpu')
                    .then((response)=>{
                        this.cpuList = response.data
                    })
                }
            }
            if(this.actualStep == 'motherboard'){
                axiosClient.get('motherboard')
            }
            if(this.actualStep == 'gpu'){
                
            }
            if(this.actualStep == 'ram'){
                
            }
            if(this.actualStep == 'storage'){
                
            }
            if(this.actualStep == 'psu'){
                
            }
        }
    
    }
}
</script>

<style scoped>

</style>