<template>
	<div>
		<v-card tile elevation="0">
			<v-avatar size="100" color="gray">
				<v-img :src="profiles.thumbnail_url"></v-img>
			</v-avatar>
			<v-card-title class="font-weight-bold">
				{{ profiles.name }}
			</v-card-title>
			<v-card-text>年齢：{{ profiles.age }}</v-card-text>
			<v-card-text>居住地：{{ profiles.prefecture.name }}</v-card-text>
			<v-card-text class="font-weight-bold">
				{{ profiles.introduction }}
			</v-card-text>
			<Tag
				v-for="tag in profiles.tags"
				:key="`profile-tags-${tag.id}`"
				:tag-item="tag"
				:push-name="'profile'"
			></Tag>
		</v-card>
	</div>
</template>

<script>
import Tag from "../component/Tag.vue";
import { OK } from "../../util";
export default {
	data() {
		return {
			profiles: [],
		};
	},
	components: {
		Tag,
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
				console.log(response.data);
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
