<template>
  <div>
    <form @submit.prevent="submitResetPw" method="post" action="">
      <div class="form-group">
        <label>Current Password</label>
        <input type="password" name="current_password" v-model="form.current_password" class="form-control"/>
      </div>
      <div class="form-group">
        <label>New Password</label>
        <input type="password" name="new_password" v-model="form.new_password" class="form-control"/>
      </div>
      <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" v-model="form.confirm_password" class="form-control"/>
      </div>
      <div class="form-group text-center">
        <button type="submit" class="btn btn-success btn-sm">Save</button>
      </div>
    </form>

  </div>
</template>

<script>
  import axios from 'axios';
  export default {
    props: {
    },
    name: 'ResetPasswordForm',
    data(){
      return{
        form:{
          current_password: '',
          new_password: '',
          _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          confirm_password: ''
        }
      }
    },
    methods: {
      submitResetPw(){
        axios.post(process.env.MIX_BASE_URL+'/store-new-pw', this.form).then((res) => {
          if (res.data.status == 'error') {
            alert(res.data.message);
          } else {
            window.location = process.env.MIX_BASE_URL + '/home'
          }
        }).catch((error) => {
          if (error.response.status === 422) {
            alert(error.response.data.errors.new_password);
          } else {
            alert(error.response.message);
          }
      });
      }
    },
    mounted() {
    }
  }
</script>

<style>
</style>