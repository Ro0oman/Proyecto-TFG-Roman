import { createRouter, createWebHistory } from "vue-router";
import store from '../store';
import Dashboard from '../views/Dashboard.vue'
import Community from '../views/Community.vue'
import Application from '../views/Application.vue'
import PcCreator from '../views/PcCreator.vue'
import componentPicker from '../views/componentPicker.vue'
import Computer from '../views/Computer.vue'
import PageNotFound from '../views/PageNotFound.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'
import Profile from '../views/Profile.vue'

const routes = [
    {
        path: '/',
        redirect: '/dashboard'
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard
    },
    {
        path: '/community',
        name: 'Community',
        component: Community
    },
    {
        path: '/login',
        name: 'Login',
        component : Login
    },
    {
        path: '/register',
        name: 'Register',
        component : Register
    },
    {
        path: '/application',
        name: 'Application',
        component: Application,
        meta:{
            requiresAuth: true
        }
    },
    {
        path: '/profile',
        name: 'Profile',
        component: Profile,
        meta:{
            requiresAuth: true
        }
    },
    {
        path: '/pccreator',
        name: 'PcCreator',
        component: PcCreator,
        meta:{
            requiresAuth: true
        }
    },
    {
        name:'NotFound',
        path:'/:pathMatch(.*)*',
        component: PageNotFound
    },
    {
        name:'Computer',
        path:'/computer/:id',
        component: Computer
    },
    {
        path: '/componentPicker',
        name: 'componentPicker',
        component: componentPicker,
        meta:{
            requiresAuth: true
        }
    }
];


const router = createRouter({
    history: createWebHistory(), routes
})

router.beforeEach((to, from, next)=>{
    if(to.meta.requiresAuth && (!store.state.user.token)){
        next({name: 'Login'})
    }else if(store.state.user.token && to.meta.isGuest){
        next({name: 'Dashboard'})
    }else{
        next()
    }
})

export default router;