<template>
	<v-dialog fullscreen v-model="dialog">
		<v-card class="mx-auto" elevation="0" tile>
			<v-card-title class="pb-0 pl-2 pr-2 cyan--text">
				<v-btn text color="cyan" @click="routeBack" class="pl-3 mr-2">
					<v-icon>mdi-chevron-left</v-icon>
					<span>戻る</span>
				</v-btn>
				<Avatar
					:size="50"
					:thumbnail="user.thumbnail"
					:url="user.thumbnail_url"
					class="mr-3"
				></Avatar>
				<span class="va-m">
					{{ user.name }}
				</span>
			</v-card-title>
			<v-divider></v-divider>
			<v-card-text class="p-0"
				><v-row class="p-0 m-0">
					<v-col cols="12" class="p-0">
						<v-container
							ref="scrollTarget"
							style="height: calc(100vh - 220px)"
							class="overflow-y-auto"
						>
							<v-row v-for="(msg, i) in messages" :key="i" dense>
								<v-col v-if="msg.user.id !== isLoginUserId">
									<div class="msg_left" v-if="msg.partner_id === null">
										<div class="icon">
											<Avatar
												:size="40"
												:thumbnail="msg.user.thumbnail"
												:url="msg.user.thumbnail_url"
											></Avatar>
										</div>
										<p class="msg">
											{{ msg.message }}
										</p>
									</div>
									<div
										class="msg_left"
										v-if="
											msg.partner_id !== null &&
											msg.partner.user_id !== isLoginUserId
										"
									>
										<div class="icon">
											<Avatar
												:size="40"
												:thumbnail="msg.user.thumbnail"
												:url="msg.user.thumbnail_url"
											></Avatar>
										</div>
										<ApplyChat
											@emitShowMessages="showMessages"
											:msg="msg"
										></ApplyChat>
									</div>
								</v-col>
								<v-col v-else>
									<div class="msg_right">
										<p class="msg" v-if="msg.partner_id === null">
											{{ msg.message }}
										</p>
										<p class="msg" v-else>
											【送信した相方申請メッセージ】
											<br />
											{{ msg.message }}
											<router-link to="/partner">
												<br />【詳しく見る】
											</router-link>
										</p>
									</div>
								</v-col>
							</v-row>
						</v-container>
					</v-col>
				</v-row>
			</v-card-text>
			<v-divider></v-divider>
			<v-card-text class="pb-0">
				<validation-observer ref="observer">
					<v-form>
						<validation-provider
							v-slot="{ errors }"
							name="メッセージ"
							rules="required|max:50"
						>
							<v-text-field
								@click:append="submitMessage"
								append-icon="mdi-send"
								:error-messages="errors"
								background-color="#f4f8fa"
								type="message"
								name="message"
								v-model="message"
								required
								outlined
							/>
						</validation-provider>
					</v-form>
				</validation-observer>
			</v-card-text>
		</v-card>
	</v-dialog>
</template>

<script>
import { OK, CREATED } from "../../util";
import ApplyChat from "../component/chat/ApplyChat.vue";
import Avatar from "../elements/Avatar.vue";
export default {
	data() {
		return {
			dialog: true,
			user: [],
			messages: [],
			message: "",
		};
	},
	components: {
		ApplyChat,
		Avatar,
	},
	props: {
		id: {
			type: [String, Number],
		},
	},
	updated() {
		this.scrollEnd();
	},
	methods: {
		routeBack() {
			this.$router.push({
				name: "chat",
			});
		},
		async submitMessage() {
			const isValid = await this.$refs.observer.validate();
			if (isValid) {
				const response = await axios.post("/api/chat/message/new", {
					message: this.message,
					room_id: this.id,
					to_user_id: this.user.id,
				});
				if (response.status === CREATED) {
					this.message = "";
					this.$refs.observer.reset();
					await this.showMessages();
				} else {
					this.$store.commit("error/setCode", response.status);
				}
			}
		},
		async showMessages() {
			const response = await axios.get(`/api/chat/${this.id}`);
			if (response.status === OK) {
				this.messages = response.data;
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
		async noticeMessage() {
			const response = await axios.get(`/api/chat/notice/${this.id}`);
			if (response.status !== OK) {
				this.$store.commit("error/setCode", response.status);
			}
		},
		async showInfo() {
			const response = await axios.get(`/api/chat/info/${this.id}`);
			if (response.status === OK) {
				this.user = response.data.users[0];
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
		scrollEnd() {
			this.$nextTick(() => {
				const Log = this.$refs.scrollTarget;
				if (!Log) {
					return false;
				} else {
					Log.scrollTop = Log.scrollHeight;
				}
			});
		},
	},
	computed: {
		isLoginUserId() {
			return this.$store.getters["auth/userId"];
		},
	},
	async created() {
		await this.showMessages();
		await this.noticeMessage();
		await this.showInfo();
	},
};
</script>

<style></style>
