<template>
	<div>
		<v-btn large icon @click="clickDialog">
			<v-icon> mdi-comment-text-multiple</v-icon>
		</v-btn>
		<v-dialog v-model="dialog" width="600" persistent no-click-animation>
			<v-card class="p-3">
				<v-card-title class="pt-0 pl-0 pr-0 justify-space-between">
					<h2 class="cyan--text font-weight-bold mb-0">コメント</h2>
					<v-btn class="mb-3" icon @click="reset">
						<v-icon color="red">mdi-close</v-icon>
					</v-btn>
				</v-card-title>

				<validation-observer ref="observer">
					<v-form>
						<validation-provider
							v-slot="{ errors }"
							name="メッセージ"
							rules="required|max:280"
						>
							<v-textarea
								:error-messages="errors"
								background-color="#f4f8fa"
								placeholder="コメントを入力してください"
								type="text"
								name="message"
								v-model="message"
								required
								outlined
							></v-textarea>
						</validation-provider>
					</v-form>
				</validation-observer>
				<div class="ta-r">
					<v-btn
						@click="postReply"
						class="justify-right"
						color="cyan"
						elevation="0"
						rounded
						dark
					>
						送信する
					</v-btn>
				</div>
			</v-card>
		</v-dialog>
	</div>
</template>

<script>
import { CREATED } from "../../util";
export default {
	data() {
		return {
			dialog: false,
			message: null,
		};
	},
	props: {
		PostId: Number,
	},
	methods: {
		clickDialog() {
			if (!this.$store.getters["auth/check"]) {
				alert("コメント機能を使うにはログインしてください。");
				this.dialog = false;
			} else {
				this.dialog = true;
			}
		},
		async postReply() {
			const isValid = await this.$refs.observer.validate();
			let self = this;
			if (isValid) {
				const response = await axios.post("/api/post/reply", {
					message: this.message,
					id: this.PostId,
				});
				if (response.status === CREATED) {
					self.$store.dispatch("flash/showFlashMessage", {
						show: true,
						message: "コメントしました。",
						type: 0,
						seconds: 3000,
					});
					self.reset();
					self.successReply();
				} else {
					this.$store.commit("error/setCode", response.status);
				}
			}
		},
		// 親のshowPostDetailメソッド発火
		successReply() {
			this.$emit("addShowPostDetail");
		},
		// data初期化メソッド
		reset() {
			this.$refs.observer.reset();
			Object.assign(this.$data, this.$options.data.call(this));
		},
	},
};
</script>
