<template>
  <div class="text-white">
    <Loader v-if="isLoading" />

    <div
      class="my-2 shadow text-white bg-dark p-1"
      id=""
      v-for="request in receivedRequests"
      :key="request.id"
    >
      <div class="d-flex justify-content-between">
        <table class="ms-1">
          <td class="align-middle">{{ request.sender.name }}</td>
          <td class="align-middle">-</td>
          <td class="align-middle">{{ request.sender.email }}</td>
          <td class="align-middle"></td>
        </table>

        <div>
          <button
            @click="connectRequest(request.sender_id)"
            class="btn btn-primary me-1"
          >
            Accpet
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
      receivedRequests: [],
      page: 1,
      showLoadMoreButton: false,
      isLoading: false, // new loading state
    };
  },
  mounted() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      this.fetchreceivedRequests();
    },
    fetchreceivedRequests(replace = false) {
      this.isLoading = true;

      axios
        .get(`/api/received-requests`, {
          params: {
            page: this.page, // Pass the current page to the API
          },
        })
        .then((response) => {
          if (replace) {
            this.receivedRequests = response.data.data;
          } else {
            this.receivedRequests = this.receivedRequests.concat(
              response.data.data
            );
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
    connectRequest(requestId) {
      axios
        .post(`/api/accept-request/${requestId}`)
        .then((response) => {
          this.page = 1;
          this.fetchreceivedRequests(true); // Refresh the list after withdrawing the request
          this.UserCount();
        })
        .catch((error) => {
          console.error(error);
        });
    },
    loadMore() {
      this.fetchreceivedRequests();
    },
  },
};
</script>
  