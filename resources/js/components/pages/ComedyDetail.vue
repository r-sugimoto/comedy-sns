<template>
	<div class="mt-n3 profile-tabs">
		<RouteBack></RouteBack>
		<v-card class="mb-3" elevation="0" tile>
			<v-card-title class="pl-3 pt-1 pb-1">
				<router-link :to="`/comedy/${comedy.id}`" class="black--text">
					{{ comedy.name }}
				</router-link>
			</v-card-title>
			<v-card-actions
				class="pl-3 pt-0"
				v-for="(user, i) in comedy.users"
				:key="`users-${i}`"
			>
				<router-link
					:to="`/profile/${user.id}`"
					class="black--text text-decoration-none"
				>
					<v-avatar size="30" class="mr-1">
						<v-img :src="user.thumbnail_url"></v-img>
					</v-avatar>
					<span>{{ user.name }}</span>
				</router-link>
			</v-card-actions>
			<v-card-actions class="pl-3 pt-0 pr-3">
				<v-icon color="blue-grey lighten-3" class="mr-1">
					mdi-clock-outline
				</v-icon>
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
	</div>
</template>

<script>
import { OK } from "../../util";
import RouteBack from "../component/RouteBack.vue";
import ComedySetting from "../component/comedy/ComedySetting.vue";
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
	},
	methods: {
		async showComedy() {
			this.$store.commit("loading/setLoading", true);
			const response = await axios.get(`/api/comedy/${this.id}`);
			if (response.status === OK) {
				this.comedy = response.data;
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
