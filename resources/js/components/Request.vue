<template>
  <div class="text-white">
    <Loader v-if="isLoading" />

    <div
      class="my-2 shadow text-white bg-dark p-1"
      id=""
      v-for="request in sentRequests"
      :key="request.id"
    >
      <div class="d-flex justify-content-between">
        <table class="ms-1">
          <td class="align-middle">{{ request.receiver.name }}</td>
          <td class="align-middle">-</td>
          <td class="align-middle">{{ request.receiver.email }}</td>
          <td class="align-middle"></td>
        </table>

        <div>
          <button
            @click="withdrawRequest(request.id)"
            class="btn btn-danger me-1"
          >
            Withdraw Request
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
      sentRequests: [],
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
      this.fetchSentRequests();
    },
    fetchSentRequests(replace = false) {
      this.isLoading = true;

      axios
        .get(`/api/sent-requests`, {
          params: {
            page: this.page, // Pass the current page to the API
          },
        })
        .then((response) => {
          if (replace) {
            this.sentRequests = response.data.data;
          } else {
            this.sentRequests = this.sentRequests.concat(response.data.data);
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
    withdrawRequest(requestId) {
      axios
        .delete(`/api/withdraw-request/${requestId}`)
        .then((response) => {
          this.page = 1;
          this.fetchSentRequests(true); // Refresh the list after withdrawing the request
          this.UserCount();
        })
        .catch((error) => {
          console.error(error);
        });
    },
    loadMore() {
      this.fetchSentRequests();
    },
  },
  components: { Loader },
};
</script>
