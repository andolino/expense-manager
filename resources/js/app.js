require('./bootstrap');
import Vue from 'vue/dist/vue';
window.Vue = Vue; //require('vue');
import ExpenseChart from './components/ExpenseChart.vue';
import ResetPasswordForm from './components/ResetPasswordForm.vue';
import RolesModule from './components/RolesModule.vue';
import UserModule from './components/UserModule.vue';
import ExpenseCategory from './components/ExpenseCategory.vue';
import ExpensesModule from './components/ExpensesModule.vue';
import helpers from './helpers';
import Chartkick from 'vue-chartkick';
import Chart from 'chart.js';
import VueBootstrapToasts from "vue-bootstrap-toasts";
const plugin = {
  install () {
    Vue.helpers = helpers
    Vue.prototype.$helpers = helpers
  }
}
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.use(plugin)
Vue.use(Chartkick.use(Chart))
Vue.use(VueBootstrapToasts);
Vue.component('admin-panel', require('./components/AdminPanel.vue').default );
Vue.filter('toCurrency', function (value) {
	if (typeof value !== "number") {
			return value;
	}
	var formatter = new Intl.NumberFormat('en-US', {
			style: 'currency',
			currency: 'PHP',
			minimumFractionDigits: 0
	});
	return formatter.format(value);
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
	el: '#app',
	components: {
		'expense-chart'				: ExpenseChart,
		'reset-password-form'	: ResetPasswordForm,
		'roles-module'	      : RolesModule,
		'user-module'	        : UserModule,
		'expense-category'	  : ExpenseCategory,
		'expenses'	          : ExpensesModule,
	}
});