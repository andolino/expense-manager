
<template>
  <div>
    <h3>Expenses</h3>
    <h6 class="text-right w-75 mb-5">Expense Management > Expenses</h6>
    <table class="table table-hover font-12 w-75">
      <thead>
        <tr>
          <th>Expense Category</th>
          <th>Amount</th>
          <th>Entry Date</th>
          <th>Created At</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="de in dataexpenses" :key="de.id" @click="editRole(de.id, de.expense_category_id, de.amount, de.entry_date)">
          <td>{{ de.category }}</td>
          <td>{{ de.amount }}</td>
          <td>{{ de.entry_date }}</td>
          <td>{{ moment(de.created_at).format('YYYY-MM-DD') }}</td>
        </tr>
      </tbody>
    </table>
    <div class="row">
      <div class="col-lg-3 offset-lg-8">
        <button type="button" class="btn btn-primary" @click="addRole">Add Expenses</button>
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
                      <label class="col-lg-4" for="">Expense Category</label>
                      <select name="" class="col-lg-8 form-control form-control-sm" v-model="form.expense_category_id" id="" required>
                        <option value="" selected></option>
                        <option :value="r.id" v-for="r in datacategory" :key="r.id">{{ r.category }}</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-lg-4" for="">Amount</label>
                      <input type="text" class="col-lg-8 form-control form-control-sm" v-model="form.amount" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label class="col-lg-4" for="">Entry Date</label>
                      <input type="date" class="col-lg-8 form-control form-control-sm" v-model="form.entry_date" required>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger float-left mr-auto" @click="deleteData('expenses', form.id)">Delete</button>
                  <button type="button" class="btn btn-secondary" @click="showModal = false">Close</button>
                  <button type="button" class="btn btn-primary" @click="saveExpenses">Save changes</button>
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
      dataexpenses: {
        type: Array,
        default: [],
      },
      datacategory: {
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
          expense_category_id: '',
          entry_date: '',
          amount: '',
          _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        action: 'Add Expenses'
      }
    },
    methods: {
      addRole(){
        this.form.id = '';
        this.form.expense_category_id = '';
        this.form.entry_date = '';
        this.form.amount = '';
        this.showModal = true;
        this.action = 'Add Expenses';
      },
      editRole(id, expense_category_id, amount, entry_date){
        this.form.id = id;
        this.form.expense_category_id = expense_category_id;
        this.form.entry_date = moment(entry_date).format('YYYY-MM-DD');
        this.form.amount = amount;
        this.showModal = true;
        this.action = 'Edit Expenses';
      },
      saveExpenses(){
        axios.post(process.env.MIX_BASE_URL+'/save-expenses', this.form).then((res) => {
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
          // setTimeout(function(){window.location.reload()}, 2000)
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