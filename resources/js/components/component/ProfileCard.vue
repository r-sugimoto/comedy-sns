<template>
	<v-card tile elevation="0" class="pb-2">
		<v-card-actions class="text-center">
			<v-row align="center" justify="center">
				<v-col>
					<Avatar
						:size="125"
						:thumbnail="profiles.thumbnail"
						:url="profiles.thumbnail_url"
					></Avatar>
				</v-col>
			</v-row>
		</v-card-actions>
		<v-card-actions v-if="id !== String(isLoginUserId)">
			<v-row align="center" justify="center">
				<ChatAction :id="id" class="ml-5"></ChatAction>
				<Follow :user-id="id" class="ml-5"></Follow>
			</v-row>
		</v-card-actions>
		<v-card-title class="font-weight-bold p-0 pl-3 pr-3">
			<router-link class="black--text" :to="`/profile/${this.id}`">{{
				profiles.name
			}}</router-link>
		</v-card-title>
		<v-card-actions class="pt-2 pl-3 pr-3 pb-0">
			<router-link
				class="black--text mr-3"
				:to="`/profile/${this.id}/following`"
				>{{ profiles.follow_count }} フォロー</router-link
			>
			<router-link class="black--text" :to="`/profile/${this.id}/followers`"
				>{{ profiles.follower_count }} フォロワー</router-link
			>
		</v-card-actions>
		<v-card-actions class="pt-2 pl-3 pr-3 pb-2">
			<span class="mr-3">年齢：{{ profiles.age }}</span>
			<span> 都道府県： {{ prefectureName }}</span>
		</v-card-actions>
		<v-card-title class="font-weight-bold p-0 pl-3 pr-3">
			自己紹介
		</v-card-title>
		<v-card-text class="font-weight-bold pl-3 pr-3 pb-0 pt-0">
			<CreateTextUrl :text="profiles.introduction" />
			<Tag
				v-for="tag in profiles.tags"
				:key="`profile-tags-${tag.id}`"
				:tag-item="tag"
				:push-name="'profile'"
			></Tag>
		</v-card-text>
	</v-card>
</template>

<script>
import { OK } from "../../util";
import Tag from "../component/Tag.vue";
import Follow from "../component/profile/Follow.vue";
import ProfileTabs from "../component/profile/ProfileTabs.vue";
import ChatAction from "../component/profile/ChatAction.vue";
import Avatar from "../elements/Avatar.vue";
import CreateTextUrl from "../elements/CreateTextUrl.vue";
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
		Avatar,
		CreateTextUrl,
	},
	props: {
		id: {
			type: [String, Number],
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
