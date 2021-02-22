<template>
	<div class="profile-tabs">
		<v-btn text color="cyan" @click="routeBack" class="pl-1 mb-2">
			<v-icon>mdi-chevron-left</v-icon>
			<span>戻る</span>
		</v-btn>
		<v-tabs background-color="cyan" dark>
			<v-tab :to="`/profile/${this.id}/following`" class="text-decoration-none">
				フォロー
			</v-tab>
			<v-tab :to="`/profile/${this.id}/followers`" class="text-decoration-none">
				フォロワー
			</v-tab>
		</v-tabs>
		<v-card
			class="mb-2"
			tile
			elevation="0"
			v-for="user in users"
			:key="`follows-${user.id}`"
		>
			<v-card-actions class="pl-3">
				<router-link
					:to="`/profile/${user.id}`"
					class="black--text text-decoration-none"
				>
					<v-avatar size="30" class="mr-1">
						<v-img :src="user.thumbnail_url"></v-img>
					</v-avatar>
					<span>{{ user.name }}</span>
				</router-link>
				<v-spacer></v-spacer>
				<Follow :user-id="String(user.id)"></Follow>
			</v-card-actions>
		</v-card>
	</div>
</template>

<script>
import { OK } from "../../util";
import Follow from "../component/profile/Follow.vue";
export default {
	data() {
		return {
			users: [],
		};
	},
	props: {
		id: {
			type: String,
			required: true,
		},
	},
	components: {
		Follow,
	},
	methods: {
		routeBack() {
			this.$router.push({
				name: "profile",
				params: { id: this.id },
			});
		},
		async showFollowUsers() {
			if (this.$route.name === "following") {
				this.$store.commit("loading/setLoading", true);
				const response = await axios.get(`/api/profile/${this.id}/following`);
				if (response.status === OK) {
					this.users = response.data.follow_users;
					this.$store.commit("loading/setLoading", false);
				} else {
					this.$store.commit("error/setCode", response.status);
				}
			} else if (this.$route.name === "followers") {
				this.$store.commit("loading/setLoading", true);
				const response = await axios.get(`/api/profile/${this.id}/followers`);
				if (response.status === OK) {
					this.$store.commit("loading/setLoading", false);
					this.users = response.data.follower_users;
				} else {
					this.$store.commit("error/setCode", response.status);
				}
			}
		},
	},
	watch: {
		async $route(to, from) {
			await this.showFollowUsers();
		},
	},
	async created() {
		await this.showFollowUsers();
	},
};
</script>

<style></style>
