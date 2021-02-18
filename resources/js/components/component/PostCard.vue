<template>
	<div>
		<v-card
			class="mb-4"
			color="cyan lighten-4"
			tile
			elevation="0"
			v-if="post.recruit_id === null"
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
		<v-card v-if="post.recruit_id !== null" class="mb-4" elevation="0" tile>
			<v-card-title class="font-weight-bold pl-3 pt-2">
				<router-link :to="`/recruit/${post.id}`" class="black--text">
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
					:push-name="'recruit'"
				></Tag>
			</div>
			<div class="pl-3 mb-2">
				<RecruitContents :recruit-content="post.recruit"></RecruitContents>
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
			<v-card-actions class="pl-1 pt-0">
				<div class="mr-2">
					<Apply
						:post-id="post.id"
						:user-id-check="post.user.id === isLoginUserId"
					></Apply>
				</div>
				<div class="mr-2">
					<Comment
						:comments-count="post.comments_count"
						:post-id="post.id"
						:url="`/recruit/${post.id}`"
					></Comment>
				</div>
				<Like
					:likes-count="post.likes_count"
					:liked-by-user="post.liked_by_user"
					:post-id="post.id"
				></Like>
			</v-card-actions>
		</v-card>
	</div>
</template>

<script>
import Like from "../component/Like.vue";
import Comment from "../component/Comment.vue";
import Product from "../component/Product.vue";
import Tag from "../component/Tag.vue";
import Apply from "../component/recruit/Apply.vue";
import RecruitContents from "../component/recruit/RecruitContents.vue";
export default {
	data() {
		return {};
	},
	components: {
		Tag,
		Like,
		Product,
		Comment,
		Apply,
		RecruitContents,
	},
	props: {
		post: {
			type: Object,
		},
	},
	computed: {
		isLoginUserId() {
			return this.$store.getters["auth/userId"];
		},
	},
};
</script>

<style></style>
