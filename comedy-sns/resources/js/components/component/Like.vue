<template>
	<v-btn
		align="center"
		:class="{ 'pink--text': liked }"
		large
		icon
		@click="isLike"
	>
		<v-icon class="mr-1"> mdi-heart </v-icon>
		<span>{{ count }}</span>
	</v-btn>
</template>

<script>
import { OK } from "../../util";
export default {
	data: function () {
		return {
			count: this.LikesCount,
			liked: this.LikedByUser,
		};
	},
	props: {
		LikesCount: Number,
		LikedByUser: Boolean,
		PostId: Number,
	},
	methods: {
		async isLike() {
			if (!this.$store.getters["auth/check"]) {
				alert("いいね機能を使うにはログインしてください。");
				return false;
			}

			if (this.liked) {
				const response = await axios.delete(`/api/post/${this.PostId}/like`);
				if (response.status === OK) {
					this.count -= 1;
					this.liked = false;
				} else {
					this.$store.commit("error/setCode", response.status);
				}
			} else {
				const response = await axios.put(`/api/post/${this.PostId}/like`);
				if (response.status === OK) {
					this.count += 1;
					this.liked = true;
				} else {
					this.$store.commit("error/setCode", response.status);
				}
			}
		},
	},
};
</script>

<style></style>
