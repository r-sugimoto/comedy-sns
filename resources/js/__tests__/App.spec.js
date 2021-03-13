import { shallowMount, createLocalVue } from "@vue/test-utils";
import Vue from "vue";
import Vuetify from "vuetify";
import VueRouter from "vue-router";
import Vuex from "vuex";
import error from "../store/error";

Vue.use(Vuetify);
Vue.use(VueRouter);
Vue.use(Vuex);

import App from "../App.vue";

describe("App.vueのテスト", () => {
	const localVue = createLocalVue();
	let vuetify;
	let store;
	// テスト後初期化
	beforeEach(() => {
		store = new Vuex.Store(error);
		vuetify = new Vuetify();
	});

	it("watchの検証", () => {
		const wrapper = shallowMount(App, { store, localVue });
	});
});
