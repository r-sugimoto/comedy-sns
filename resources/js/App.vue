<template>
	<v-app :style="{ background: $vuetify.theme.themes.light.background }">
		<Header></Header>
		<v-main class="main-top-margin">
			<FlashMessage />
			<DefaultLoading />
			<v-content>
				<v-container>
					<router-view />
				</v-container>
			</v-content>
		</v-main>
		<Footer />
	</v-app>
</template>

<script>
import Header from "./components/component/Header";
import Footer from "./components/component/Footer";
import DefaultLoading from "./components/elements/DefaultLoading.vue";
import FlashMessage from "./components/elements/FlashMessage.vue";
import { UNAUTHORIZED, NOT_FOUND, INTERNAL_SERVER_ERROR } from "./util";

export default {
	name: "app",
	components: {
		Header,
		DefaultLoading,
		FlashMessage,
		Footer,
	},
	computed: {
		errorCode() {
			return this.$store.getters["error/getCode"];
		},
	},
	created() {
		// cookiesにMESSAGEがある場合
		const message = Cookies.get("MESSAGE");
		if (message) {
			// cookieをクリア
			Cookies.remove("MESSAGE");
			console.log(message);
			// // MESSAGEストアでメッセージを表示
			// this.$store.commit("message/setContent", {
			// 	content: message,
			// 	timeout: 6000,
			// });
		}
	},
	watch: {
		errorCode: {
			async handler(val) {
				if (val === INTERNAL_SERVER_ERROR) {
					this.$router.push("/500");
				} else if (val === UNAUTHORIZED) {
					await axios.get("/api/refresh-token");
					this.$store.commit("auth/setUser", null);
					this.$router.push("/login");
				} else if (val === NOT_FOUND) {
					this.$router.push("/404");
				}
			},
			immediate: true,
		},
		$route(to, from) {
			this.$store.commit("route/setPrevRoute", from);
			this.$store.commit("error/setCode", null);
		},
	},
};
</script>

<style>
.main-top-margin {
	margin-top: 64px !important;
}
.container {
	max-width: 1200px !important;
}
</style>
