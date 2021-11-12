<template>
  <div>
    <div class="row">
      <div class="col-lg-6"><h4>My Expenses</h4></div>
      <div class="col-lg-6 text-right"><h4>Dashboard</h4></div>
      <div class="col-lg-3 offset-lg-2">
        <table class="table">
          <thead>
            <tr>
              <th>Expense Categories</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="m in myreports" :key="m.category">
              <td>{{ m.category }}</td>
              <td>{{ m.total }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-lg-3">
        <pie-chart :data="chardata" :library="chartOptions"></pie-chart>
      </div>
      
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      myreports: {
        type: Array,
        default: []
      }
    },
    name: 'ExpenseChart',
    data(){
      return{
        datareports : this.myreports,
        chardata: [],
        chartOptions: {
          legend: {
            display: false
          },
        }
      }
    },
    methods: {
      
    },
    mounted() {
      var list=[];
      for (var i = 0; i < this.datareports.length; i++) {
          list.push([this.datareports[i].category, this.datareports[i].total])
      }
      this.chardata = list;
      console.log(this.chardata);
    }
  }
</script>

<style>
</style>