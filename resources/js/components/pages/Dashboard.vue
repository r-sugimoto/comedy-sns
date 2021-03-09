<template>
	<v-row>
		<v-col cols="12">
			<v-container class="p-0">
				<p class="title font-weight-bold mt-2 mb-2">相方募集投稿</p>
				<v-row>
					<v-col
						cols="12"
						sm="6"
						md="6"
						lg="6"
						xl="6"
						v-for="(recruit, i) in recruits"
						:key="`recruit-${i}`"
					>
						<PostCard :post="recruit"></PostCard>
					</v-col>
				</v-row>
				<div class="text-right">
					<router-link to="/recruit" class="font-weight-bold cyan--text">
						もっと見る
					</router-link>
				</div>
			</v-container>
			<v-container class="p-0">
				<p class="title font-weight-bold mt-2 mb-2">タイムライン</p>
				<v-row>
					<v-col
						cols="12"
						sm="6"
						md="6"
						lg="6"
						xl="6"
						v-for="(post, i) in posts"
						:key="`post-${i}`"
					>
						<PostCard :post="post"></PostCard>
					</v-col>
				</v-row>
				<div class="text-right">
					<router-link to="/post" class="font-weight-bold cyan--text">
						もっと見る
					</router-link>
				</div>
			</v-container>
			<v-container class="p-0">
				<p class="title font-weight-bold mt-2 mb-2">最近結成されたコンビ</p>
				<v-row>
					<v-col
						cols="12"
						sm="6"
						md="6"
						lg="6"
						xl="6"
						v-for="(comedy, i) in comedies"
						:key="`comedy-${i}`"
					>
						<ComedyCard :comedy="comedy"></ComedyCard>
					</v-col>
				</v-row>
			</v-container>
		</v-col>
	</v-row>
</template>

<script>
import PostCard from "../component/PostCard.vue";
import ComedyCard from "../component/ComedyCard.vue";
import { OK } from "../../util";
export default {
	data() {
		return {
			posts: [],
			recruits: [],
			comedies: [],
		};
	},
	components: {
		PostCard,
		ComedyCard,
	},
	methods: {
		async getPosts() {
			const response = await axios.get("/api/top/post");
			if (response.status === OK) {
				this.posts = response.data;
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
		async getRecruits() {
			const response = await axios.get("/api/top/recruit");
			if (response.status === OK) {
				this.recruits = response.data;
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
		async getComedies() {
			const response = await axios.get("/api/top/comedy");
			if (response.status === OK) {
				this.comedies = response.data;
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
	},
	computed: {
		isUserInfo() {
			return this.$store.getters["auth/userInfo"];
		},
	},
	async created() {
		await this.getPosts();
		await this.getRecruits();
		await this.getComedies();

		// 登録用フラッシュメッセージ
		const message = this.$cookies.get("MESSAGE");
		if (message) {
			this.$store.dispatch("flash/showFlashMessage", {
				show: true,
				message: message,
				type: 0,
				seconds: 3000,
			});
			// cookieをクリア
			this.$cookies.remove("MESSAGE");
		}
	},
};
</script>

<style></style>
