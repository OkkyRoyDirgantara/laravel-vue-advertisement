<template>
  <div class="dashboard" style="margin-top: 80px">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              MAIN MENU
              <hr>
              <ul class="list-group">
                <router-link :to="{ name: 'dashboard-home' }" class="list-group-item text-dark text-decoration-none">DASHBOARD</router-link>
                <router-link :to="{ name: 'create-ads' }" class="list-group-item text-dark text-decoration-none">Create Ads</router-link>
                <li @click="logout" class="list-group-item text-dark text-decoration-none" style="cursor:pointer">LOGOUT</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <router-view>
            
          </router-view>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import CreateAdsView from './CreateAdsView.vue';

export default {
  name: 'DashboardView',
  components: {
    CreateAdsView,
  },
  data() {
    return {
      // state loggedIn with localStorage
      loggedIn: localStorage.getItem('loggedIn'),
      // state token
      token: localStorage.getItem('token'),
      // state user logged In
      user: {},
    };
  },
  created() {
    axios.get(`http://localhost:8000/api/user`, { headers: { 'Authorization': 'Bearer ' + this.token } })
      .then(response => {
        this.user = response.data; // assign response to state user
      })
      .catch(error => {
        console.error('Error fetching user data:', error);
      });
  },
  methods: {
    logout() {
      axios.get(`http://localhost:8000/api/logout`, { headers: { 'Authorization': 'Bearer ' + this.token } })
        .then(() => {
          // remove localStorage
          localStorage.removeItem('loggedIn');

          // redirect
          this.$router.push({ name: 'login' });
        })
        .catch(error => {
          console.error('Error during logout:', error);
        });
    },
  },
  // check if the user is logged in or not
  mounted() {
    if (!this.loggedIn) {
      this.$router.push({ name: 'login' });
    }
  },
};
</script>
