import { createStore } from "vuex";
import axiosClient from "../axios";

const store = createStore({
    state:{
        user:{
            data:{},
            token:sessionStorage.getItem('TOKEN'),
        },
        computers:{
            
        }, 
        cpus:{

        },
        allComputers:{
            
        },
        computerId:{
            
        },
        game:{
            
        }
    },
    getters:{

    },
    actions:{
        register({commit}, user){
            return axiosClient.post('/register', user)
            .then(({data})=>{
                commit('setUser', data)
                sessionStorage.setItem('TOKEN', data.token); 
                sessionStorage.setItem('ID', data.user.id); 
                sessionStorage.setItem('NAME', data.user.name); 
                setTimeout(() => { 
                    location.reload();
                  }, 500);
                return data
            })
        },
        login({commit,state}, user){
            return axiosClient.post('/login', user)
            .then((response)=>{
                if(response.data.token === undefined){
                    return false;
                }else{
                    console.log("User response.data : "+response.data.user)
                    state.user.token = response.data.token; 
                    state.user.data = response.data.user;
                    sessionStorage.setItem('TOKEN', response.data.token); 
                    sessionStorage.setItem('ID', response.data.user.id); 
                    sessionStorage.setItem('NAME', response.data.user.name); 
                    setTimeout(() => { 
                        location.reload();
                      }, 500);
                    return response.data
                }
            })
        },
        async logout({commit}){
            
        }
    },
    mutations:{
        logout(state){
            state.user.data = {};
            state.user.token = null;
            sessionStorage.removeItem('TOKEN')
            sessionStorage.removeItem('ID'); 
            sessionStorage.removeItem('NAME'); 
            console.log(sessionStorage);
            return axiosClient.post('/logout')
            .then(({response})=>{
                store.commit('logout')
                return response
            })
        },
        setUser(state, userData){
            this.$router.go()
            if(userData.token === undefined){
                return false;
            }else{
                console.log("User data : "+userData)
                state.user.token = userData.token; 
                state.user.data = userData.user;
                sessionStorage.setItem('TOKEN', userData.token); 
                sessionStorage.setItem('ID'); 
                sessionStorage.setItem('NAME', response.data.user.name); 
            }
        },
        setComputers(state,computers){
            state.computers = computers
        },
        setCpus(state,cpus){
            state.cpus = cpus
        },
        setUser(state,user){
            state.user = user
        },
        setAllComputers(state,allComputers){
            state.allComputers = allComputers
        },
        setComputerId(state,computer){
            state.computerId = computer
        },
        setGame(state,game){
            state.game = game
        }
    },
    modules:{

    },
})

export default store;