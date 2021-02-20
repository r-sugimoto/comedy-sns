<template>
	<div>
		<v-fab-transition>
			<NewPost v-if="isLogin" @addPostReload="postReload"></NewPost>
		</v-fab-transition>
		<v-row>
			<v-col class="pb-0 pt-0" cols="12" lg="4" xl="4">
				<SearchPost></SearchPost>
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
					<div slot="no-results">データが見つかりませんでした。</div>
				</infinite-loading>
			</v-col>
		</v-row>
	</div>
</template>
<script>
import NewPost from "../component/post/NewPost.vue";
import SearchPost from "../component/post/SearchPost.vue";
import PostCard from "../component/PostCard.vue";
import { OK } from "../../util";
export default {
	data() {
		return {
			posts: [],
			freeword: "",
			tag: null,
			page: 1,
			searchType: null,
			types: [{ text: "フォロー済", value: 1 }],
		};
	},
	components: {
		PostCard,
		NewPost,
		SearchPost,
	},
	methods: {
		postReload() {
			this.page = 1;
			this.posts = [];
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
			const response = await axios.post(`/api/post?page=${this.page}`, {
				freeword: this.freeword,
				tag: this.tag,
				type: this.searchType,
			});
			if (response.status === OK) {
				if (this.page === 1 && response.data.data.length === 0) {
					this.searchType = null;
					this.$store.dispatch("flash/showFlashMessage", {
						show: true,
						message: "投稿が見つかりませんでした。 投稿一覧TOPへ戻ります。",
						type: 1,
						seconds: 3000,
					});
					setTimeout(() => {
						this.$router.push({ name: "post" }).catch((err) => {});
						this.postReload();
					}, 2000);
				} else {
					if (response.data.data.length !== 0) {
						this.page++;
						this.posts.push(...response.data.data);
						$state.loaded();
					} else {
						$state.complete();
					}
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
	},
	watch: {
		$route(to, from) {
			this.posts.splice(0, this.posts.length);
			this.postReload();
		},
	},
};
</script>

<style scoped></style>
