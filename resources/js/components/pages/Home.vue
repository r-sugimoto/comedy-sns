<template>
	<v-row>
		<v-col cols="12">
			<v-card elevation="0" tile>
				<v-container>
					<v-row>
						<v-col cols="12" sm="8" md="9" lg="9" xl="9">
							<v-card-title
								class="cyan--text font-weight-bold pt-2 pb-2 pl-3 pr-3"
								>お笑いを身近に。お笑い特化型SNSで相方を見つけよう。</v-card-title
							>
							<v-card-text class="pt-0 pb-2 pl-3 pr-3"
								>お笑いに関する情報の共有や相方の募集、コンビの結成ができるサービスです。コンビの結成までこのサービス上で完結します。お笑い好きよ集まれ！
							</v-card-text>
							<div class="pt-2 pb-2 pl-3 pr-3">
								<v-btn
									color="cyan"
									elevation="0"
									large
									rounded
									outlined
									to="/register"
								>
									<span>いますぐはじめる</span>
								</v-btn>
							</div>
						</v-col>
						<v-col
							cols="12"
							sm="4"
							md="3"
							lg="3"
							xl="3"
							:class="{ 'pt-0': $vuetify.breakpoint.xs }"
						>
							<v-img src="/images/home_top.png"></v-img>
						</v-col>
					</v-row>
				</v-container>
			</v-card>
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
				<p class="title font-weight-bold mt-2 mb-2">結成したコンビ</p>
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
	async created() {
		await this.getPosts();
		await this.getRecruits();
		await this.getComedies();
	},
};
</script>

<style></style>
