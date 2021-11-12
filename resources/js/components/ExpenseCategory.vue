
<template>
  <div>
    <h3>Expense Category</h3>
    <h6 class="text-right w-75 mb-5">Expense Management > Expense Category</h6>
    <table class="table table-hover font-12 w-75">
      <thead>
        <tr>
          <th>Display Name</th>
          <th>Description</th>
          <th>Created At</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="de in dataec" :key="de.id" @click="editRole(de.id, de.category, de.description)">
          <td>{{ de.category }}</td>
          <td>{{ de.description }}</td>
          <td>{{ moment(de.created_at).format('YYYY-MM-DD') }}</td>
        </tr>
      </tbody>
    </table>
    <div class="row">
      <div class="col-lg-3 offset-lg-8">
        <button type="button" class="btn btn-primary" @click="addRole">Add Expense Category</button>
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
                      <input type="text" class="col-lg-8 form-control form-control-sm" v-model="form.category" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-lg-4" for="">Description</label>
                      <input type="text" class="col-lg-8 form-control form-control-sm" v-model="form.description" required>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger float-left mr-auto" @click="deleteData('expense_category', form.id)">Delete</button>
                  <button type="button" class="btn btn-secondary" @click="showModal = false">Close</button>
                  <button type="button" class="btn btn-primary" @click="saveCategoryExpense">Save changes</button>
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
      dataec: {
        type: Array,
        default: [],
      },
      myroles: {
        type: Array,
        default: [],
      }
    },
    name: 'UserModule',
    data(){
      return{
        rolesData: '',
        moment: moment,
        showModal: false,
        form: {
          id: '',
          category: '',
          description: '',
          _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        action: 'Add Expense Category'
      }
    },
    methods: {
      addRole(){
        this.form.id = '';
        this.form.category = '';
        this.form.description = '';

        this.showModal = true;
        this.action = 'Add Category';
      },
      editRole(id, category, description){
        this.form.id = id;
        this.form.category = category;
        this.form.description = description;
        this.showModal = true;
        this.action = 'Edit Expense Category';
      },
      saveCategoryExpense(){
        axios.post(process.env.MIX_BASE_URL+'/save-expense-category', this.form).then((res) => {
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