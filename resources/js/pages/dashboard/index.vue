<template>
  <div class="container mt-5">
    <h2>Image Gallery</h2>

    <div class="row">


      <div class="col-md-4">
        <div class="thumbnail">
          <img src="/w3images/lights.jpg" alt="Lights" style="width: 100%" />
        </div>
      </div>
      
      
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            userInfo : {},
            allImages : [],
        }
    },
    methods: {
        getUser() {
            axios.get('/api/auth/user').then(response => {
                this.userInfo = response.data.user;
            }).catch(error => {
                console.log('Error');
            });
        },
        getImages() {
            axios.post('/api/image/images', {
                user_id: this.userInfo.id
            }).then(response => {
                console.log(response);
            }).catch(error => {
                console.log('Error');
            });
        }
    },
    created() {
        this.getUser();
    },
    mounted() {
        this.getImages();
    },
};
</script>

<style>
</style>
