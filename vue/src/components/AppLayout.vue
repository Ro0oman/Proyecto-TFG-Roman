<template>
    <div class="min-h-full">
      <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <router-link :to="{ name: 'Dashboard' }">
                  <img class="h-12 w-12" src="../assets/chapa.png" alt="Your Company" />
                </router-link>
              </div>
              <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-4">
                  <router-link
                  v-for="item in navigation"
                  :key="item.name"
                  :to="item.to"
                  active-class="bg-gray-900 text-white"
                  :class="[
                    $route.name === item.to.name
                      ? ''
                      : 'text-gray-300 hover:bg-gray-700 bg-transparent hover:text-white',
                    'px-3 py-2 rounded-md text-sm font-medium',
                  ]"
                  >{{ item.name }}
                </router-link>
                </div>
              </div>
            </div>
            <div class="hidden md:block">
              <div class="ml-4 flex items-center md:ml-6">

                <!-- Profile dropdown -->
                <Menu as="div" class="relative ml-3">
                  <div v-if="isLogued">
                    <MenuButton class="flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                      <span class="sr-only">Open user menu</span>
                      <n-avatar
                        round
                        :style="{
                          color: 'yellow',
                          backgroundColor: 'red'
                        }">
                        {{ firstLetter }}
                      </n-avatar>  
                    </MenuButton>
                  </div>
                  <div v-else class="grid gap-2 grid-cols-2">
                    <n-button type="primary" ghost @click="$router.push('/login')">
                      <a>
                        Log in
                      </a>
                    </n-button>
                    <n-button type="info" ghost  @click="$router.push('/register')">
                      <a>
                        Register
                      </a>
                    </n-button>
                  </div>
                  <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                    <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                      <MenuItem>
                        <a 
                        @click="logout" 
                        :class="['block px-4 py-2 link text-sm text-gray-700']">
                          Log out</a>
                      </MenuItem>
                    </MenuItems>
                  </transition>
                </Menu>
              </div>
            </div>
            <div class="-mr-2 flex md:hidden">
              <!-- Mobile menu button -->
              <DisclosureButton class="inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                <span class="sr-only">Open main menu</span>
                <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
              </DisclosureButton>
            </div>
          </div>
        </div>
  
        <DisclosurePanel class="md:hidden">
          <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            <router-link
            v-for="item in navigation"
            :key="item.name"
            :to="item.to"
            active-class="bg-gray-900 text-white"
            :class="[
              this.$route.name === item.to.name
                ? ''
                : 'text-gray-300 hover:bg-gray-900 bg-transparent hover:text-white',
              'block px-3 py-2 rounded-md text-base font-medium',
            ]"
            >{{ item.name }}
          </router-link>
          </div>
          <div class="border-t border-gray-700 pb-3 pt-4">
            <div class="flex flex-row px-5" v-if="isLogued">
              <div class="w-1/2 flex flex-row">
                <div>
                  <n-avatar
                    round
                    :style="{
                      color: 'yellow',
                      backgroundColor: 'red'
                    }">
                    {{ firstLetter }}
                  </n-avatar>              
                </div>
                <div class="ml-3">
                  <div class="text-base font-medium leading-none text-white">{{ user.name }}</div>
                  <div class="text-sm font-medium leading-none text-gray-400">{{ user.email }}</div>
                </div>
              </div>
              <div class="w-1/2">
                <DisclosureButton 
                  @click="logout"
                  class="link block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">
                  Log out
                </DisclosureButton>
              </div>
            </div>
            <div v-else class="grid gap-2 grid-cols-2">
              <n-button type="primary" ghost @click="$router.push('/login')">
                <a>
                  Log in
                </a>
              </n-button>
              <n-button type="info" ghost  @click="$router.push('/register')">
                <a>
                  Register
                </a>
              </n-button>
            </div>
          </div>
        </DisclosurePanel>
      </Disclosure>
      <router-view></router-view>
    </div>
  </template>
  
  <script >
  import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
  import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'
  import { useStore } from 'vuex'
  import { computed } from 'vue'
  import { useRouter } from 'vue-router'
  import store from '../store'
  import { NAvatar, NButton } from 'naive-ui'
  import { ref } from 'vue'

  export default{
    components:{
        Bars3Icon, BellIcon, XMarkIcon,
        Disclosure, DisclosureButton, 
        DisclosureButton, DisclosurePanel, 
        Menu, MenuButton, MenuItem, 
        MenuItems, NAvatar, NButton
    },
    setup(){
        const firstLetter = ref('')
        const store = useStore()
        const navigation = [
          { name: "Community", to: { name: "Community" } },
          { name: "Profile", to: { name: "Profile" }, Auth: true},
        ];
        const router = useRouter()
        const user = ref({})
        const isLogued = ref(false)
        return{
            navigation, firstLetter, user,
            isLogued
        }
    },
    methods:{
      logout(){
        store.dispatch('logout')
        .then(()=>{
          this.$router.push({
            name: 'Dashboard'
          });
        });
        location.reload();
      },
      getFirstLetter(){
        
      }
    },
    created(){
        this.user = store.state.user.data
        if(this.user.name){
          this.firstLetter = this.user.name.charAt(0)
        }else{
          console.log(this.user.name);
        }
        
        if(this.user.name === undefined){
          this.isLogued = false;
        }else{
          this.isLogued = true;
        }
        
    },
    computed:{
      
    }
  }
  
  </script>