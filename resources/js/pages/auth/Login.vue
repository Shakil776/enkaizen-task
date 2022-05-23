<template>
  <div>
    <div class="container">
      <div class="py-5">
        <div class="row">
          <div class="col-6 offset-3">
            <div class="card card-default">
              <div class="card-header">Login</div>
              <div class="card-body">
                <form action="" method="post" @submit.prevent="login()">
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
                    <label for="">Password</label>
                    <input
                      type="password"
                      v-model="password"
                      class="form-control"
                      placeholder="Password"
                    />
                  </div>
                  <div class="form-group">
                    <button
                      type="submit"
                      class="btn btn-success px-4"
                    >
                      Login
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
    import store from '../../store'
    export default {
        data() {
            return {
                email: '',
                password: '',
                loginError: false,
            }
        },
        methods: {
            login() {
                this.loginError = false;
                axios.post('/api/auth/login', {
                    email: this.email,
                    password: this.password
                }).then(response => {
                    store.commit('loginUser')
                    localStorage.setItem('token', response.data.access_token)
                    this.$router.push({ name: 'dashboard' })
                }).catch(error => {
                    this.loginError = true
                });
            }
        }
    }
</script>