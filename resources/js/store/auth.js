import { OK, CREATED, UNPROCESSABLE_ENTITY } from "../util";

const state = {
	user: null,
	authErrorMessages: null,
	authStatus: null,
};

const getters = {
	check: (state) => !!state.user,
	username: (state) => (state.user ? state.user.name : ""),
	userId: (state) => (state.user ? state.user.id : ""),
	getAuthErrorMessages: (state) => state.authErrorMessages,
	getAuthStatus: (state) => state.authStatus,
};

const mutations = {
	setUser(state, user) {
		state.user = user;
	},
	setAuthErrorMessages(state, messages) {
		state.authErrorMessages = messages;
	},
	setAuthStatus(state, status) {
		state.authStatus = status;
	},
};

const actions = {
	async authRegister(context, { data }) {
		context.commit("setAuthErrorMessages", null);
		context.commit("setAuthStatus", null);
		const response = await axios.post("/api/register", data);
		if (response.status === CREATED) {
			context.commit("setAuthStatus", true);
			return false;
		}
		context.commit("setAuthStatus", false);
		if (response.status === UNPROCESSABLE_ENTITY) {
			context.commit("setAuthErrorMessages", response.data.errors);
		} else {
			context.commit("error/setCode", response.status, { root: true });
		}
	},
	async authLogin(context, { data }) {
		context.commit("setAuthErrorMessages", null);
		context.commit("setAuthStatus", null);
		const response = await axios.post("/api/login", data);
		if (response.status === OK) {
			context.commit("setAuthStatus", true);
			context.commit("setUser", response.data);
			return false;
		}
		context.commit("setAuthStatus", false);
		if (response.status === UNPROCESSABLE_ENTITY) {
			context.commit("setAuthErrorMessages", response.data.errors);
		} else {
			context.commit("error/setCode", response.status, { root: true });
		}
	},
	async logout(context) {
		context.commit("setAuthStatus", null);
		const response = await axios.post("/api/logout");
		if (response.status === OK) {
			context.commit("setAuthStatus", true);
			context.commit("setUser", null);
			return false;
		}
		context.commit("setAuthStatus", false);
		context.commit("error/setCode", response.status, { root: true });
	},
	async currentUser(context) {
		context.commit("setAuthStatus", null);
		const response = await axios.get("/api/user");
		const user = response.data || null;
		if (response.status === OK) {
			context.commit("setAuthStatus", true);
			context.commit("setUser", user);
			return false;
		}
		context.commit("setAuthStatus", false);
		context.commit("error/setCode", response.status, { root: true });
	},
};

export default {
	namespaced: true,
	state,
	getters,
	mutations,
	actions,
};
