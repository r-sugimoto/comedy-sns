<template>
	<v-row>
		<v-col>
			<v-card class="mx-auto auth-form" max-width="480" elevation="0" tile>
				<v-card-title class="justify-center mt-2 mb-5 title--border">
					<h1 class="cyan--text font-weight-bold mb-0">ログイン</h1>
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
								v-model="loginForm.email"
								:rules="emailRules"
								required
								outlined
							/>
						</validation-provider>
						<validation-provider
							v-slot="{ errors }"
							name="パスワード"
							rules="required"
						>
							<p class="input-label">パスワード</p>
							<v-text-field
								:error-messages="errors"
								:append-icon="showPassword1 ? 'mdi-eye' : 'mdi-eye-off'"
								:type="showPassword1 ? 'text' : 'password'"
								@click:append="showPassword1 = !showPassword1"
								background-color="#f4f8fa"
								y
								placeholder="password"
								name="password"
								v-model="loginForm.password"
								:rules="passwordRules"
								required
								outlined
							/>
						</validation-provider>
						<!-- <v-checkbox
					v-model="loginForm.remember"
					label="ログインしたままにする"
					name="remember"
					class="mb-0"
				></v-checkbox> -->
						<v-btn
							@click="login"
							class="mt-2"
							color="cyan"
							elevation="0"
							large
							rounded
							block
						>
							<span class="white--text">ログイン</span>
						</v-btn>
					</v-form>
				</validation-observer>
				<div class="mt-5 text-center">
					<router-link to="/register" class="cyan--text">
						アカウントをお持ちではない方はこちら
					</router-link>
				</div>
			</v-card>
		</v-col>
	</v-row>
</template>

<script>
export default {
	data() {
		return {
			showPassword1: false,
			emailRules: [],
			passwordRules: [],
			serverError: {
				message: "",
				show: false,
			},
			loginForm: {
				email: "",
				password: "",
				remember: false,
			},
		};
	},
	methods: {
		async login() {
			this.clearError();
			const isValid = await this.$refs.observer.validate();
			if (isValid) {
				await this.$store.dispatch("auth/authLogin", {
					data: this.loginForm,
				});
				if (this.status) {
					this.$router.push("/dashboard");
				} else {
					if (this.errorMessages !== null) {
						this.emailRules = this.errorMessages.email;
						this.passwordRules = this.errorMessages.password;
					}
				}
			}
		},
		clearError() {
			this.$store.commit("auth/setAuthErrorMessages", null);
		},
	},
	computed: {
		errorMessages() {
			return this.$store.getters["auth/getAuthErrorMessages"];
		},
		status() {
			return this.$store.getters["auth/getAuthStatus"];
		},
	},
	created() {
		this.clearError();
	},
};
</script>

<style>
label {
	margin-bottom: 0 !important;
}
</style>
