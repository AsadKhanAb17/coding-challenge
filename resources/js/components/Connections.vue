<!-- resources/js/components/Connections.vue -->

<template>
  <div class="text-white">
    <Loader v-if="isLoading" />

    <div
      class="my-2 shadow text-white bg-dark p-1"
      v-for="connection in connections"
      :key="connection.id"
    >
      <div class="d-flex justify-content-between">
        <table class="ms-1">
          <td class="align-middle">{{ connection.name }}</td>
          <td class="align-middle">-</td>
          <td class="align-middle">{{ connection.email }}</td>
          <td class="align-middle"></td>
        </table>

        <div>
          <button
            disabled
            v-if="connection.common_connection_count == 0"
            class="btn btn-primary me-1"
          >
            Connections in Common ({{ connection.common_connection_count }})
          </button>
          <button
            v-else
            class="btn btn-primary me-1"
            @click="showCommonConnections(connection.id)"
          >
            Connections in Common ({{ connection.common_connection_count }})
          </button>
          <button
            class="btn btn-danger me-1"
            @click="removeConnection(connection.id)"
          >
            Remove Connection
          </button>
        </div>
      </div>
    </div>
    <div v-if="showCommon">
      <ul class="list-unstyled">
        <li
          v-for="commonConnection in commonConnections"
          :key="commonConnection.id"
        >
          <div class="p-2 shadow rounded mt-2 ms-3 text-white bg-dark">
            {{ commonConnection.name }} - {{ commonConnection.email }}
          </div>
        </li>
      </ul>
      <div class="d-flex justify-content-center mt-2 py-3">
        <button
          v-if="showLoadMoreCommonConnectionsButton"
          @click="loadMoreCommonConnections"
          class="btn btn-primary"
        >
          Load more Common connection
        </button>
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
      connections: [],
      showCommon: false,
      selectedConnection: null,
      commonConnections: [],
      commonConnectionsPage: 1, // new field
      showLoadMoreCommonConnectionsButton: false, // new field
      page: 1,
      showLoadMoreButton: false,
      isLoading: false, // new loading state
    };
  },
  created() {
    this.fetchConnections();
  },
  methods: {
    fetchConnections(replace = false) {
      this.isLoading = true;
      axios
        .get("/api/connections", {
          params: {
            page: this.page, // Pass the current page to the API
          },
        })
        .then((response) => {
          if (replace) {
            this.connections = response.data.data;
          } else {
            this.connections = this.connections.concat(response.data.data);
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
    removeConnection(connectionId) {
      axios
        .delete(`/api/remove-connection/${connectionId}`)
        .then((response) => {
          this.page = 1;
          this.fetchConnections(true); // Refresh connections after removing a connection
          this.UserCount();
        })
        .catch((error) => {
          console.error(error);
        });
    },
    showCommonConnections(connectionId, replace = false) {
      this.showCommon = true;
      this.selectedConnection = this.connections.find(
        (connection) => connection.id === connectionId
      );
      axios
        .get(`/api/common-connections/${connectionId}`, {
          params: {
            page: this.commonConnectionsPage, // Pass the current page to the API
          },
        })
        .then((response) => {
          if (replace) {
            this.commonConnections = this.commonConnections.concat(
              response.data.data
            );
          } else {
            this.commonConnections = response.data.data;
            ``;
          }
          this.showLoadMoreCommonConnectionsButton =
            response.data.current_page < response.data.last_page; // Check if there are more pages
        })
        .catch((error) => {
          console.error(error);
        });
    },
    loadMoreCommonConnections() {
      // new method
      this.commonConnectionsPage += 1;

      this.showCommonConnections(this.selectedConnection.id, true);
    },
    loadMore() {
      this.showCommon = false;
      this.fetchConnections();
    },
  },
};
</script>
  