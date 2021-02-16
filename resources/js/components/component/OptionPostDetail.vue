<template>
	<v-menu offset-y>
		<template v-slot:activator="{ on, attrs }">
			<v-btn large icon v-bind="attrs" v-on="on" text>
				<v-icon>mdi-dots-vertical</v-icon>
			</v-btn>
		</template>
		<v-list class="p-0">
			<v-list-item align="center" @click="twitterShare">
				<v-list-item-content>
					<v-list-item-title>
						<v-icon>mdi-twitter</v-icon>
						シェアする
					</v-list-item-title>
				</v-list-item-content>
			</v-list-item>
			<v-list-item v-if="userIdCheck" @click="deleteItem">
				<v-list-item-content>
					<v-list-item-title>削除</v-list-item-title>
				</v-list-item-content>
			</v-list-item>
		</v-list>
	</v-menu>
</template>

<script>
import { OK } from "../../util";
export default {
	data() {
		return {
			prevRoute: [],
		};
	},
	props: {
		postId: Number,
		userIdCheck: Boolean,
		pathName: String,
	},
	methods: {
		twitterShare() {
			var txt = "お笑いSNS";
			var hash = "相方募集,お笑い";
			var url = encodeURIComponent(location.href);
			var shareURL =
				"https://twitter.com/intent/tweet?text=" +
				txt +
				"&hashtags=" +
				hash +
				"&url=" +
				url;
			location.href = shareURL;
		},
		async deleteItem() {
			this.prevRoute = this.prevRouteChild;
			const response = await axios.delete(`/api/post/${this.postId}`);
			if (response.status === OK) {
				this.$store.dispatch("flash/showFlashMessage", {
					show: true,
					message: "投稿削除しました。",
					type: 1,
					seconds: 3000,
				});
				if (this.prevRoute.query !== undefined) {
					this.$router.push({
						name: this.pathName,
						query: this.prevRoute.query,
					});
				} else {
					this.$router.push({
						name: this.pathName,
					});
				}
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
	},
	computed: {
		// 前のページの情報取得
		prevRouteChild() {
			return this.$store.getters["route/getPrevRoute"];
		},
	},
};
</script>
