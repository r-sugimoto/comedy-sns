<template>
	<v-card class="p-3" elevation="0" tile>
		<v-card-title class="justify-center mt-2 mb-5">
			<h2 class="cyan--text font-weight-bold mb-0">退会</h2>
		</v-card-title>
		<validation-observer ref="unsubscribeObserver">
			<v-form>
				<validation-provider
					v-slot="{ errors }"
					name="退会理由"
					rules="max:280"
				>
					<p class="input-label">退会理由（任意）</p>
					<v-textarea
						:error-messages="errors"
						background-color="#f4f8fa"
						type="text"
						name="reason"
						v-model="unsubscribeForm.reason"
						required
						outlined
					></v-textarea>
				</validation-provider>
				<div class="text-right">
					<v-btn
						@click="postUnsubscribe"
						:loading="btnLoading"
						color="red"
						elevation="0"
						large
						rounded
						dark
					>
						<span>退会する</span>
					</v-btn>
				</div>
			</v-form>
		</validation-observer>
	</v-card>
</template>

<script>
export default {
	data() {
		return {
			btnLoading: false,
			unsubscribeForm: {
				reason: "",
			},
		};
	},
	methods: {
		//退会
		async postUnsubscribe() {
			if (this.isLoginUserId === 1) {
				this.$store.dispatch("flash/showFlashMessage", {
					show: true,
					message: "ゲストユーザーは退会できません。",
					type: 1,
					seconds: 5000,
				});
			} else {
				const isValid = await this.$refs.unsubscribeObserver.validate();
				if (isValid) {
					if (confirm("本当に退会しますか？")) {
						this.btnLoading = true;
						const { status } = await axios.post("/api/user/unsubscribe", {
							reason: this.unsubscribeForm.reason,
						});
						if (status === OK) {
							this.$store.dispatch("flash/showFlashMessage", {
								show: true,
								message: "退会完了しました。",
								type: 0,
								seconds: 5000,
							});
							this.$router.go({
								path: "/",
								force: true,
							});
						} else {
							this.$store.commit("error/setCode", status);
						}
						this.btnLoading = false;
					}
				}
			}
		},
	},
	computed: {
		isLoginUserId() {
			return this.$store.getters["auth/userId"];
		},
	},
};
</script>

<style></style>
