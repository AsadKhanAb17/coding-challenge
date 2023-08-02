<template>
  <div>
    <div
      class="btn-group w-100 mb-3"
      role="group"
      aria-label="Basic radio toggle button group"
    >
      <label
        v-for="(tab, index) in tabs"
        :key="index"
        :class="`btn btn-outline-primary ${
          currentTab === tab.name ? 'active' : ''
        }`"
        @click="changeTab(tab.name)"
      >
        {{ tab.label }} ({{ tab.count }})
      </label>
    </div>

    <!-- Tab contents -->
    <div v-if="currentTab === 'suggestion'">
      <suggestions :UserCount="fetchUserCount" />
    </div>
    <div v-if="currentTab === 'sendrequest'">
      <request :UserCount="fetchUserCount" />
    </div>
    <div v-if="currentTab === 'receivedrequest'">
      <!-- Contents for Received Requests tab -->
      <received-request :UserCount="fetchUserCount" />
    </div>
    <div v-if="currentTab === 'connections'">
      <!-- Contents for Connections tab -->
      <connections :UserCount="fetchUserCount" />
    </div>
  </div>
</template>
<script>
import Connections from "./Connections.vue";
import ReceivedRequest from "./ReceivedRequest.vue";
import Request from "./Request.vue";
import Suggestions from "./Suggestions.vue";
export default {
  components: { Request, Suggestions, ReceivedRequest, Connections },
  data() {
    return {
      tabs: [
        { name: "suggestion", label: "Suggestions ", count: null },
        { name: "sendrequest", label: "Sent Requests " },
        { name: "receivedrequest", label: "Received Requests ", count: null },
        { name: "connections", label: "Connections", count: null },
      ],
      count: {},
      currentTab: "suggestion",
    };
  },
  mounted() {
    this.fetchUserCount();
  },
  methods: {
    changeTab(name) {
      this.currentTab = name;
    },
    fetchUserCount() {
      axios
        .get(`/api/countuser`)
        .then((response) => {
          this.tabs[0].count = response.data.suggestions;
          this.tabs[1].count = response.data.sentRequests;
          this.tabs[2].count = response.data.receivedRequests;
          this.tabs[3].count = response.data.connections;
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
