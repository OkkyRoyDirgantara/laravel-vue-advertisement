<template>
  <div class="container mt-5">
    <h2 class="mb-4">Create Advertisement</h2>
    <form @submit.prevent="createAdvertisement">
      <div class="mb-3">
        <label for="title" class="form-label">Title:</label>
        <input type="text" class="form-control" v-model="newAdvertisement.title" required>
      </div>
      
      <div class="mb-3">
        <label for="description" class="form-label">Description:</label>
        <textarea class="form-control" v-model="newAdvertisement.description" required></textarea>
      </div>
      
      <div class="mb-3">
        <label for="type" class="form-label">Type:</label>
        <input type="text" class="form-control" v-model="newAdvertisement.type" required>
      </div>
      
      <!-- Add additional inputs for other properties if needed -->
      
      <button type="submit" class="btn btn-primary">Create Advertisement</button>
    </form>
  </div>
</template>


<script>
import axios from 'axios';

export default {
  name: 'CreateAdsView',
  data() {
    return {
      loggedIn: localStorage.getItem('loggedIn'),
      token: localStorage.getItem('token'),
      newAdvertisement: {
        title: '',
        description: '',
        type: '',
        // Tambahkan properti lainnya sesuai kebutuhan
      },
    };
  },

  methods: {
    createAdvertisement() {

      // Membuat header dengan token Bearer
      const headers = {
        'Authorization': `Bearer ${this.token}`,
        'Content-Type': 'application/json',
      };

      axios.post('http://localhost:8000/api/advertisements', this.newAdvertisement, { headers })
        .then(response => {
          this.newAdvertisement = {
            title: '',
            description: '',
            type: '',
          };
          this.$router.push({ name: 'ads' });
        })
        .catch(error => {
          console.error('Error creating advertisement:', error);
        });
    }
  },

  mounted() {
    if(!this.loggedIn) {
            return this.$router.push({ name: 'login' })
        }
  }
};
</script>
