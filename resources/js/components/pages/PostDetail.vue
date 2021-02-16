<template>
	<div>
		<v-row>
			<v-col class="pb-0 pt-0 xs-pl-pr">
				<div class="pl-0 mb-2">
					<RouteBack :path-name="'post'"></RouteBack>
				</div>
				<v-card
					class="mb-4"
					v-for="post in posts"
					:key="`posts-${post.id}`"
					color="cyan lighten-4"
					tile
					elevation="0"
				>
					<v-card-title class="font-weight-bold pl-3 pt-2">
						{{ post.title }}
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
					<v-card-actions class="pl-2 pt-0">
						<div class="mr-2">
							<Reply
								v-if="isLogin"
								:post-id="post.id"
								@addShowPostDetail="showPostDetail"
							></Reply>
						</div>
						<Like
							:likes-count="post.likes_count"
							:liked-by-user="post.liked_by_user"
							:post-id="post.id"
						></Like>
						<v-spacer></v-spacer>
						<div class="mr-2">
							<OptionPostDetail
								:post-id="post.id"
								:user-id-check="post.user.id === isLoginUserId"
								:path-name="'post'"
							></OptionPostDetail>
						</div>
					</v-card-actions>
				</v-card>
				<v-card
					tile
					v-for="comment in comments"
					:key="`comment-${comment.pivot.id}`"
					color="light-green lighten-4"
					elevation="0"
				>
					<div class="pl-2 pt-2">
						<v-icon class="">mdi-reply</v-icon>
					</div>
					<v-card-text class="font-weight-bold pl-3 pt-2">
						{{ comment.pivot.message }}
					</v-card-text>
					<v-card-actions class="pl-3 pt-0">
						<v-avatar size="30" class="mr-1">
							<v-img :src="comment.thumbnail_url"></v-img>
						</v-avatar>
						<span>{{ comment.name }}</span>
					</v-card-actions>
					<v-card-actions class="pl-3 pt-0">
						<v-icon color="blue-grey lighten-3" class="mr-1">
							mdi-clock-outline
						</v-icon>
						<span class="text--disabled">{{ comment.created_at }}</span>
						<v-spacer></v-spacer>
						<div class="mr-2">
							<OptionCommentDetail
								:comment-id="comment.pivot.id"
								:user-id-check="comment.id === isLoginUserId"
								@addShowPostDetail="showPostDetail"
							></OptionCommentDetail>
						</div>
					</v-card-actions>
				</v-card>
			</v-col>
		</v-row>
	</div>
</template>

<script>
import Like from "../component/Like.vue";
import Comment from "../component/Comment.vue";
import Product from "../component/Product.vue";
import Tag from "../component/Tag.vue";
import Reply from "../component/Reply.vue";
import OptionPostDetail from "../component/OptionPostDetail.vue";
import OptionCommentDetail from "../component/OptionCommentDetail.vue";
import RouteBack from "../component/RouteBack.vue";
import { OK } from "../../util";
export default {
	data() {
		return {
			posts: [],
			comments: [],
		};
	},
	components: {
		Like,
		Comment,
		Product,
		Tag,
		Reply,
		OptionPostDetail,
		OptionCommentDetail,
		RouteBack,
	},
	props: {
		id: {
			type: String,
			required: true,
		},
	},
	methods: {
		async showPostDetail() {
			this.$store.commit("loading/setLoading", true);
			const response = await axios.get(`/api/post/${this.id}`);
			if (response.status === OK) {
				if (response.data.length !== 0) {
					this.posts = response.data;
					this.comments = this.posts[0].comments;
				} else {
					this.$store.commit("loading/setLoading", false);
					this.$router.push({ name: "post" });
				}
			} else {
				this.$store.commit("error/setCode", response.status);
			}
			this.$store.commit("loading/setLoading", false);
		},
	},
	computed: {
		isLogin() {
			return this.$store.getters["auth/check"];
		},
		isLoginUserId() {
			return this.$store.getters["auth/userId"];
		},
		// 前のページの情報取得
		prevRoute() {
			return this.$store.getters["route/getPrevRoute"];
		},
	},
	created() {
		this.showPostDetail();
	},
};
</script>

<style></style>
