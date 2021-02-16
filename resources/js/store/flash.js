const state = {
	flash: false,
	message: "",
	type: 0,
	seconds: 3000,
};

const getters = {
	getShowFlash: (state) => state.flash,
	getFlashMessage: (state) => state.message,
	getFlashType: (state) => state.type,
	getFlashSeconds: (state) => state.seconds,
};

const mutations = {
	setShowFlash(state, payload) {
		state.flash = payload;
	},
	setFlashMessage(state, payload) {
		state.message = payload;
	},
	setFlashType(state, payload) {
		state.type = payload;
	},
	setFlashSeconds(state, payload) {
		state.seconds = payload;
	},
};

const actions = {
	async showFlashMessage(context, { show, message, type, seconds }) {
		context.commit("setShowFlash", show);
		context.commit("setFlashMessage", message);
		context.commit("setFlashType", type);
		context.commit("setFlashSeconds", seconds);
	},
};

export default {
	namespaced: true,
	state,
	getters,
	mutations,
	actions,
};
