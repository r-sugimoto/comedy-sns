<template>
	<v-row>
		<v-col cols="12" class="pb-0">
			<RouteBack></RouteBack>
		</v-col>
		<v-col
			cols="4"
			class="pr-0"
			v-if="!$vuetify.breakpoint.xs && !$vuetify.breakpoint.sm"
		>
			<ProfileCard
				v-for="(post, i) in posts"
				:key="`profiles-${i}`"
				:id="post.user.id"
			></ProfileCard>
		</v-col>
		<v-col cols="12" md="8" lg="8" xl="8">
			<v-card
				class="mb-4"
				v-for="(post, i) in posts"
				:key="`posts-${i}`"
				style="border-top: solid 6px #80deea"
				elevation="0"
				tile
			>
				<v-card-title class="font-weight-bold pl-3 pr-3 pt-2 pb-2">
					{{ post.title }}
				</v-card-title>
				<v-card-text class="font-weight-bold pl-3 pr-3">
					{{ post.message }}
					<Tag
						v-for="(tag, i) in post.tags"
						:key="`tags-${i}`"
						:tag-item="tag"
						:push-name="'recruit'"
					></Tag>
				</v-card-text>
				<Product :product-items="post.products" class="pl-3 pr-3"></Product>
				<v-card-actions class="pl-3 pr-3 pt-2 pb-0">
					<router-link
						:to="`/profile/${post.user.id}`"
						class="black--text text-decoration-none"
					>
						<Avatar
							:size="30"
							:thumbnail="post.user.thumbnail"
							:url="post.user.thumbnail_url"
							class="mr-1"
						></Avatar>
						<span class="va-m">
							{{ post.user.name }}
						</span>
					</router-link>
				</v-card-actions>
				<v-card-actions class="pl-3 pr-3 pt-2 pb-0">
					<span class="text--disabled">{{ post.created_at }}</span>
				</v-card-actions>
				<v-card-actions class="pl-2 pr-3 pt-2 pb-2">
					<Apply
						:post-id="post.id"
						:user-id="post.user.id"
						:user-id-check="post.user.id === isLoginUserId"
						class="ml-1 mr-1"
					></Apply>
					<Reply
						:post-id="post.id"
						@emitShowPostDetail="showPostDetail"
						class="mr-1"
					></Reply>
					<Like
						:likes-count="post.likes_count"
						:liked-by-user="post.liked_by_user"
						:post-id="post.id"
					></Like>
					<v-spacer></v-spacer>
					<OptionPostDetail
						:post-id="post.id"
						:user-id-check="post.user.id === isLoginUserId"
						:path-name="'recruit'"
					></OptionPostDetail>
				</v-card-actions>
			</v-card>
			<v-card
				tile
				v-for="(comment, i) in comments"
				:key="`comment-${i}`"
				color="cyan lighten-5"
				elevation="0"
			>
				<v-card-actions class="pl-2 pt-2 pb-2 pr-3">
					<v-icon>mdi-reply</v-icon>
				</v-card-actions>
				<v-card-text class="font-weight-bold pl-3 pr-3 pt-0 pb-0">
					{{ comment.pivot.message }}
				</v-card-text>
				<v-card-actions class="pl-3 pr-3 pt-2 pb-0">
					<router-link
						:to="`/profile/${comment.id}`"
						class="black--text text-decoration-none"
					>
						<Avatar
							:size="30"
							:thumbnail="comment.thumbnail"
							:url="comment.thumbnail_url"
							class="mr-1"
						></Avatar>
						<span class="va-m">
							{{ comment.name }}
						</span>
					</router-link>
				</v-card-actions>
				<v-card-actions class="pl-3 pr-3 pt-2 pb-2">
					<span class="text--disabled">{{ comment.created_at }}</span>
					<v-spacer></v-spacer>
					<OptionCommentDetail
						:comment-id="comment.pivot.id"
						:user-id-check="comment.id === isLoginUserId"
						@emitShowPostDetail="showPostDetail"
					></OptionCommentDetail>
				</v-card-actions>
			</v-card>
		</v-col>
	</v-row>
</template>

<script>
import Like from "../component/Like.vue";
import Comment from "../component/Comment.vue";
import Product from "../component/Product.vue";
import Tag from "../component/Tag.vue";
import Reply from "../component/Reply.vue";
import OptionPostDetail from "../component/OptionPostDetail.vue";
import OptionCommentDetail from "../component/OptionCommentDetail.vue";
import Apply from "../component/recruit/Apply.vue";
import ProfileCard from "../component/ProfileCard.vue";
import RouteBack from "../component/RouteBack.vue";
import Avatar from "../elements/Avatar.vue";
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
		Apply,
		RouteBack,
		ProfileCard,
		Avatar,
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
					this.$router.push({ name: "not-found" });
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
	},
	created() {
		this.showPostDetail();
	},
};
</script>

<style></style>
