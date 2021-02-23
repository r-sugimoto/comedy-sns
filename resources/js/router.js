import Router from "vue-router";
import store from "./store";
import Home from "./components/pages/Home.vue";
import Setting from "./components/pages/Setting.vue";
import SystemError from "./components/pages/SystemError.vue";
import NotFound from "./components/pages/NotFound.vue";
import Profile from "./components/pages/Profile.vue";
import Login from "./components/pages/Login.vue";
import Register from "./components/pages/Register.vue";
import Post from "./components/pages/Post.vue";
import PostDetail from "./components/pages/PostDetail.vue";
import Recruit from "./components/pages/Recruit.vue";
import RecruitDetail from "./components/pages/RecruitDetail.vue";
import FollowList from "./components/pages/FollowList.vue";
import Chat from "./components/pages/Chat.vue";
import ChatDetail from "./components/pages/ChatDetail.vue";
import Search from "./components/pages/Search.vue";

export default new Router({
	mode: "history",
	routes: [
		{
			path: "/",
			name: "home",
			component: Home,
		},
		{
			path: "/setting",
			name: "setting",
			component: Setting,
			beforeEnter(to, from, next) {
				if (store.getters["auth/check"]) {
					next();
				} else {
					next("/");
				}
			},
		},
		{
			path: "/login",
			name: "login",
			component: Login,
			beforeEnter(to, from, next) {
				if (store.getters["auth/check"]) {
					next("/");
				} else {
					next();
				}
			},
		},
		{
			path: "/register",
			name: "register",
			component: Register,
			beforeEnter(to, from, next) {
				if (store.getters["auth/check"]) {
					next("/");
				} else {
					next();
				}
			},
		},
		{
			path: "/post",
			name: "post",
			component: Post,
		},
		{
			path: "/post/:id",
			name: "post-detail",
			component: PostDetail,
			props: true,
		},
		{
			path: "/recruit",
			name: "recruit",
			component: Recruit,
		},
		{
			path: "/recruit/:id",
			name: "recruit-detail",
			component: RecruitDetail,
			props: true,
		},
		{
			path: "/profile/:id",
			name: "profile",
			component: Profile,
			props: true,
		},
		{
			path: "/profile/:id/following",
			name: "following",
			component: FollowList,
			props: true,
		},
		{
			path: "/profile/:id/followers",
			name: "followers",
			component: FollowList,
			props: true,
		},
		{
			path: "/chat",
			name: "chat",
			component: Chat,
			beforeEnter(to, from, next) {
				if (store.getters["auth/check"]) {
					next();
				} else {
					next("/");
				}
			},
		},
		{
			path: "/chat/:id",
			name: "chat-detail",
			component: ChatDetail,
			props: true,
			beforeEnter(to, from, next) {
				if (store.getters["auth/check"]) {
					next();
				} else {
					next("/");
				}
			},
		},
		{
			path: "/search",
			name: "search",
			component: Search,
		},
		{
			path: "/500",
			name: "system-error",
			component: SystemError,
		},
		{
			path: "*",
			name: "not-found",
			component: NotFound,
		},
	],
});
