<template>
	<v-app :style="{ background: $vuetify.theme.themes.light.background }">
		<Header />
		<v-main style="margin-top: 64px !important">
			<FlashMessage />
			<DefaultLoading />
			<v-container class="mt-2">
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
.container {
	max-width: 100%;
}
</style>
