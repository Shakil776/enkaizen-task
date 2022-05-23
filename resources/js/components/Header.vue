<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <router-link class="navbar-brand" :to="{ name: 'dashboard' }"
        >Image Uploader App</router-link
      >
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto" v-if="auth">
          <li class="nav-item">
            <router-link :to="{ name: 'dashboard' }" class="nav-link"
              >Home</router-link
            >
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" @click.prevent="logout">Logout</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto" v-else>
          <li class="nav-item">
            <router-link class="nav-link" :to="{ name: 'login' }"
              >Login</router-link
            >
          </li>
          <li class="nav-item">
            <router-link class="nav-link" :to="{ name: 'register' }"
              >Register</router-link
            >
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import store from "../store";
export default {
  methods: {
    logout() {
      this.loginError = false;
      axios
        .get("/api/auth/logout", {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        })
        .then((response) => {
          localStorage.removeItem("token");
          localStorage.removeItem("user_id");
          store.commit("logoutUser");
          this.$router.push({ name: "login" });
        })
        .catch((error) => {
          console.log("Error");
        });
    },
  },
  computed: {
    auth() {
      return this.$store.getters.getAuthenticated;
    },
  },
};
</script>