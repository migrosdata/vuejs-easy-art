<template>
  <div id="app">
     <img
        class="mb-4"
        :src="require('./assets/logo.png')"
        alt=""
      
      />
   <span v-if="!this.logIn">
    <Login @logIn="login"/>
       </span>
         <span v-else>
    <Menu :userName="this.userName"/>
       </span>
  </div>
</template>

<script>

import Quiz from './Quiz'
import Login from './component/Login.vue'
import Menu from './component/Menu.vue'
export default {
  name: 'App',
  components: {
Login,Menu
  },
    data() {
    return {
      logIn:false,
      startQuiz:false,
    userName:"",
      }
    
    ;
  },
  methods:{
    login(name){
        this.userName=name;
        console.log(name)
        this.logIn=true
    }
}
}

</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  background-color: silver;
  height: 100%;
}
html{
   height: 100%;
     background-color: silver;
}
</style>
