<template>
	<v-row>
		<v-fab-transition>
			<NewPost v-if="isLogin" @addPostReload="reloadPost"></NewPost>
		</v-fab-transition>
		<v-col
			cols="12"
			md="4"
			lg="4"
			xl="4"
			class="pb-0"
			:class="{ 'pr-0': !$vuetify.breakpoint.xs && !$vuetify.breakpoint.sm }"
		>
			<SearchPost></SearchPost>
		</v-col>
		<v-col cols="12" md="8" lg="8" xl="8">
			<v-row v-if="isLogin">
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
						@change="reloadPost"
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
				<div slot="no-results">投稿が見つかりませんでした。</div>
			</infinite-loading>
		</v-col>
	</v-row>
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
		reloadPost() {
			this.page = 1;
			this.posts = [];
			this.$refs.infiniteLoading.stateChanger.reset();
		},
		async infiniteHandler($state) {
			// getパラメーターチェックする
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
	},
	watch: {
		$route(to, from) {
			this.posts.splice(0, this.posts.length);
			this.reloadPost();
		},
	},
};
</script>

<style scoped></style>
