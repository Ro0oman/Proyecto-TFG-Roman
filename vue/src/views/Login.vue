<template>
  <div class="flex min-h-full items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
      <div>
        <img class="mx-auto h-12 w-auto" src="../assets/chapa.png" alt="Your Company" />
        <h2 class="mt-6 text-center text-3xl font-bold tracking-tight textYellow">Log in</h2>
        <p class="text-center textYellow">Or 
          <router-link :to="{name:'Register'}" class="link">
            register
          </router-link> 
        </p>
      </div>
      <n-alert title="Error login" type="error" v-if="error" closable
      :on-close="clearError"> 
        {{ error }}
      </n-alert>
      <form class="mt-8 space-y-6" @submit="login">
        <input type="hidden" name="remember" value="true" />
        <div class="-space-y-px rounded-md shadow-sm">
          <div>
            <label for="email-address" class="sr-only">Email address</label>
            <input 
             v-model="user.email"
            id="email-address" name="email" type="email" autocomplete="email" required="" class="relative block w-full rounded-t-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Email address" />
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <input 
              v-model="user.password"
            id="password" name="password" type="password" autocomplete="current-password" required="" class="relative block w-full rounded-b-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Password" />
          </div>
        </div>
        <div>
          <button type="submit" class="group relative flex w-full justify-center rounded-md bg-[#FF0000] px-3 py-2 text-sm font-semibold text-white hover:bg-yellow-300 hover:text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-600">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            </span>
            Log in
          </button>
        </div>
      </form>
    </div>
  </div>

  </template>
  
  <script>
  import store from './../store';
  import { ref } from 'vue';
  import {NAlert} from 'naive-ui'

  export default{
    components:{
      NAlert
    },
    setup(){
      const user = {
        email:'',
        password:'',
        remember: false
      }
      const error = ref('')
      return{
        user,error
      }
    },
    methods: {
      /* Prevenimos que el submit nos redirija */
      login(ev){
        ev.preventDefault();
        store
        .dispatch('login', this.user)
        .then(()=>{
          this.$router.push({
            name:'Application'
          })
        })
        .catch((error)=>{
          console.log(error);
          this.error = error.response.data.error
        })
      },
      clearError(){
        this.error = null
      }
    }
  }
  </script>

<style scoped>
span{
  color: yellow;
}
</style>
