<template>
	<v-row>
		<v-col>
			<v-card class="mx-auto auth-form" max-width="480" elevation="0" tile>
				<v-card-title class="justify-center mt-2 mb-5 title--border">
					<h2 class="cyan--text font-weight-bold mb-0">新規会員登録</h2>
				</v-card-title>
				<validation-observer ref="observer">
					<v-form>
						<validation-provider
							v-slot="{ errors }"
							name="ユーザー名"
							rules="required|max:20"
						>
							<p class="input-label">ユーザ名</p>
							<v-text-field
								:error-messages="errors"
								background-color="#f4f8fa"
								placeholder="コメディ太郎"
								type="text"
								name="name"
								v-model="registerForm.name"
								:rules="nameRules"
								required
								outlined
							/>
						</validation-provider>
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
								v-model="registerForm.email"
								:rules="emailRules"
								required
								outlined
							/>
						</validation-provider>
						<validation-provider
							v-slot="{ errors }"
							name="パスワード"
							rules="required|min:8|confirmed:password_confirmation"
						>
							<p class="input-label">パスワード</p>
							<v-text-field
								:error-messages="errors"
								:append-icon="showPassword1 ? 'mdi-eye' : 'mdi-eye-off'"
								:type="showPassword1 ? 'text' : 'password'"
								@click:append="showPassword1 = !showPassword1"
								background-color="#f4f8fa"
								placeholder="password"
								name="password"
								v-model="registerForm.password"
								:rules="passwordRules"
								required
								outlined
							/>
						</validation-provider>
						<validation-provider
							v-slot="{ errors }"
							vid="password_confirmation"
							name="確認用パスワード"
							rules="required|min:8"
						>
							<p class="input-label">確認用パスワード</p>
							<v-text-field
								:error-messages="errors"
								:append-icon="showPassword2 ? 'mdi-eye' : 'mdi-eye-off'"
								:type="showPassword2 ? 'text' : 'password'"
								@click:append="showPassword2 = !showPassword2"
								background-color="#f4f8fa"
								placeholder="上と同じパスワードを入力してください"
								name="password_confirmation"
								v-model="registerForm.password_confirmation"
								required
								outlined
							/>
						</validation-provider>
						<v-btn
							@click="register"
							class="mt-2"
							color="cyan"
							elevation="0"
							large
							:loading="loading"
							rounded
							block
						>
							<span class="white--text">登録</span>
						</v-btn>
					</v-form>
				</validation-observer>
				<div class="mt-5 cyan--text text-center">
					<router-link to="/login" class="cyan--text">
						すでに登録の方はこちら
					</router-link>
				</div>
			</v-card>
		</v-col>
	</v-row>
</template>

<script>
export default {
	name: "register",
	data() {
		return {
			loading: false,
			showPassword1: false,
			showPassword2: false,
			nameRules: [],
			emailRules: [],
			passwordRules: [],
			registerForm: {
				name: "",
				email: "",
				password: "",
				password_confirmation: "",
			},
		};
	},
	methods: {
		async register() {
			this.clearError();
			const isValid = await this.$refs.observer.validate();
			if (isValid) {
				this.loading = true;
				await this.$store.dispatch("auth/authRegister", {
					data: this.registerForm,
				});
				if (this.status) {
					this.$router.push("/register/mail");
				} else {
					if (this.errorMessages !== null) {
						this.loading = false;
						this.nameRules = this.errorMessages.name;
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
};
</script>

<style>
.v-progress-circular {
	color: white;
}
</style>
