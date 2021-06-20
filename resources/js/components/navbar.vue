<template>
  <nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
      <div class="relative flex items-center justify-between h-16">
        <div
          class="
            flex-1 flex
            items-center
            justify-center
            sm:items-stretch
            sm:justify-start
          "
        >
          <div class="hidden sm:block sm:ml-6">
            <div class="flex space-x-4">
              <router-link
                class="text-white px-3 py-2 text-sm font-medium"
                to="/"
                exact
                >Home</router-link
              >
              <router-link
                class="text-white px-3 py-2 text-sm font-medium"
                to="/create-todo"
                v-if="isLoggedIn === true"
                >Create ToDo</router-link
              >
            </div>
          </div>
        </div>
        <div
          class="
            absolute
            inset-y-0
            right-0
            flex
            items-center
            pr-2
            sm:static
            sm:inset-auto
            sm:ml-6
            sm:pr-0
          "
        >
          <div v-if="isLoggedIn === true">
            <label
              class="
                text-white
                px-3
                py-2
                text-sm
                font-medium
                focus:outline-none
              "
              >{{ user.name }}</label
            >
            <button
              class="
                text-white
                px-3
                py-2
                text-sm
                font-medium
                focus:outline-none
              "
              @click="logout"
            >
              Logout
            </button>
          </div>

          <router-link
            class="text-white px-3 py-2 text-sm font-medium"
            to="/login"
            v-if="isLoggedIn === false"
            >Login</router-link
          >
          <router-link
            class="text-white px-3 py-2 text-sm font-medium"
            to="/register"
            v-if="isLoggedIn === false"
            >Register</router-link
          >
        </div>
      </div>
    </div>
  </nav>
</template>
<script>
export default {
  data() {
    return {
      isLoggedIn: false,
      user: null,
    };
  },
  methods: {
    logout() {
      axios.get("/api/logout").then(() => {
        this.$router.push({ name: "list" });
      });
    },
  },
  mounted() {
    axios.get("/api/user").then((response) => {
      this.user = response.data;
      this.isLoggedIn = true;
    });
  },
};
</script>