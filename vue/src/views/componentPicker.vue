<template>
     <n-modal v-model:show="showModal">
        <n-card
        style="width: 600px"
        title="Confirmation"
        :bordered="false"
        size="huge"
        role="dialog"
        aria-modal="true"
        
        >
        Have you completed the computer? Or do you want to make any changes?
        <div class="w-full flex flex-row items-center justify-center my-4">
            <n-button type="info" @click="setTitle()" class="bg-blue-700  mx-2">
                Complete PC
            </n-button>
            <n-button type="warning" @click="showModal = false" class="bg-green-700 mx-2">
                Modify PC
            </n-button>
        </div>
        </n-card>
    </n-modal>
    <loading :active="isLoading" :can-cancel="true">
        <div class="text-xl p-4 bg-black text-white rounded-lg ">
            {{ loadingText }}
            <Icon class="animate-spin">
                <SpinnerIos20Filled />
            </Icon>
        </div>
    </loading>
    <div v-if="game" class="w-2/3 mx-auto p-6 my-6 rounded bg-[#475569] ">
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
    <div class="flex lg:flex-row flex-col items-center my-10 justify-between w-3/4 m-auto" v-if="!finalStep" >
        <div class="lg:w-1/2 " v-if="!computerCompleted">
            <n-card>
                <n-transfer ref="transfer" class="min-h-[50vh]" source-filterable 
                v-model:value="value" :options="createOptions" />
            </n-card>
            <div class="flex flex-row w-full items-center justify-center p-4">
                <n-button type="info" @click="nextSteps" class="mx-2 p-4" v-if="actualStep!=='psu'">
                    Next Step
                </n-button>
                <n-button type="info" @click="showConfirmation" class="mx-2" v-else>
                    Complete computer
                </n-button>
            </div>
        </div>
        <div class="lg:w-1/2 mx-2" v-if="!computerCompleted">
            <n-card>
                Components
                <ul class="flex flex-col justify-between ">
                    <li v-for="(component, index) in computer" class="rounded bg-slate-600 p-4 text-white cursor-pointer my-2"
                    :class="actualStep == index ? '':'bg-blue-300'"
                        @click="actualStep = index">
                        <button>
                            <span class="capitalize" >
                                {{ index }}
                            </span> ->
                            <b>
                                {{ index == 'cpu' ? component[0].Model+"-"+component[0].BrandCPU  : '' }}
                                {{ index == 'motherboard' ? component[0].modelMotherboard+"-"+component[0].priceMotherboard  : '' }}
                                {{ index == 'gpu' ? component[0].modelGPU+"-"+component[0].brandGPU  : '' }}
                                {{ index == 'ram' ? component[0].quantity+"GB-"+component[0].type_ram : '' }}
                                {{ index == 'storage' ? component[0].quantity+"-"+component[0].type_storage  : '' }}
                                {{ index == 'psu' ? component[0].power+"W"  : '' }}
                            </b>
                        </button>
                        <div class="text-red-500 font-bold text-xl" v-if="computerErrors">
                            {{ computerErrors}}
                        </div>
                    </li>
                </ul>
            </n-card>
        </div>  
        <div v-else class="w-2/3 m-auto p-4 bg-slate-700 rounded flex flex-col">
            <n-alert title="Error" type="error" v-if="inputError">
            COMPLETE ALL FIELDS
        </n-alert>
        <span class="textYellow">Name your computer</span>
        <n-input v-model:value="computerName" type="text" placeholder="Basic Input" class="my-4" />
        <span class="textYellow">Add a little description</span>
        
        <n-input
            v-model:value="computerDescription"
            type="textarea"
            placeholder="Basic Textarea"
        />
        <n-button type="info" class="my-4 m-auto" @click="createComputer()" >
            Create PC
        </n-button>
    </div>  
    </div>
    
</template>
<script>
import { ref } from 'vue';
import { NTabs, NTabPane, NTransfer, NCard, NButton, NInput, NModal, NAlert } from 'naive-ui';
import store from '../store'
import draggable from 'vuedraggable'
import loading from 'vue3-loading-overlay'
import axiosClient from '../axios';
import { SpinnerIos20Filled } from '@vicons/fluent'
import { Icon } from '@vicons/utils'

export default {
    components: {
        draggable, loading, SpinnerIos20Filled,
        Icon, NTabs, NTabPane, NTransfer, NCard, NButton
        ,NInput ,NModal, NAlert
    },
    setup() {
        const game = ref()
        const showModal = ref(false)
        const loadingText = ref()
        const isLoading = ref(true)
        const validInput = ref({})
        const computerName = ref()
        const computerDescription = ref()
        const computer = ref({
            cpu: 'Incompleted',
            motherboard: 'Incompleted',
            gpu: 'Incompleted',
            ram: 'Incompleted',
            storage: 'Incompleted',
            psu: 'Incompleted',
        })
        const computerErrors = ref()
        const validateComputer = ref([
            'cpu', 'motherboard', 'gpu', 'ram',
            'storage', 'psu'
        ])
        const cpuList = ref({})
        const cpuSelected = ref({})
        const motherboardList = ref({})
        const gpuList = ref({})
        const ramList = ref({})
        const storageList = ref({})
        const psuList = ref({})
        const value = ref([])
        const actualStep = ref('cpu')
        const finalStep = ref(false)
        const computerCompleted = ref(false)
        const error = ref()
        const inputError = ref()
        return {
            game, loadingText, isLoading, computer, value,
            cpuList,actualStep, motherboardList
            , gpuList, ramList, storageList, psuList,
            computerCompleted, cpuSelected, finalStep,
            validateComputer, computerName, computerDescription,
            validInput, showModal, computerErrors, error,
            inputError
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
                    this.loadingText = "Loading CPU'S"
                });
            await axiosClient.get('motherboard')
                .then((response) => {
                    this.motherboardList = response.data
                    this.loadingText = "Loading motherboards"
                });
            await axiosClient.get('ram')
                .then((response) => {
                    this.ramList = response.data
                    this.loadingText = "Loading ram modules"

                });
            await axiosClient.get('gpu')
                .then((response) => {
                    this.gpuList = response.data
                    this.loadingText = "Loading Graphics cards"

                });
            await axiosClient.get('storage')
                .then((response) => {
                    this.storageList = response.data
                    this.loadingText = "Loading Storage modules"

                });
            await axiosClient.get('psu')
                .then((response) => {
                    this.psuList = response.data
                    this.loadingText = "Loading Power supplies"
                    this.isLoading = false
                });
        } else {
            this.$router.push({
                name: 'PcCreator'
            })
        }
    },
    methods: {
        showConfirmation(){
            if (this.actualStep == 'psu' && this.value != '') {
                this.computer.psu = this.psuList.filter( obj => obj.id == this.value[0]);
                this.value = ''
                this.actualStep = 'end'
                console.log(this.computer)
                this.showModal = true
            }else{
                this.computerErrors='You have to complete all fields >:('
            }
        },
        setTitle(){
            this.computerCompleted = true
            this.showModal = false
        },
        createComputer(){
            let computerCreated = {
                pc_name : this.computerName,
                description : this.computerDescription,
                cpu : this.computer.cpu[0].id,
                motherboard : this.computer.motherboard[0].id,
                gpu : this.computer.gpu[0].id,
                storage : this.computer.storage[0].id,
                psu : this.computer.psu[0].id,
                user : sessionStorage.getItem('ID'),
                id_videogame : this.game.steam_appid,
                visible : 0
            }

            if (this.computerName == '' || this.computerDescription == '' || this.computerName == undefined || this.computerDescription == undefined ) {
                this.inputError = 'Complete all the fields'
            } else {
                this.inputError = false
                axiosClient.post('/computer',computerCreated)
                .then((response)=>{
                    console.log(response);
                    this.$router.push({
                        name:'Application'
                    })
                })
            }
           
           
        },
        nextSteps() {
            if (this.actualStep == 'cpu' && this.value != '') {
                this.computer.cpu = this.cpuList.filter( obj => obj.id == this.value[0]);
                this.value = ''
                this.actualStep = 'motherboard'
                this.computerCompleted = false
                this.computerErrors = ''
                return true
            }else{
                this.computerErrors='You have to complete all fields >:('
            }
            if (this.actualStep == 'motherboard' && this.value != '') {
                this.computer.motherboard = this.motherboardList.filter( obj => obj.id == this.value[0]);
                this.value = ''
                this.actualStep = 'gpu'
                this.computerErrors = ''
                this.computerCompleted = false
                return true
            }else{
                this.computerErrors='You have to complete all fields >:('
            }
            if (this.actualStep == 'gpu' && this.value != '') {
                this.computer.gpu = this.gpuList.filter( obj => obj.id == this.value[0]);
                this.value = ''
                this.actualStep = 'ram'
                this.computerErrors = ''
                this.computerCompleted = false
                return true
            }else{
                this.computerErrors='You have to complete all fields >:('
            }
            if (this.actualStep == 'ram' && this.value != '') {
                this.computer.ram = this.ramList.filter( obj => obj.id == this.value[0]);
                this.value = ''
                this.actualStep = 'storage'
                this.computerErrors = ''
                this.computerCompleted = false
                return true
            }else{
                this.computerErrors='You have to complete all fields >:('
            }
            if (this.actualStep == 'storage' && this.value != '') {
                this.computer.storage = this.storageList.filter( obj => obj.id == this.value[0]);
                this.value = ''
                this.actualStep = 'psu'
                this.computerErrors = ''
                this.computerCompleted = false
                return true
            }else{
                this.computerErrors='You have to complete all fields >:('
            }
        }
    },
        editComputer(){
            this.actualStep = 'cpu'
            this.computerCompleted = false
            this.nextSteps()
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
                        disabled: this.value.length > 0 ? (this.value[0] == v.id ? true : false) : false
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

<style scoped>
input::placeholder {
    font-weight: bold;
    color: black;
}

</style>