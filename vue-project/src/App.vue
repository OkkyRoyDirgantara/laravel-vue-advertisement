<template>
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <router-link :to="{ name: 'home' }" class="navbar-brand">Ads</router-link>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
        aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <router-link :to="{ name: 'home' }" class="nav-link">HOME</router-link>
          </li>
          <li v-if="loggedIn" class="nav-item">
            <router-link :to="{ name: 'ads' }" class="nav-link">Ads</router-link>
          </li>
        </ul>
        <div v-if="!loggedIn" class="form-inline my-2 my-lg-0 d-none d-md-block">
          <router-link :to="{ name: 'login' }" class="btn btn-primary my-2 my-sm-0">LOGIN</router-link>
        </div>
        <div v-if="!loggedIn" class="form-inline my-2 my-lg-0 d-none d-md-block mx-2">
          <router-link :to="{ name: 'register' }" class="btn btn-primary my-2 my-sm-0">REGISTER</router-link>
        </div>
        <div v-if="loggedIn" class="form-inline my-2 my-lg-0 d-none d-md-block">
          <router-link  :to="{ name: 'dashboard-home' }" class="btn btn-primary my-2 my-sm-0">DASHBOARD</router-link>
        </div>
        <div v-if="loggedIn" class="form-inline my-2 my-lg-0 d-none d-md-block mx-2">
          <p @click="logout" class="btn btn-danger my-2 my-sm-0" style="cursor:pointer">LOGOUT</p>
        </div>
      </div>
    </nav>
    <div class="py-5">
    <router-view>
    </router-view>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

const apiUrl = await import.meta.env.APP_URL;
  export default {
    name: 'App',

    data() {
      return {
        loggedIn: null
      }
    },

    methods: {
      getLoggedIn() {
        this.loggedIn = localStorage.getItem("loggedIn")
      },
      logout() {
            axios.get(`${apiUrl}/api/logout`, {headers: {'Authorization': 'Bearer '+this.token}})
            .then(() => {
                //remove localStorage
                localStorage.removeItem("loggedIn")    


                //redirect
                return this.$router.push({ name: 'login' })
            })
        }
    },

    watch: {
      $route: {
        immediate: true,
        handler() {
          this.getLoggedIn()
        }
      }
    },

  }
</script>