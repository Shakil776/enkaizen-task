<template>
  <div>
    <div class="container">
      <div class="py-5">
        <div class="row">
          <div class="col-6 offset-3">
            <div class="card card-default">
              <div class="card-header">Register</div>
              <div class="card-body">
                <form action="" method="post" @submit.prevent="register()">
                  <div class="form-group">
                    <label for="">Name</label>
                    <input
                      type="text"
                      v-model="name"
                      class="form-control"
                      placeholder="Name"
                    />
                  </div>
                  <div class="form-group">
                    <label for="">Email</label>
                    <input
                      type="text"
                      v-model="email"
                      class="form-control"
                      placeholder="Email"
                    />
                  </div>
                  <div class="form-group">
                    <label for="">Mobile</label>
                    <input
                      type="number"
                      v-model="mobile"
                      class="form-control"
                      placeholder="Mobile"
                    />
                  </div>
                  <div class="form-group">
                    <label for="">Password</label>
                    <input
                      type="password"
                      v-model="password"
                      class="form-control"
                      placeholder="Password"
                    />
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-success px-4">
                      Register
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
      name: "",
      email: "",
      mobile: "",
      password: "",
    };
  },
  methods: {
    register() {
      if (this.name == "") {
        this.$toast.error({
          title: "Error!",
          message: "Name field is required.",
        });
        return false;
      }
      if (this.email == "") {
        this.$toast.error({
          title: "Error!",
          message: "Email field is required.",
        });
        return false;
      }
      if (this.mobile == "") {
        this.$toast.error({
          title: "Error!",
          message: "Mobile field is required.",
        });
        return false;
      }
      if (this.password == "") {
        this.$toast.error({
          title: "Error!",
          message: "Password field is required.",
        });
        return false;
      }

      axios
        .post("/api/auth/register", {
          name: this.name,
          email: this.email,
          mobile: this.mobile,
          password: this.password,
        })
        .then((response) => {
          if (response.data.success == true) {
            this.$toast.success({
              title: "Success!",
              message: "Registration complete successfully! Please login.",
            });
            this.$router.push({ name: "login" });
          }
        })
        .catch((error) => {
          console.log("Error");
        });
    },
  },
  mounted() {},
};
</script>