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
				<v-card
					class="mb-4"
					v-for="post in posts"
					:key="`posts-${post.id}`"
					color="cyan lighten-4"
					tile
					elevation="0"
				>
					<v-card-title class="font-weight-bold pl-3 pt-2">
						<router-link :to="`/post/${post.id}`" class="black--text">
							{{ post.title }}
						</router-link>
					</v-card-title>
					<v-card-text class="font-weight-bold pl-3 pt-0 pb-2">
						{{ post.message }}
					</v-card-text>
					<div class="mb-4 pl-3">
						<Tag
							v-for="tag in post.tags"
							:key="`tags-${tag.id}`"
							:tag-item="tag"
							:push-name="'post'"
						></Tag>
					</div>
					<Product :product-items="post.products"></Product>
					<v-card-actions class="pl-3">
						<v-avatar size="30" class="mr-1">
							<v-img :src="post.user.thumbnail_url"></v-img>
						</v-avatar>
						<span>{{ post.user.name }}</span>
					</v-card-actions>
					<v-card-actions class="pl-3 pt-0">
						<v-icon color="blue-grey lighten-3" class="mr-1">
							mdi-clock-outline
						</v-icon>
						<span class="text--disabled">{{ post.created_at }}</span>
					</v-card-actions>
					<v-card-actions class="pl-3 pt-0">
						<div class="ml-1 mr-2">
							<Comment
								:comments-count="post.comments_count"
								:post-id="post.id"
								:url="`/post/${post.id}`"
							></Comment>
						</div>
						<Like
							:likes-count="post.likes_count"
							:liked-by-user="post.liked_by_user"
							:post-id="post.id"
						></Like>
					</v-card-actions>
				</v-card>
				<infinite-loading ref="infiniteLoading" @infinite="infiniteHandler">
					<div slot="no-more">全件取得しました。</div>
				</infinite-loading>
			</v-col>
		</v-row>
	</div>
</template>
<script>
import Like from "../component/Like.vue";
import Comment from "../component/Comment.vue";
import Product from "../component/Product.vue";
import Tag from "../component/Tag.vue";
import NewPost from "../component/post/NewPost.vue";
import SearchPost from "../component/post/SearchPost.vue";
import { OK } from "../../util";
export default {
	data() {
		return {
			posts: [],
			freeword: "",
			tag: null,
			page: 1,
		};
	},
	components: {
		Like,
		Comment,
		Product,
		Tag,
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
			});
			if (response.status === OK) {
				if (this.page === 1 && response.data.data.length === 0) {
					this.$store.dispatch("flash/showFlashMessage", {
						show: true,
						message: "投稿が見つかりませんでした。 投稿一覧TOPへ戻ります。",
						type: 1,
						seconds: 3000,
					});
					setTimeout(() => {
						this.$router.push({ name: "post" }).catch((err) => {});
					}, 2000);
				} else {
					setTimeout(() => {
						if (response.data.data.length !== 0) {
							this.page++;
							this.posts.push(...response.data.data);
							$state.loaded();
						} else {
							$state.complete();
						}
					}, 1500);
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
