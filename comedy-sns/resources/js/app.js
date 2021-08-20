import "./bootstrap";

import Vue from "vue";
import VueRouter from "vue-router";
import store from "./store";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
import "@mdi/font/css/materialdesignicons.css";
import router from "./router";
import App from "./App.vue";
import VueTagsInput from "@johmun/vue-tags-input";
import InfiniteLoading from "vue-infinite-loading";
import VueCookies from "vue-cookies";

window.Vue = Vue;
Vue.use(VueRouter);
Vue.use(Vuetify);
Vue.use(VueTagsInput);
Vue.use(InfiniteLoading);
Vue.use(VueCookies);

// vee-validate
import {
	ValidationProvider,
	ValidationObserver,
	localize,
	extend,
} from "vee-validate";
import ja from "vee-validate/dist/locale/ja";
Vue.component("ValidationProvider", ValidationProvider);
Vue.component("ValidationObserver", ValidationObserver);
import * as rules from "vee-validate/dist/rules";
for (let rule in rules) {
	extend(rule, rules[rule]);
}
localize("ja", ja);

const createApp = async () => {
	await store.dispatch("auth/currentUser");
	new Vue({
		el: "#app",
		vuetify: new Vuetify(),
		router,
		store,
		components: { App },
		template: "<App />",
	});
};

createApp();
