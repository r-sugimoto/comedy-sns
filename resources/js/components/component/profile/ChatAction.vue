<template>
	<v-btn @click="createChat" color="cyan" x-large icon>
		<v-icon>mdi-chat-processing-outline</v-icon>
	</v-btn>
</template>

<script>
import { OK, CREATED } from "../../../util";
export default {
	props: {
		id: {
			type: String,
		},
	},
	methods: {
		async createChat() {
			const response = await axios.get(`/api/chat/new/${this.id}`);
			if (response.status === OK) {
				this.$router.push({
					name: "chat-detail",
					params: { id: response.data.id },
				});
			} else if (response.status === CREATED) {
				this.$router.push({
					name: "chat-detail",
					params: { id: response.data.id },
				});
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
	},
	computed: {
		isLogin() {
			return this.$store.getters["auth/check"];
		},
	},
};
</script>

<style></style>
