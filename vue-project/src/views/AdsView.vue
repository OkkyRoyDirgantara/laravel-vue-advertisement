<template>
  <div class="mx-5 mt-3">
    <h2>Advertisements</h2>
    <input v-model="search" @input="updateSearch" placeholder="Search..." class="form-control my-3"/>
    <div v-if="loading">Loading...</div>
    <div v-else-if="advertisements.length === 0">No advertisements found.</div>
    <div v-else>
      <div v-for="ad in advertisements" :key="ad.id" class="advertisement-item">
        <h3>{{ ad.title }}</h3>
        <p>{{ ad.description }}</p>
        <p>Type: {{ ad.type }}</p>
        <p>Created At: {{ ad.created_at }}</p>
        <!-- Add other information you want to display -->
      </div>
    </div>
    <nav>
        <ul class="pagination">
            <li class="page-item" v-if="urlPage.prev_page_url">
            <router-link :to="{ name: 'ads', query: { page: urlPage.current_page - 1 } }" class="page-link">Previous</router-link>
            </li>
            <li class="page-item" v-for="page in urlPage.last_page" :key="page" :class="{ active: page === urlPage.current_page }">
            <router-link :to="{ name: 'ads', query: { page } }" class="page-link">{{ page }}</router-link>
            </li>
            <li class="page-item" v-if="urlPage.next_page_url">
            <router-link :to="{ name: 'ads', query: { page: urlPage.current_page + 1 } }" class="page-link">Next</router-link>
            </li>
        </ul>
    </nav>
  </div>
</template>

<script>
import axios from 'axios';


export default {
  name: 'AdsView',
  data() {
    return {
      advertisements: [],
      urlPage: [],
       loading: false,
      loggedIn: localStorage.getItem('loggedIn') === 'true',
      token: localStorage.getItem('token'),
      user: [],
      search: '',
    };
  },
  created() {
    this.$watch(
      () => [this.$route.query.page, this.$route.query.search],
      () => {
        this.fetchAds(`http://localhost:8000/api/advertisements?page=${this.$route.query.page??1}&search=${this.$route.query.search ?? ''}`)
      }
    )
  },
  methods: {
    async fetchAds(url) {
        try {
        this.loading = true;
            const response = await axios.get(url, {
        headers: { Authorization: 'Bearer ' + this.token },
        });
        this.loading = false;
        this.advertisements = response.data.data.data;
        this.urlPage = response.data.data;
        } catch (error) {
            this.loading = false;
            console.error('Error fetching advertisements:', error);
        }
    },
    updateSearch() {
      this.$router.push({
        name: 'ads',
        query: { search: this.search || null },
      });
    },
  },

  async mounted() {
    if(!this.loggedIn) {
            return this.$router.push({ name: 'login' })
    }
    this.fetchAds(`http://localhost:8000/api/advertisements?page=${this.$route.query.page??1}&search=${this.$route.query.search ?? ''}`)
  },
};
</script>

<style scoped>
.advertisement-item {
  margin-bottom: 20px;
  border: 1px solid #ddd;
  padding: 10px;
}
</style>
