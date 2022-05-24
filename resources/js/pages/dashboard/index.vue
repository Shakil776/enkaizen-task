<template>
  <div class="container mt-5">
    <h2>Image Gallery</h2>

    <div class="row mb-4">
      <div class="col-12 d-flex justify-content-end">
        <button
          class="btn btn-success"
          @click="$router.push({ name: 'addimage' })"
        >
          Add Image
        </button>
      </div>
    </div>

    <div class="row mb-2" v-if="loading">
      <div class="col-12 d-flex justify-content-center">
        <div class="loader"></div>
      </div>
    </div>

    <div class="row mb-2" v-if="allImages.length != 0">
      <div class="col-md-4 mb-4" v-for="item in allImages" :key="item.id">
        <div class="thumbnail">
          <img
            :src="item.path"
            alt="Image"
            style="width: 100%; height: 300px"
          />
        </div>
      </div>
    </div>

    <div class="row mb-2 mt-4" v-else>
      <div class="col-md-12 mt-4 d-flex justify-content-center">
        <div class="thumbnail">
          <h4>No Image Found</h4>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      allImages: [],
      loading: false,
      user_id: JSON.parse(localStorage.getItem("user_id")),
    };
  },
  methods: {
    async getImage() {
      this.loading = true;
      await axios({
        method: "post",
        url: "/api/image/images",
        data: {
          user_id: this.user_id,
        },
        headers: { Authorization: "Bearer " + localStorage.getItem("token") },
      })
        .then((response) => {
          this.allImages = response.data.data;
          this.loading = false;
        })
        .catch((error) => {
          this.loading = false;
          console.log("Error");
        });
    },
  },
  mounted() {
    this.getImage();
  },
};
</script>

<style lang="scss" scoped>
.loader {
  border: 16px solid #f3f3f3;
  border-top: 16px solid #3498db;
  border-radius: 50%;
  width: 36px;
  height: 36px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
