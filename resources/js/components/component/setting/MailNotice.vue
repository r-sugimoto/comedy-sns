<template>
	<v-card class="p-3" elevation="0" tile>
		<v-card-title class="justify-center mt-2 mb-5">
			<h2 class="cyan--text font-weight-bold mb-0">メール通知設定</h2>
		</v-card-title>
		<v-form>
			<v-switch
				v-model="mailNotice"
				inset
				color="success"
				label="メールで通知を受け取る"
				@click="postMailNotice"
			></v-switch>
			<v-card elevation="0" tile v-if="mailNotice === true">
				<v-card-text class="m-0 p-0 mb-2 font-weight-bold"
					>詳細設定</v-card-text
				>
				<v-switch
					v-model="comment"
					inset
					class="m-0 p-0"
					color="success"
					label="コメント"
					@click="postMailNotice"
				></v-switch>
				<v-switch
					v-model="message"
					inset
					class="m-0 p-0"
					color="success"
					label="ダイレクトメッセージ"
					@click="postMailNotice"
				></v-switch>
				<v-switch
					v-model="partner"
					inset
					class="m-0 p-0"
					color="success"
					label="相方申請"
					@click="postMailNotice"
				></v-switch>
			</v-card>
		</v-form>
	</v-card>
</template>

<script>
import { OK, CREATED } from "../../../util";
export default {
	data() {
		return {
			mailNotice: false,
			comment: true,
			message: true,
			partner: true,
		};
	},
	methods: {
		async getMailNotice() {
			const { status, data } = await axios.get("/api/user/mail/notice");
			if (status === OK) {
				if (data.length !== 0) {
					console.log(data);
					if (data.mail_notice_flg === 0) {
						this.mailNotice = false;
					} else {
						this.mailNotice = true;
					}
					if (data.comment_flg === 0) {
						this.comment = false;
					} else {
						this.comment = true;
					}
					if (data.message_flg === 0) {
						this.message = false;
					} else {
						this.message = true;
					}
					if (data.partner_flg === 0) {
						this.partner = false;
					} else {
						this.partner = true;
					}
				}
			} else {
				this.$store.commit("error/setCode", status);
			}
		},
		async postMailNotice() {
			const { status, data } = await axios.post("/api/user/mail/notice", {
				mail_notice: this.mailNotice,
				comment: this.comment,
				message: this.message,
				partner: this.partner,
			});
			if (status === OK) {
				if (data === 404) {
					this.mailNotice = false;
					this.$store.dispatch("flash/showFlashMessage", {
						show: true,
						message: "メールアドレスが設定されていません。",
						type: 1,
						seconds: 3000,
					});
				}
			} else {
				this.$store.commit("error/setCode", status);
			}
		},
	},
	created() {
		this.getMailNotice();
	},
};
</script>

<style></style>
