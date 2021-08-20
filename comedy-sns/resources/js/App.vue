<template>
	<v-app style="background: #f4f8fa">
		<Header />
		<v-main class="main-top-margin">
			<FlashMessage />
			<DefaultLoading />
			<v-container>
				<router-view />
			</v-container>
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
		},
		$route(to, from) {
			this.$store.commit("route/setPrevRoute", from);
			this.$store.commit("error/setCode", null);
		},
	},
	created() {
		// 登録用フラッシュメッセージ
		const msg = this.$cookies.get("MESSAGE");
		if (msg) {
			this.$store.dispatch("flash/showFlashMessage", {
				show: true,
				message: msg.message,
				type: msg.flg,
			});
			// cookieをクリア
			this.$cookies.remove("MESSAGE");

			setTimeout(() => {
				this.$store.commit("flash/setShowFlash", false);
			}, 5000);
		}
	},
};
</script>

<style>
.app-bc {
	background: "#f4f8fa";
}
.main-top-margin {
	margin-top: 64px !important;
}
.container {
	max-width: 1200px !important;
}
</style>
