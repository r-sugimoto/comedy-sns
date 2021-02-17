<template>
	<div>
		<v-card tile elevation="0" class="mx-auto pb-5" max-width="640">
			<v-row>
				<v-col cols="12" sm="4" md="4" lg="4" xl="4" class="pt-0 pb-0">
					<div class="text-center">
						<v-avatar size="150" color="gray">
							<v-img :src="profiles.thumbnail_url"></v-img>
						</v-avatar>
						<div class="mt-5">
							<Message class="mr-3"></Message>
							<Follow></Follow>
						</div>
					</div>
				</v-col>
				<v-col cols="12" sm="8" md="8" lg="8" xl="8">
					<v-card-title class="font-weight-bold">
						{{ profiles.name }}
					</v-card-title>
					<v-card-actions class="pl-0">
						<v-btn
							class="black--text"
							:to="`/profile/${this.id}/following`"
							text
							>0 フォロー中</v-btn
						>
						<v-btn
							class="black--text"
							:to="`/profile/${this.id}/followers`"
							text
							>1 フォロワー</v-btn
						>
					</v-card-actions>
					<v-card-actions class="pl-0">
						<span class="mr-3">年齢：{{ profiles.age }}</span>
						<span> 都道府県： {{ prefectureName }}</span>
					</v-card-actions>
					<v-card-text class="font-weight-bold p-0 mb-1">
						{{ profiles.introduction }}
					</v-card-text>
					<Tag
						v-for="tag in profiles.tags"
						:key="`profile-tags-${tag.id}`"
						:tag-item="tag"
						:push-name="''"
					></Tag>
				</v-col>
			</v-row>
		</v-card>
		<ProfileTabs></ProfileTabs>
	</div>
</template>

<script>
import { OK } from "../../util";
import Tag from "../component/Tag.vue";
import Follow from "../component/profile/Follow.vue";
import Message from "../component/profile/Message.vue";
import ProfileTabs from "../component/profile/ProfileTabs.vue";
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
		Message,
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
				this.$store.commit("error/setCode", response.status);
			}
		},
	},
	async created() {
		await this.showProfile();
	},
};
</script>

<style></style>
