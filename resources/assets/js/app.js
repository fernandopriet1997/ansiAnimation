
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('vue-text-selection');
require('html-to-image');
require('vue-ckeditor2');

window.Vue = require('vue');



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import selection from 'vue-text-selection';
import VModal from 'vue-js-modal';
import htmlToImage from 'html-to-image';
import VueCkeditor from 'vue-ckeditor2';



Vue.directive('selection', selection);
Vue.component('vue-ckeditor',VueCkeditor);

Vue.use(VModal, { dialog: true });


Vue.component('index', require('./components/Index.vue'));
const app = new Vue({
    el: '#app',
    directives: { 
        selection: selection.default
    },
    
});
