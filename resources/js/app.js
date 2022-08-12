require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('applicants', require('./components/Applicants.vue').default);
export const EventBus = new Vue();
// mix.postCss('resources/css/style.css', 'public/css');

Vue.mixin({
    methods: {
        getYearForm: function(year){
            return year > 1 ? 'years' : 'year';
        },
        getMonthForm: function(month){
            return month > 1 ? 'months' : 'month';
        },
        capitalizeFirstLetter: function(string){
            return string.charAt(0).toUpperCase() + string.slice(1);
        },
        showBusySign: function(){
            $('#ajaxLoader').css('display', 'block');
        },
        hideBusySign: function(){
            $('#ajaxLoader').css('display', 'none');
        }
    }
})
const app = new Vue({
    el: '#app',
});
