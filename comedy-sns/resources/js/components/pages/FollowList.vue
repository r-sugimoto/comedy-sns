<template>
	<v-row>
		<v-col cols="12" class="pb-0">
			<v-btn text color="cyan" @click="routeBack" class="pl-1">
				<v-icon>mdi-chevron-left</v-icon>
				<span>戻る</span>
			</v-btn>
		</v-col>
		<v-col
			cols="12"
			md="4"
			lg="4"
			xl="4"
			class="pb-0"
			:class="{ 'pr-0': !$vuetify.breakpoint.xs && !$vuetify.breakpoint.sm }"
		>
			<v-list
				nav
				dense
				v-if="!$vuetify.breakpoint.xs && !$vuetify.breakpoint.sm"
			>
				<v-list-item :to="`/profile/${this.id}/following`">
					<v-list-item-icon>
						<v-icon>mdi-account-arrow-right-outline</v-icon>
					</v-list-item-icon>
					<v-list-item-title>フォロー</v-list-item-title>
				</v-list-item>
				<v-list-item :to="`/profile/${this.id}/followers`">
					<v-list-item-icon>
						<v-icon>mdi-account-arrow-left-outline</v-icon>
					</v-list-item-icon>
					<v-list-item-title>フォロワー</v-list-item-title>
				</v-list-item>
			</v-list>
			<v-tabs background-color="cyan" dark v-else>
				<v-tab
					:to="`/profile/${this.id}/following`"
					class="text-decoration-none"
				>
					フォロー
				</v-tab>
				<v-tab
					:to="`/profile/${this.id}/followers`"
					class="text-decoration-none"
				>
					フォロワー
				</v-tab>
			</v-tabs>
		</v-col>
		<v-col
			cols="12"
			md="8"
			lg="8"
			xl="8"
			:class="{ 'pt-0': $vuetify.breakpoint.xs || $vuetify.breakpoint.sm }"
		>
			<v-card
				class="mb-2"
				tile
				elevation="0"
				v-for="(user, i) in users"
				:key="`follows-${i}`"
			>
				<v-card-actions class="pl-3">
					<router-link
						:to="`/profile/${user.id}`"
						class="black--text text-decoration-none"
					>
						<Avatar
							:size="30"
							:thumbnail="user.thumbnail"
							:url="user.thumbnail_url"
							class="mr-1"
						></Avatar>
						<span va-m>{{ user.name }}</span>
					</router-link>
					<v-spacer></v-spacer>
					<Follow
						v-if="isLoginUserId !== user.id"
						:user-id="String(user.id)"
					></Follow>
				</v-card-actions>
			</v-card>
		</v-col>
	</v-row>
</template>

<script>
import { OK } from "../../util";
import Follow from "../component/profile/Follow.vue";
import Avatar from "../elements/Avatar.vue";
export default {
	data() {
		return {
			item: 0,
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
		Avatar,
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
				} else {
					this.$store.commit("error/setCode", response.status);
				}
				this.$store.commit("loading/setLoading", false);
			} else if (this.$route.name === "followers") {
				this.$store.commit("loading/setLoading", true);
				const response = await axios.get(`/api/profile/${this.id}/followers`);
				if (response.status === OK) {
					this.users = response.data.follower_users;
				} else {
					this.$store.commit("error/setCode", response.status);
				}
				this.$store.commit("loading/setLoading", false);
			}
		},
	},
	computed: {
		isLoginUserId() {
			return this.$store.getters["auth/userId"];
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
