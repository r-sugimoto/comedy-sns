<template>
	<div>
		<v-tabs
			background-color="cyan"
			v-model="tabs"
			dark
			:show-arrows="$vuetify.breakpoint.xsOnly"
		>
			<v-tab
				class="text-decoration-none"
				@click="changeProfileTabs(0)"
				href="#tab-1"
			>
				投稿
			</v-tab>
			<v-tab
				class="text-decoration-none"
				@click="changeProfileTabs(1)"
				href="#tab-2"
				>コメントした投稿</v-tab
			>
			<v-tab
				class="text-decoration-none"
				@click="changeProfileTabs(2)"
				href="#tab-3"
				>いいね</v-tab
			>
		</v-tabs>
		<v-row class="pt-1 pb-1">
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
					@change="changeType"
				>
				</v-select>
			</v-col>
		</v-row>
		<PostCard
			v-for="(post, i) in posts"
			:key="`posts-${i}`"
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
	</div>
</template>

<script>
import PostCard from "../PostCard.vue";
import { OK } from "../../../util";
export default {
	data() {
		return {
			tabs: "tab-1",
			selectValue: 0,
			posts: [],
			page: 1,
			post: this.UserId,
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
		changeProfileTabs(val) {
			this.selectValue = val;
			this.page = 1;
			this.posts.splice(0, this.posts.length);
			this.post = null;
			this.comment = null;
			this.like = null;
			if (val === 0) {
				this.post = this.UserId;
			} else if (val === 1) {
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
				post: this.post,
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
	watch: {
		$route(to, from) {
			this.tabs = "tab-1";
			this.changeProfileTabs(0);
		},
	},
};
</script>

<style></style>
