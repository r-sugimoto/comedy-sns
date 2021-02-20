<template>
	<v-btn
		v-if="UserId !== String(isLoginUserId)"
		@click="isFollow"
		:class="{ 'white--text cyan': follow, 'cyan--text': !follow }"
		large
		rounded
		outlined
		>フォロー <span v-if="follow">済</span></v-btn
	>
</template>

<script>
import { OK } from "../../../util";
export default {
	data: function () {
		return {
			follow: false,
		};
	},
	props: {
		UserId: String,
	},
	methods: {
		async isFollow() {
			if (!this.isLogin) {
				alert("フォロー機能を使うにはログインしてください。");
				return false;
			}
			if (this.follow) {
				const response = await axios.delete(
					`/api/profile/${this.UserId}/follow`
				);
				if (response.status === OK) {
					this.follow = false;
				} else {
					this.$store.commit("error/setCode", response.status);
				}
			} else {
				const response = await axios.put(`/api/profile/${this.UserId}/follow`);
				if (response.status === OK) {
					this.follow = true;
				} else {
					this.$store.commit("error/setCode", response.status);
				}
			}
		},
		async followCheck() {
			if (!this.isLogin) {
				return false;
			}
			const response = await axios.post(`/api/follow/check/${this.UserId}`);
			if (response.status === OK) {
				this.follow = Boolean(response.data);
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
	},
	computed: {
		isLogin() {
			return this.$store.getters["auth/check"];
		},
		isLoginUserId() {
			return this.$store.getters["auth/userId"];
		},
	},
	async created() {
		await this.followCheck();
	},
	watch: {
		async $route(to, from) {
			await this.followCheck();
		},
	},
};
</script>

<style></style>
