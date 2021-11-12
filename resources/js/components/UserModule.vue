
<template>
  <div>
    
    <h3>Users</h3>
    <h6 class="text-right w-75 mb-5">User Management > Users</h6>
    <table class="table table-hover font-12 w-75">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email Address</th>
          <th>Role</th>
          <th>Created At</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="ru in datausers" :key="ru.id" @click="editRole(ru.id, ru.email, ru.roles_id, ru.name)">
          <td>{{ ru.name }}</td>
          <td>{{ ru.email }}</td>
          <td>{{ ru.role }}</td>
          <td>{{ moment(ru.created_at).format('YYYY-MM-DD') }}</td>
        </tr>
      </tbody>
    </table>
    <div class="row">
      <div class="col-lg-3 offset-lg-8">
        <button type="button" class="btn btn-primary" @click="addRole">Add User</button>
      </div>
    </div>

    <!-- modal -->
    <div v-if="showModal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">{{ action }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" @click="showModal = false">&times;</span>
                  </button>
                </div>
                <div class="modal-body p-3">
                  <div class="form-group">
                    <div class="row">
                      <label class="col-lg-4" for="">Name</label>
                      <input type="text" class="col-lg-8 form-control form-control-sm" v-model="form.name">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-lg-4" for="">Email Address</label>
                      <input type="text" class="col-lg-8 form-control form-control-sm" v-model="form.email">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-lg-4" for="">Role</label>
                      <select name="" class="col-lg-8 form-control form-control-sm" v-model="form.roles_id" id="">
                        <option value="" selected></option>
                        <option :value="r.id" v-for="r in dataroles" :key="r.id">{{ r.role }}</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger float-left mr-auto" @click="deleteData('users', form.id)">Delete</button>
                  <button type="button" class="btn btn-secondary" @click="showModal = false">Close</button>
                  <button type="button" class="btn btn-primary" @click="saveRole">Save changes</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
    <!-- end modal -->

    <Toasts
      :show-progress="true"
      :rtl="false"
      :max-messages="5"
      :time-out="2000"
      :closeable="true"
    ></Toasts>

  </div>
</template>

<script>
  import axios from 'axios';
  import moment from 'moment';
  export default {
    props: {
      datausers: {
        type: Array,
        default: [],
      },
      dataroles: {
        type: Array,
        default: [],
      },
    },
    name: 'UserModule',
    data(){
      return{
        rolesData: '',
        moment: moment,
        showModal: false,
        form: {
          id: '',
          roles_id: '',
          name: '',
          email: '',
          _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        action: 'Add Users'
      }
    },
    methods: {
      addRole(){
        this.form.id = '';
        this.form.roles_id = '';
        this.form.name = '';
        this.form.email = '';
        this.showModal = true;
        this.action = 'Add User';
      },
      editRole(id, email, roles_id, name){
        this.form.id = id;
        this.form.roles_id = roles_id;
        this.form.email = email;
        this.form.name = name;
        this.showModal = true;
        this.action = 'Edit User';
      },
      saveRole(){
        axios.post(process.env.MIX_BASE_URL+'/save-users', this.form).then((res) => {
          this.$toast.success(res.data.message);
          this.showModal = false;
          setTimeout(function(){window.location.reload()}, 2000)
        }).catch((error) => {
          console.log(error)
        });
        this.$forceUpdate();
      },
      deleteData(d, id){
        axios.post(process.env.MIX_BASE_URL+'/delete-data', { 'type':d,'id':id }).then((res) => {
          this.$toast.success(res.data.message);
          this.showModal = false;
          setTimeout(function(){window.location.reload()}, 2000)
        }).catch((error) => {
          console.log(error)
        });
      }
    },
    mounted() {
    }
  }
</script>

<style>
.font-12{
  font-size:12px !important;
}
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}
.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}
</style>