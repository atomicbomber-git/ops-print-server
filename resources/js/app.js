import "../scss/app.scss"
import Vue from 'vue/dist/vue.esm'

Vue.component("home", require("./components/Home.vue").default)

window.app = new Vue({
    el: '#app',
});