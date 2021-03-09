<template>
	<div>
		<v-card
			class="mb-4"
			tile
			elevation="0"
			style="border-top: solid 6px #80cbc4"
			v-if="post.recruit_id === null"
		>
			<v-card-title class="font-weight-bold pl-3 pr-3 pt-2 pb-2">
				<router-link :to="`/post/${post.id}`" class="black--text">
					{{ post.title }}
				</router-link>
			</v-card-title>
			<v-card-text class="font-weight-bold pl-3 pr-3">
				{{ post.message }}
				<Tag
					v-for="tag in post.tags"
					:key="`tags-${tag.id}`"
					:tag-item="tag"
					:push-name="'post'"
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
			<v-card-actions class="pl-3 pr-3 pt-2 pb-2">
				<Comment
					class="ml-1"
					:comments-count="post.comments_count"
					:post-id="post.id"
					:url="`/post/${post.id}`"
				></Comment>
				<Like
					:likes-count="post.likes_count"
					:liked-by-user="post.liked_by_user"
					:post-id="post.id"
				></Like>
			</v-card-actions>
		</v-card>
		<v-card
			v-if="post.recruit_id !== null"
			class="mb-4"
			elevation="0"
			tile
			style="border-top: solid 6px #80deea"
		>
			<v-card-title class="font-weight-bold pl-3 pr-3 pt-2 pb-2">
				<router-link :to="`/recruit/${post.id}`" class="black--text">
					{{ post.title }}
				</router-link>
			</v-card-title>
			<v-card-text class="font-weight-bold pl-3 pr-3">
				{{ post.message }}
				<Tag
					v-for="tag in post.tags"
					:key="`tags-${tag.id}`"
					:tag-item="tag"
					:push-name="'recruit'"
				></Tag>
				<RecruitContents :recruit-content="post.recruit"></RecruitContents>
			</v-card-text>
			<Product :product-items="post.products"></Product>
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
			<v-card-actions class="pl-3 pr-3 pt-2 pb-2">
				<Apply
					:user-id="post.user.id"
					:user-id-check="post.user.id === isLoginUserId"
					class="mr-1"
				></Apply>
				<Comment
					class="ml-1"
					:comments-count="post.comments_count"
					:post-id="post.id"
					:url="`/recruit/${post.id}`"
				></Comment>
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
import Avatar from "../elements/Avatar.vue";
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
		Avatar,
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
