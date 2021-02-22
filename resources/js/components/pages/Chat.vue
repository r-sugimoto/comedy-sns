<template>
	<div>
		<v-card
			v-for="chat in chats"
			:key="`chats-${chat.id}`"
			:to="`/chat/${chat.id}`"
			class="mb-3 text-decoration-none mx-auto"
			max-width="800"
			elevation="0"
			tile
		>
			<v-card-actions v-if="chat.name === null">
				<v-avatar size="50" color="gray">
					<v-img :src="chat.users[0].thumbnail_url"></v-img>
				</v-avatar>
				<span class="ml-3">{{ chat.users[0].name }} </span>
				<v-spacer></v-spacer>
				<v-btn color="cyan" x-large icon>
					<v-icon>mdi-chat-processing-outline</v-icon>
				</v-btn>
			</v-card-actions>
		</v-card>
	</div>
</template>

<script>
import { OK } from "../../util";
export default {
	data() {
		return {
			chats: [],
		};
	},
	methods: {
		async showRooms() {
			const response = await axios.get("/api/chat");
			if (response.status === OK) {
				this.chats = response.data;
				console.log(this.chats);
			}
		},
	},
	async created() {
		await this.showRooms();
	},
};
</script>

<style></style>
