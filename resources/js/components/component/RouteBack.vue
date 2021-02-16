<template>
	<v-btn text color="cyan" @click="routeBack" class="pl-1">
		<v-icon>mdi-chevron-left</v-icon>
		<span>戻る</span>
	</v-btn>
</template>

<script>
export default {
	data: function () {
		return {
			path: "",
		};
	},
	props: {
		pathName: { type: String, default: "/" },
	},
	methods: {
		routeBack() {
			this.path = this.pathName;
			if (this.path === "/") {
				if (this.prevRoute.name !== undefined) {
					this.path = this.prevRoute.name;
				}
			}
			if (this.prevRoute.query !== undefined) {
				this.$router.push({
					name: this.path,
					query: this.prevRoute.query,
				});
			} else {
				this.$router.push({
					name: this.path,
				});
			}
		},
	},
	computed: {
		// 前のページの情報取得
		prevRoute() {
			return this.$store.getters["route/getPrevRoute"];
		},
	},
};
</script>

<style></style>
