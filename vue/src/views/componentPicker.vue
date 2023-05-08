<template>
    <loading :active="isLoading" :can-cancel="true">
        <div class="text-xl p-4 bg-black text-white rounded-lg ">
            <Icon class="animate-spin">
                <SpinnerIos20Filled />
            </Icon>
            {{ loadingText }}
        </div>
    </loading>
    <div v-if="game" class="w-full mx-10 p-6 m-4 rounded bg-[#475569] ">
            <p class="text-4xl textYellow my-6 font-bold">
                {{ game.name }}
            </p>
            <div>
                <p class="textYellow">Game requirements</p>
                <n-tabs type="segment" animated class="bg-slate-200 p-4 rounded">
                    <n-tab-pane name="Minimun requirements">
                        <div v-html="game.pc_requirements.minimum" class="text-black">
                        </div>
                    </n-tab-pane>
                    <n-tab-pane name="Recomended requirements">
                        <div v-html="game.pc_requirements.recommended" class="text-black">
                        </div>
                    </n-tab-pane>
                </n-tabs>
            </div>
        </div>
    <div class="flex lg:flex-row flex-col items-center my-10 justify-between w-3/4 m-auto">
        

        <div class="lg:w-1/2 min-h-[50vh]" v-if="!computerCompleted">
            <n-card>
                <n-transfer ref="transfer" source-filterable v-model:value="value" :options="createOptions" />
            </n-card>
            <div class="flex flex-row w-full items-center justify-center p-4">
                <n-button type="info" @click="nextSteps" class="mx-2">
                    Next Step
                </n-button>
            </div>
        </div>
        
        <div class="lg:w-1/2 mx-2 min-h-[50vh]" v-if="!computerCompleted">
            <n-card>
                Components
                <ul class="min-h-[40vh] flex flex-col justify-between ">
                    <li v-for="(component, index) in computer" class="rounded bg-slate-600 p-4 text-white cursor-pointer my-2"
                    :class="actualStep == index ? '':'bg-blue-300'"
                        @click="actualStep = index">
                        <button>
                            <span class="capitalize" >
                                {{ index }}
                            </span> ->
                            <b>
                                {{ component }}
                            </b>
                        </button>
                    </li>
                    
                </ul>
            </n-card>
        </div>
        <div class="lg:w-3/3 mx-2 min-h-[50vh] bg-slate-500" v-else>
            <n-card>
                Components
                <ul class="min-h-[40vh] flex flex-col justify-between ">
                    <li v-for="(component, index) in computer" class="rounded p-4  bg-slate-600 text-white cursor-pointer my-2"
                        @click="actualStep = index">
                        <button>
                            <span class="capitalize" >
                                {{ index }}
                            </span> ->
                            <b>
                                {{ component }}
                            </b>
                        </button>
                    </li>
                </ul>
                <div class="w-full flex flex-row justify-center">
                    <n-button type="info" @click="editComputer" text-color="black" class="mx-2 text-xl">
                        Edit computer
                    </n-button>
                    <n-button type="info" @click="editComputer" text-color="black"  class="mx-2 text-xl">
                            Create computer
                    </n-button>
                </div>
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
        const computer = ref({
            cpu: 'Incompleted',
            motherboard: 'Incompleted',
            gpu: 'Incompleted',
            ram: 'Incompleted',
            storage: 'Incompleted',
            psu: 'Incompleted',
        })
        const cpuList = ref({})
        const cpuSelected = ref({})
        const motherboardList = ref({})
        const gpuList = ref({})
        const ramList = ref({})
        const storageList = ref({})
        const psuList = ref({})
        const value = ref([])
        const actualStep = ref('cpu')
        const computerCompleted = ref(false)
        return {
            game, loadingText, isLoading, computer, value,
            cpuList,actualStep, motherboardList
            , gpuList, ramList, storageList, psuList,
            computerCompleted, cpuSelected
        }
    },
    async created() {
        if (Object.keys(store.state.game).length) {
            this.game = store.state.game;
            console.log(this.game)
            /* Load data */
            await axiosClient.get('cpu')
                .then((response) => {
                    this.cpuList = response.data
                });
            await axiosClient.get('motherboard')
                .then((response) => {
                    this.motherboardList = response.data
                });
            await axiosClient.get('ram')
                .then((response) => {
                    this.ramList = response.data
                });
            await axiosClient.get('gpu')
                .then((response) => {
                    this.gpuList = response.data
                });
            await axiosClient.get('storage')
                .then((response) => {
                    this.storageList = response.data
                });
            await axiosClient.get('psu')
                .then((response) => {
                    this.psuList = response.data
                });
        } else {
            this.$router.push({
                name: 'PcCreator'
            })
        }
    },
    methods: {
        nextSteps() {
            console.log(this.actualStep);
            if (this.actualStep == 'cpu') {
                this.computer.cpu = this.cpuList.filter( obj => obj.id == this.value[0]);
                this.actualStep = 'motherboard'
                this.computerCompleted = false
                return true
            }
            if (this.actualStep == 'motherboard') {
                this.computer.motherboard = this.motherboardList.filter( obj => obj.id == this.value[0]);
                this.actualStep = 'gpu'
                this.computerCompleted = false
                return true
            }
            if (this.actualStep == 'gpu') {
                this.computer.gpu = this.gpuList.filter( obj => obj.id == this.value[0]);
                this.actualStep = 'ram'
                this.computerCompleted = false
                return true
            }
            if (this.actualStep == 'ram') {
                this.computer.ram = this.ramList.filter( obj => obj.id == this.value[0]);
                this.actualStep = 'storage'
                this.computerCompleted = false
                return true
            }
            if (this.actualStep == 'storage') {
                this.computer.storage = this.storageList.filter( obj => obj.id == this.value[0]);
                this.actualStep = 'psu'
                this.computerCompleted = false
                return true
            }

            if (this.actualStep == 'psu') {
                this.computer.psu = this.psuList.filter( obj => obj.id == this.value[0]);
                this.actualStep = 'end'
                this.computerCompleted = true
            }
        },
        editComputer(){
            this.actualStep = 'cpu'
            this.computerCompleted = false
            this.nextSteps()
        }
    },
    computed: {
        createOptions() {
            if (this.actualStep == 'cpu') {
                return Array.from(this.cpuList).map((v, i) => ({
                    label: v.BrandCPU + "-" + v.Model,
                    value: v.id,
                    disabled: this.value.length > 0 ? (this.value[0] == v.id ? false : true) : false
                }));
                
            }
            if (this.actualStep == 'motherboard') {
                return Array.from(this.motherboardList).map((v, i) => ({
                    label: v.modelMotherboard + "-" + v.priceMotherboard,
                    value: v.id,
                    disabled: this.value.length > 0 ? (this.value[0] == v.id ? false : true) : false
                }));
            }
            if (this.actualStep == 'gpu') {
                    return Array.from(this.gpuList).map((v, i) => ({
                        label: v.modelGPU + "-" + v.brandGPU,
                        value: v.id,
                        disabled: this.value.length > 0 ? (this.value[0] == v.id ? false : true) : false
                    }));
            }
            if (this.actualStep == 'ram') {
                return Array.from(this.ramList).map((v, i) => ({
                    label: v.quantity + "GB-" + v.type_ram,
                    value: v.id,
                    disabled: this.value.length > 0 ? (this.value[0] == v.id ? false : true) : false
                }));
            }
            if (this.actualStep == 'storage') {
                return Array.from(this.storageList).map((v, i) => ({
                    label: v.quantity + "-" + v.type_storage,
                    value: v.id,
                    disabled: this.value.length > 0 ? (this.value[0] == v.id ? false : true) : false
                }));
            }
            if (this.actualStep == 'psu') {
                return Array.from(this.psuList).map((v, i) => ({
                    label: v.power + "W",
                    value: v.id,
                    disabled: this.value.length > 0 ? (this.value[0] == v.id ? false : true) : false
                }));
            }
        }

    }
}
</script>

<style scoped></style>