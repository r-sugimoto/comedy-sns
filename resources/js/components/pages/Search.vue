<template>
	<div>
		<v-row>
			<v-col class="pb-0 pt-0" cols="12" lg="4" xl="4">
				<SiteSearch></SiteSearch>
			</v-col>
			<v-col class="pb-0 pt-0" lg="8" xl="8">
				<v-tabs background-color="cyan" v-model="tabs" dark>
					<v-tab
						class="text-decoration-none"
						@click="changeTabs(0)"
						href="#tab-1"
						>投稿</v-tab
					>
					<v-tab
						class="text-decoration-none"
						@click="changeTabs(1)"
						href="#tab-2"
						>ユーザー</v-tab
					>
					<v-tab
						class="text-decoration-none"
						@click="changeTabs(2)"
						href="#tab-3"
						>コンビ</v-tab
					>
				</v-tabs>
				<div v-if="tabType === 0">
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
								@change="postReload"
							>
							</v-select>
						</v-col>
					</v-row>
					<PostCard
						v-for="(post, i) in results"
						:key="`posts-${i}`"
						:post="post"
					></PostCard>
				</div>
				<div v-if="tabType === 1">
					<ProfileCard
						v-for="(user, i) in results"
						:key="`users-${i}`"
						:user="user"
					></ProfileCard>
				</div>
				<div v-if="tabType === 2">
					<ComedyCard
						v-for="(comedy, i) in results"
						:key="`comedies-${i}`"
						:comedy="comedy"
					></ComedyCard>
				</div>
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
import { OK } from "../../util";
import SiteSearch from "../component/search/SiteSearch.vue";
import PostCard from "../component/PostCard.vue";
import ProfileCard from "../component/search/ProfileCard.vue";
import ComedyCard from "../component/ComedyCard.vue";
export default {
	data() {
		return {
			results: [],
			tabType: 0,
			tabs: "",
			page: 1,
			searchType: null,
			types: [
				{ text: "タイムライン", value: 1 },
				{ text: "相方募集投稿", value: 2 },
			],
			freeword: "",
			tag: null,
		};
	},
	components: {
		SiteSearch,
		PostCard,
		ProfileCard,
		ComedyCard,
	},
	methods: {
		postReload() {
			this.page = 1;
			this.results = [];
			this.$refs.infiniteLoading.stateChanger.reset();
		},
		changeTabs(val) {
			this.tabType = val;
			this.postReload();
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
			if (this.tabType === 0) {
				const response = await axios.post(
					`/api/search/post?page=${this.page}`,
					{
						type: this.searchType,
						freeword: this.freeword,
						tag: this.tag,
					}
				);
				if (response.status === OK) {
					if (this.page === 1 && response.data.data.length === 0) {
						$state.complete();
					} else {
						if (response.data.data.length !== 0) {
							this.page++;
							this.results.push(...response.data.data);
							$state.loaded();
						} else {
							$state.complete();
						}
					}
				} else {
					$state.complete();
					this.$store.commit("error/setCode", response.status);
				}
			} else if (this.tabType === 1) {
				const response = await axios.post(
					`/api/search/profile?page=${this.page}`,
					{
						freeword: this.freeword,
						tag: this.tag,
					}
				);
				if (response.status === OK) {
					if (this.page === 1 && response.data.data.length === 0) {
						$state.complete();
					} else {
						if (response.data.data.length !== 0) {
							this.page++;
							this.results.push(...response.data.data);
							$state.loaded();
						} else {
							$state.complete();
						}
					}
				} else {
					$state.complete();
					this.$store.commit("error/setCode", response.status);
				}
			} else if (this.tabType === 2) {
				const response = await axios.post(
					`/api/search/comedy?page=${this.page}`,
					{
						freeword: this.freeword,
					}
				);
				if (response.status === OK) {
					if (this.page === 1 && response.data.data.length === 0) {
						$state.complete();
					} else {
						if (response.data.data.length !== 0) {
							this.page++;
							this.results.push(...response.data.data);
							$state.loaded();
						} else {
							$state.complete();
						}
					}
				} else {
					$state.complete();
					this.$store.commit("error/setCode", response.status);
				}
			}
		},
	},
	created() {
		if (this.$route.query.profile !== undefined) {
			if (this.$route.query.profile) {
				this.tabs = "tab-2";
				this.tabType = 1;
			}
		}
	},
	watch: {
		$route(to, from) {
			this.results.splice(0, this.results.length);
			this.postReload();
		},
	},
};
</script>

<style></style>
