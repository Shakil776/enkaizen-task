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

    <div class="row">
      <div class="col-md-4 mb-2" v-for="item in allImages" :key="item.id">
        <div class="thumbnail">
          <img
            :src="item.path"
            alt="Lights"
            style="width: 100%; height: 300px"
          />
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
    };
  },
  methods: {
    async getImage() {
      await axios({
        method: "post",
        url: "/api/image/images",
        data: {
          user_id: JSON.parse(localStorage.getItem("user_id")),
        },
        headers: { Authorization: "Bearer " + localStorage.getItem("token") },
      })
        .then((response) => {
          this.allImages = response.data.data;
        })
        .catch((error) => {
          console.log("Error");
        });
    },
  },
  mounted() {
    this.getImage();
  },
  computed: {},
};
</script>
