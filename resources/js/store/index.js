import Vue from "vue";
import Vuex from "vuex";

import error from "./error";
import auth from "./auth";
import loading from "./loading";
import route from "./route";
import flash from "./flash";

Vue.use(Vuex);

const store = new Vuex.Store({
	modules: {
		error,
		auth,
		loading,
		route,
		flash,
	},
});

export default store;
