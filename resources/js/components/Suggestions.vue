
<template>
  <div class="text-white">
    <Loader v-if="isLoading" />
    <div
      class="my-2 shadow text-white bg-dark p-1"
      id=""
      v-for="(user, index) in users"
      :key="index"
    >
      <div class="d-flex justify-content-between">
        <table class="ms-1">
          <td class="align-middle">{{ user.name }}</td>
          <td class="align-middle">-</td>
          <td class="align-middle">{{ user.email }}</td>
          <td class="align-middle"></td>
        </table>

        <div>
          <button @click="connect(user.id)" class="btn btn-primary me-1">
            Connect
          </button>
        </div>
      </div>
    </div>
    <div
      class="d-flex justify-content-center mt-2 py-3"
      id="load_more_btn_parent"
    >
      <button
        v-if="showLoadMoreButton"
        @click="loadMore"
        class="btn btn-primary"
        onclick=""
        id="load_more_btn"
      >
        Load more
      </button>
    </div>
  </div>
</template>
    
    <script>
import axios from "axios";
import Loader from "./Loader.vue";

export default {
  components: { Loader },

  props: ["UserCount"],
  data() {
    return {
      users: [],
      page: 1, // Track the current page
      showLoadMoreButton: false,
      isLoading: false, // new loading state
    };
  },
  created() {
    this.fetchSuggestions();
  },
  methods: {
    fetchSuggestions(replace = false) {
      this.isLoading = true;
      // Make a GET request to fetch user suggestions from the Laravel API
      axios
        .get("/api/suggestions", {
          params: {
            page: this.page, // Pass the current page to the API
          },
        })
        .then((response) => {
          if (replace) {
            this.users = response.data.data;
          } else {
            this.users = this.users.concat(response.data.data);
          }
          this.page = response.data.current_page + 1; // Increment the current page
          this.showLoadMoreButton =
            response.data.current_page < response.data.last_page; // Check if there are more pages
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          this.isLoading = false; // reset loading state when request is complete
        });
    },
    connect(userId) {
      // Make a POST request to connect with the selected user
      axios
        .post(`/api/connect/${userId}`)
        .then((response) => {
          // Refresh the suggestions after connecting
          this.page = 1;
          this.fetchSuggestions(true); // pass true to replace the users array with the new list
          this.UserCount();
        })
        .catch((error) => {
          console.error(error);
        });
    },
    loadMore() {
      this.fetchSuggestions(); // Fetch the next page
    },
  },
};
</script>
    