const state = {
	loading: false,
};

const getters = {
	getLoading: (state) => state.loading,
};

const mutations = {
	setLoading(state, payload) {
		state.loading = payload;
	},
};

const actions = {};

export default {
	namespaced: true,
	state,
	getters,
	mutations,
	actions,
};
