
<template>
  <div class="flex min-h-full  items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
      <div>
        <img class="mx-auto h-12 w-auto" src="../assets/chapa.png" alt="Your Company" />
        <h2 class="mt-6 text-center text-3xl font-bold tracking-tight textYellow">Register for free</h2>
        <p class="text-center textYellow">Or 
          <router-link :to="{name:'Login'}" class="link ">
            log in
          </router-link> 
        </p>
      </div>
      <n-alert title="Error login" type="error" v-if="error" closable
      :on-close="clearError"> 
        {{ error }}
      </n-alert>
      <form class="mt-8 space-y-6" @submit="register">
        <input type="hidden" name="remember" value="true" />
        <div class="-space-y-px rounded-md shadow-sm">
          <div>
            <label for="fullname" class="sr-only">Fullname</label>
            <input id="fullname" name="fullname" type="text"  autocomplete="name" required="" 
            class="relative block w-full rounded-t-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            placeholder="Fullname"
             v-model="user.name"
            />
          </div>
          <div>
            <label for="email-address" class="sr-only">Email address</label>
            <input id="email-address" name="email" type="email"
            class="relative block w-full border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            autocomplete="email" required=""  placeholder="Email address"
             v-model="user.email"
            />
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required="" class="relative block w-full border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Password"
             v-model="user.password"
            />
          </div>
          <div>
            <label for="password_confirmation" class="sr-only">Password Confirmation</label>
            <input id="password_confirmation"  
            class="relative block w-full rounded-b-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:z-10 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
            name="password_confirmation" type="password" autocomplete="current-password" required=""  placeholder="Password Confirmation" 
            v-model="user.password_confirmation"
            />
          </div>
        </div>

        <div>
          <button type="submit" class="group relative flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            </span>
            Create a new account
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
      name:'',
      email:'',
      password:'',
      password_confirmation:'',
    }
    const error = ref('')

    return{
      user,error
    }
  },
  methods: {
    /* Prevenimos que el submit nos redirija */
    register(ev){
      ev.preventDefault();
      store
      .dispatch('register', this.user)
      .then(()=>{
        this.$router.push({
          name:'Dashboard'
        })
      })
      .catch((error) =>{
        if(Object.keys(error).length){
          this.error = error.response.data.message;
        }else{
          this.error = error
        }
      })
    }
  }
}
</script>