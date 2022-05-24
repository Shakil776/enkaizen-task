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
                      @change="imagePreview"
                    />
                  </div>

                  <div id="img_preview" class="image_style"></div>

                  <div class="form-group mt-2">
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
      user_id: JSON.parse(localStorage.getItem("user_id")),
    };
  },
  methods: {
    async addImage() {
      if (this.url == "") {
        this.$toast.error({
          title: "Error!",
          message: "URL field is required.",
        });
        return false;
      }
      await axios({
        method: "post",
        url: "/api/image/upload-image",
        data: {
          user_id: this.user_id,
          path: this.url,
        },
        headers: { Authorization: "Bearer " + localStorage.getItem("token") },
      })
        .then((response) => {
          Echo.private(`App.Models.User.${this.user_id}`).notification(
            (notification) => {
              // console.log("Notification message");
              // console.log(notification.message);
              this.$toast.success({
                title: "Success!",
                message: notification.message,
              });
            }
          );
          this.$router.push({ name: "dashboard" });
        })
        .catch((error) => {
          console.log("Error");
        });
    },

    imagePreview() {
      var img = new Image();
      img.src = this.url;
      img.width = 100;
      img_preview.appendChild(img);
    },
  },
};
</script>