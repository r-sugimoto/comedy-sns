<template>
	<div class="profile-tabs">
		<v-tabs background-color="cyan" dark max-width="640">
			<v-tab @click="profileTabs(0)">投稿</v-tab>
			<v-tab @click="profileTabs(1)">コメントした投稿</v-tab>
			<v-tab @click="profileTabs(2)">いいね</v-tab>
		</v-tabs>
		<v-row>
			<v-spacer></v-spacer>
			<v-col cols="6">
				<v-select
					v-model="searchType"
					:items="types"
					placeholder="絞り込む"
					background-color="#fff"
					hide-details
					outlined
					clearable
					@change="changeType"
				>
				</v-select>
			</v-col>
		</v-row>
		<PostCard
			v-for="post in posts"
			:key="`posts-${post.id}`"
			:post="post"
		></PostCard>
		<infinite-loading ref="infiniteLoading" @infinite="infiniteHandler">
			<div slot="no-more">全件取得しました。</div>
		</infinite-loading>
	</div>
</template>

<script>
import PostCard from "../PostCard.vue";
import { OK } from "../../../util";
export default {
	data() {
		return {
			posts: [],
			page: 1,
			like: null,
			comment: null,
			searchType: null,
			types: [
				{ text: "タイムライン", value: 1 },
				{ text: "相方募集投稿", value: 2 },
			],
		};
	},
	components: {
		PostCard,
	},
	props: {
		UserId: {
			type: String,
			required: true,
		},
	},
	methods: {
		profileTabs(val) {
			this.page = 1;
			this.posts.splice(0, this.posts.length);
			this.comment = null;
			this.like = null;
			if (val === 1) {
				this.comment = this.UserId;
			} else if (val === 2) {
				this.like = this.UserId;
			}
			this.$refs.infiniteLoading.stateChanger.reset();
		},
		changeType() {
			this.page = 1;
			this.posts.splice(0, this.posts.length);
			this.$refs.infiniteLoading.stateChanger.reset();
		},
		async infiniteHandler($state) {
			const response = await axios.post(`/api/profile/post?page=${this.page}`, {
				user_id: this.UserId,
				type: this.searchType,
				like: this.like,
				comment: this.comment,
			});
			if (response.status === OK) {
				if (this.page === 1 && response.data.data.length === 0) {
					$state.complete();
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
};
</script>

<style>
.profile-tabs {
	max-width: 640px;
	margin: auto;
}
</style>
