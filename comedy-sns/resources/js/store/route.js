const state = {
	prevRoute: [],
};

const mutations = {
	setPrevRoute(state, from) {
		state.prevRoute = from;
	},
};

const actions = {};

const getters = {
	getPrevRoute: (state) => state.prevRoute,
};

export default {
	namespaced: true,
	state,
	mutations,
	getters,
};
