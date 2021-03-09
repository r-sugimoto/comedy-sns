<template>
	<v-row align="center" justify="center">
		<v-col class="pb-0" cols="12" md="8" lg="8" xl="8">
			<RouteBack></RouteBack>
			<v-card class="mb-3 mt-3" elevation="0" tile>
				<v-card-title class="pl-3 pt-2 pb-0 pr-3">
					{{ comedy.name }}
				</v-card-title>
				<v-card-actions
					class="pl-3 pr-3 pt-2 pb-0"
					v-for="(user, i) in comedy.users"
					:key="`users-${i}`"
				>
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
						<span class="va-m">
							{{ user.name }}
						</span>
					</router-link>
				</v-card-actions>
				<v-card-actions class="pl-3 pr-3 pt-2 pb-2">
					<span class="text--disabled">{{ comedy.created_at }}</span>
					<v-spacer></v-spacer>
					<span v-for="(user, i) in comedy.users" :key="`users-${i}`">
						<ComedySetting
							v-if="user.id === isLoginUserId"
							:comedy-name="comedy.name"
							:id="comedy.id"
							@emitShowComedy="showComedy()"
						></ComedySetting>
					</span>
				</v-card-actions>
			</v-card>
		</v-col>
	</v-row>
</template>

<script>
import { OK } from "../../util";
import RouteBack from "../component/RouteBack.vue";
import ComedySetting from "../component/comedy/ComedySetting.vue";
import Avatar from "../elements/Avatar.vue";
export default {
	data() {
		return {
			comedy: [],
		};
	},
	props: {
		id: {
			type: String,
			required: true,
		},
	},
	components: {
		RouteBack,
		ComedySetting,
		Avatar,
	},
	methods: {
		async showComedy() {
			this.$store.commit("loading/setLoading", true);
			const response = await axios.get(`/api/comedy/${this.id}`);
			if (response.status === OK) {
				if (response.data.length !== 0) {
					this.comedy = response.data;
				} else {
					this.$store.commit("loading/setLoading", false);
					this.$router.push({ name: "not-found" });
				}
			} else {
				this.$store.commit("error/setCode", response.status);
			}
			this.$store.commit("loading/setLoading", false);
		},
	},
	computed: {
		isLogin() {
			return this.$store.getters["auth/check"];
		},
		isLoginUserId() {
			return this.$store.getters["auth/userId"];
		},
	},
	async created() {
		await this.showComedy();
	},
};
</script>

<style></style>
