<template>
	<v-card class="p-3" elevation="0" tile>
		<v-card-title class="justify-center mt-2 mb-5">
			<h2 class="cyan--text font-weight-bold mb-0">メールアドレス設定</h2>
		</v-card-title>
		<validation-observer ref="observer">
			<v-form>
				<validation-provider
					v-slot="{ errors }"
					name="メールアドレス"
					rules="required|max:255|email"
				>
					<p class="input-label">メールアドレス</p>
					<v-text-field
						:error-messages="errors"
						background-color="#f4f8fa"
						placeholder="test@test.com"
						type="text"
						name="email"
						v-model="email"
						:rules="emailRules"
						required
						outlined
					/>
				</validation-provider>
				<div class="text-right">
					<v-btn
						@click="changeEmail"
						class="mt-2"
						color="cyan"
						elevation="0"
						large
						rounded
						:loading="loading"
					>
						<span class="white--text">変更する</span>
					</v-btn>
				</div>
			</v-form>
		</validation-observer>
	</v-card>
</template>

<script>
import { OK, CREATED } from "../../../util";
export default {
	data() {
		return {
			emailRules: [],
			email: "",
			loading: false,
		};
	},
	methods: {
		async getEmail() {
			const { status, data } = await axios.get("/api/user/mail/setting");
			if (status === OK) {
				if (data.email !== null) {
					this.email = data.email;
				}
			} else {
				this.$store.commit("error/setCode", status);
			}
			this.loading = false;
		},
		async changeEmail() {
			const isValid = await this.$refs.observer.validate();
			if (isValid) {
				this.loading = true;
				const { status } = await axios.post("/api/user/mail/setting", {
					email: this.email,
				});
				if (status === CREATED) {
					this.$router.push("/setting/mail");
				} else {
					this.$store.commit("error/setCode", status);
				}
				this.loading = false;
			}
		},
	},
	created() {
		this.getEmail();
	},
};
</script>

<style></style>
