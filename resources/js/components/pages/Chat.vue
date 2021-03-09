<template>
	<v-row align="center" justify="center">
		<v-col class="pb-0" cols="12" md="8" lg="8" xl="8">
			<v-card elevation="0" tile class="p-3">
				<v-card-title class="justify-center mb-5">
					<h2 class="cyan--text font-weight-bold mb-0">チャット一覧</h2>
				</v-card-title>
				<v-card
					v-for="chat in chats"
					:key="`chats-${chat.id}`"
					:to="`/chat/${chat.id}`"
					class="mb-4 text-decoration-none"
					elevation="0"
					tile
					style="border: double 5px #80deea"
				>
					<v-card-actions v-if="chat.name === null">
						<Avatar
							:size="50"
							:thumbnail="chat.users[0].thumbnail"
							:url="chat.users[0].thumbnail_url"
							class="mr-1"
						></Avatar>
						<span class="ml-3 va-m">{{ chat.users[0].name }} </span>
						<v-spacer></v-spacer>
						<v-btn color="cyan" x-large icon>
							<v-icon>mdi-chat-processing-outline</v-icon>
						</v-btn>
					</v-card-actions>
				</v-card>
				<v-card-text class="p-0" v-if="message !== ''">{{
					message
				}}</v-card-text>
			</v-card>
		</v-col>
	</v-row>
</template>

<script>
import Avatar from "../elements/Avatar.vue";
import { OK } from "../../util";
export default {
	data() {
		return {
			chats: [],
			message: "",
		};
	},
	components: {
		Avatar,
	},
	methods: {
		async showRooms() {
			const response = await axios.get("/api/chat");
			if (response.status === OK) {
				this.chats = response.data;
				if (this.chats.length === 0) {
					this.message = "チャットが見つかりませんでした。";
				}
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
	},
	async created() {
		await this.showRooms();
	},
};
</script>

<style></style>
