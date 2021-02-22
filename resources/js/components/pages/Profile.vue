<template>
	<div>
		<v-card tile elevation="0" class="mx-auto pb-5" max-width="800">
			<v-row>
				<v-col cols="12" sm="4" md="4" lg="4" xl="4" class="pt-0 pb-0">
					<div class="text-center mt-5">
						<v-avatar size="150" color="gray">
							<v-img :src="profiles.thumbnail_url"></v-img>
						</v-avatar>
						<div class="mt-5" v-if="id !== String(isLoginUserId)">
							<ChatAction :id="id" class="mr-3"></ChatAction>
							<Follow :user-id="id"></Follow>
						</div>
					</div>
				</v-col>
				<v-col cols="12" sm="8" md="8" lg="8" xl="8">
					<v-card-title class="font-weight-bold pl-2">
						{{ profiles.name }}
					</v-card-title>
					<v-card-actions class="pl-2">
						<v-btn
							class="black--text"
							:to="`/profile/${this.id}/following`"
							text
							>{{ profiles.follow_count }} フォロー</v-btn
						>
						<v-btn
							class="black--text"
							:to="`/profile/${this.id}/followers`"
							text
							>{{ profiles.follower_count }} フォロワー</v-btn
						>
					</v-card-actions>
					<v-card-actions class="pl-2">
						<span class="mr-3">年齢：{{ profiles.age }}</span>
						<span> 都道府県： {{ prefectureName }}</span>
					</v-card-actions>
					<v-card-text class="font-weight-bold p-0 pl-2 pr-2 mb-1">
						{{ profiles.introduction }}
					</v-card-text>
					<Tag
						v-for="tag in profiles.tags"
						:key="`profile-tags-${tag.id}`"
						:tag-item="tag"
						:push-name="''"
						class="pl-2"
					></Tag>
				</v-col>
			</v-row>
		</v-card>
		<ProfileTabs :user-id="id"></ProfileTabs>
	</div>
</template>

<script>
import { OK } from "../../util";
import Tag from "../component/Tag.vue";
import Follow from "../component/profile/Follow.vue";
import ProfileTabs from "../component/profile/ProfileTabs.vue";
import ChatAction from "../component/profile/ChatAction.vue";
export default {
	data() {
		return {
			profiles: [],
			prefectureName: "非公開",
		};
	},
	components: {
		Tag,
		ProfileTabs,
		Follow,
		ChatAction,
	},
	props: {
		id: {
			type: String,
			required: true,
		},
	},
	methods: {
		async showProfile() {
			const response = await axios.get(`/api/profile/${this.id}`);
			if (response.status === OK) {
				this.check = false;
				if (response.data.length !== 0) {
					this.profiles = response.data;
					if (this.profiles.published_age_flg === 1) {
						this.profiles.age = "非公開";
					}
					if (this.profiles.published_prefecture_flg !== 1) {
						if (this.profiles.prefecture) {
							this.prefectureName = this.profiles.prefecture.name;
						}
					}
				} else {
					this.$router.push({ name: "404" });
				}
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
	},
	computed: {
		isLoginUserId() {
			return this.$store.getters["auth/userId"];
		},
	},
	async created() {
		await this.showProfile();
	},
	watch: {
		async $route(to, from) {
			await this.showProfile();
		},
	},
};
</script>

<style></style>
