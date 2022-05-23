<template>
  <div>
    <div class="container">
      <div class="py-5">
        <div class="row">
          <div class="col-6 offset-3">
            <div class="card card-default">
              <div class="card-header">Add Image</div>
              <div class="card-body">
                <form action="" method="post" @submit.prevent="addImage()">
                  <div class="form-group">
                    <label for="">Image URL</label>
                    <input
                      type="text"
                      v-model="url"
                      class="form-control"
                      placeholder="Enter Image URL"
                      @input="imagePreview"
                    />
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-success px-4">
                      Submit
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      url: "",
    };
  },
  methods: {
    async addImage() {
      await axios({
        method: "post",
        url: "/api/image/upload-image",
        data: {
          user_id: JSON.parse(localStorage.getItem("user_id")),
          path: this.url,
        },
        headers: { Authorization: "Bearer " + localStorage.getItem("token") },
      })
        .then((response) => {
          console.log(response);
        })
        .catch((error) => {
          console.log("Error");
        });
    },

    async imagePreview() {
      await axios
        .get(this.url)
        .then((response) => {
          console.log("Before");
          console.log(response);
          console.log("After");
        })
        .catch((error) => {
          console.log("Error");
        });
    },
  },
};
</script>