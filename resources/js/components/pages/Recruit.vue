<template>
	<div>
		<v-fab-transition>
			<NewRecruit v-if="isLogin" @addPostReload="postReload"></NewRecruit>
		</v-fab-transition>
		<v-row>
			<v-col class="pb-0 pt-0" cols="12" lg="4" xl="4">
				<SearchRecruit></SearchRecruit>
			</v-col>
			<v-col class="pb-0 pt-0" lg="8" xl="8">
				<v-row v-if="isLogin" class="pt-1 pb-1">
					<v-spacer></v-spacer>
					<v-col cols="12" sm="6" md="6" lg="6" xl="6">
						<v-select
							v-model="searchType"
							:items="types"
							placeholder="絞り込む"
							background-color="#fff"
							hide-details
							outlined
							clearable
							@change="postReload"
						>
						</v-select>
					</v-col>
				</v-row>
				<PostCard
					v-for="post in posts"
					:key="`posts-${post.id}`"
					:post="post"
				></PostCard>
				<infinite-loading
					ref="infiniteLoading"
					spinner="spiral"
					@infinite="infiniteHandler"
				>
					<div slot="no-more">全件取得しました。</div>
					<div slot="no-results">投稿が見つかりませんでした。</div>
				</infinite-loading>
			</v-col>
		</v-row>
	</div>
</template>
<script>
import NewRecruit from "../component/recruit/NewRecruit.vue";
import SearchRecruit from "../component/recruit/SearchRecruit.vue";
import PostCard from "../component/PostCard.vue";
import { OK } from "../../util";
export default {
	data() {
		return {
			posts: [],
			freeword: "",
			tag: null,
			prefecture: null,
			region: null,
			generation: null,
			page: 1,
			searchType: null,
			types: [{ text: "フォロー済", value: 1 }],
		};
	},
	components: {
		PostCard,
		NewRecruit,
		SearchRecruit,
	},
	methods: {
		postReload() {
			this.page = 1;
			this.posts.splice(0, this.posts.length);
			this.$refs.infiniteLoading.stateChanger.reset();
		},
		async infiniteHandler($state) {
			if (this.$route.query.freeword !== undefined) {
				this.freeword = this.$route.query.freeword;
			} else {
				this.freeword = "";
			}
			if (this.$route.query.tag !== undefined) {
				let tag = this.$route.query.tag;
				this.tag = /^[1-9][0-9]*$/.test(tag) ? tag * 1 : null;
			} else {
				this.tag = null;
			}
			if (this.$route.query.prefecture !== undefined) {
				let pre = this.$route.query.prefecture;
				this.prefecture = /^[1-9][0-9]*$/.test(pre) ? pre * 1 : "";
			} else {
				this.prefecture = null;
			}
			if (this.$route.query.region !== undefined) {
				let region = this.$route.query.region;
				this.region = /^[1-9][0-9]*$/.test(region) ? region * 1 : "";
			} else {
				this.region = null;
			}
			if (this.$route.query.generation !== undefined) {
				let generation = this.$route.query.generation;
				this.generation = /^[1-9][0-9]*$/.test(generation)
					? generation * 1
					: "";
			} else {
				this.generation = null;
			}
			const response = await axios.post(`/api/recruit?page=${this.page}`, {
				freeword: this.freeword,
				tag: this.tag,
				prefecture: this.prefecture,
				region: this.region,
				generation: this.generation,
				type: this.searchType,
			});
			if (response.status === OK) {
				if (response.data.data.length !== 0) {
					this.page++;
					this.posts.push(...response.data.data);
					$state.loaded();
				} else {
					$state.complete();
				}
			} else {
				$state.complete();
				this.$store.commit("error/setCode", response.status);
			}
		},
	},
	computed: {
		// ログインチェック
		isLogin() {
			return this.$store.getters["auth/check"];
		},
		isLoginUserId() {
			return this.$store.getters["auth/userId"];
		},
	},
	watch: {
		$route(to, from) {
			this.postReload();
		},
	},
};
</script>

<style scoped></style>
