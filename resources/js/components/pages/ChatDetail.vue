<template>
	<v-dialog fullscreen v-model="dialog">
		<v-card class="mx-auto" elevation="0" tile>
			<v-card-title class="pb-0 cyan--text font-weight-bold">
				<v-btn text color="cyan" @click="routeBack" class="pl-1 mr-3">
					<v-icon>mdi-chevron-left</v-icon>
					<span>戻る</span>
				</v-btn>
				{{ title }}
			</v-card-title>
			<v-divider></v-divider>
			<v-card-text class="p-0"
				><v-row class="p-0 m-0">
					<v-col cols="12" class="p-0">
						<v-container
							ref="scrollTarget"
							style="height: calc(100vh - 205px)"
							class="overflow-y-auto"
						>
							<v-row v-for="(msg, i) in messages" :key="i" dense>
								<v-col v-if="msg.user.id != isLoginUserId">
									<div class="msg_left">
										<div class="icon">
											<v-avatar size="50" color="gray">
												<v-img :src="msg.user.thumbnail_url"></v-img>
											</v-avatar>
										</div>
										<p class="msg">
											{{ msg.message }}
										</p>
									</div>
								</v-col>
								<v-col v-else>
									<div class="msg_right">
										<p class="msg">
											{{ msg.message }}
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
export default {
	data() {
		return {
			dialog: true,
			title: "",
			messages: [],
			message: "",
		};
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
				});
				if (response.status === CREATED) {
					this.message = "";
					this.$refs.observer.reset();
					await this.showMessages();
				}
			}
		},
		async showMessages() {
			const response = await axios.get(`/api/chat/${this.id}`);
			if (response.status === OK) {
				this.messages = response.data;
			}
		},
		async showInfo() {
			const response = await axios.get(`/api/chat/info/${this.id}`);
			if (response.status === OK) {
				this.title = response.data.users[0].name;
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
		await this.showInfo();
	},
};
</script>

<style>
.msg_left,
.msg_right {
	margin: 10px 0;
	display: flex;
	justify-content: flex-start;
	align-items: flex-start;
}
.msg_right {
	justify-content: flex-end;
	margin-right: 25px;
}
.msg_left .icon {
	margin-right: 25px;
}
.msg {
	max-width: 95%;
	position: relative;
	padding: 10px;
	border-radius: 12px;
	background: #8ee7b6;
	box-sizing: border-box;
	margin: 0 !important;
	line-height: 1.5;
}
.msg p {
	margin: 8px 0 0 !important;
}
.msg p:first-child {
	margin-top: 0 !important;
}
.msg:after {
	content: "";
	position: absolute;
	border: 10px solid transparent;
	margin-top: -3px;
}
.msg_left .msg:after {
	left: -26px;
	border-right: 22px solid #8ee7b6;
}
.msg_right .msg:after {
	right: -26px;
	border-left: 22px solid #8ee7b6;
}
</style>
