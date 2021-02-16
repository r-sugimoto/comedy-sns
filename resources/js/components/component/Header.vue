<template>
	<div>
		<v-navigation-drawer v-model="drawer" fixed temporary>
			<v-list nav dense>
				<v-list-item-group v-model="group">
					<v-list-item to="/login" v-if="!isLogin">
						<v-list-item-icon>
							<v-icon>mdi-login-variant</v-icon>
						</v-list-item-icon>
						<v-list-item-title>ログイン</v-list-item-title>
					</v-list-item>
					<v-list-item to="/register" v-if="!isLogin">
						<v-list-item-icon>
							<v-icon>mdi-account-check</v-icon>
						</v-list-item-icon>
						<v-list-item-title>新規会員登録</v-list-item-title>
					</v-list-item>

					<v-list-item to="/recruit">
						<v-list-item-icon>
							<v-icon>mdi-handshake-outline</v-icon>
						</v-list-item-icon>
						<v-list-item-title>相方募集一覧</v-list-item-title>
					</v-list-item>
					<v-list-item to="/post">
						<v-list-item-icon>
							<v-icon>mdi-newspaper-variant</v-icon>
						</v-list-item-icon>
						<v-list-item-title>投稿一覧</v-list-item-title>
					</v-list-item>
					<v-list-item :to="`/profile/${this.isLoginUserId}`" v-if="isLogin">
						<v-list-item-icon>
							<v-icon>mdi-account-circle</v-icon>
						</v-list-item-icon>
						<v-list-item-title>プロフィール</v-list-item-title>
					</v-list-item>
					<v-list-item to="/setting" v-if="isLogin">
						<v-list-item-icon>
							<v-icon>mdi-cog-outline</v-icon>
						</v-list-item-icon>
						<v-list-item-title>設定</v-list-item-title>
					</v-list-item>
					<v-list-item v-if="isLogin" @click="logout()">
						<v-list-item-icon>
							<v-icon>mdi-logout-variant</v-icon>
						</v-list-item-icon>
						<v-list-item-title>ログアウト</v-list-item-title>
					</v-list-item>
				</v-list-item-group>
			</v-list>
		</v-navigation-drawer>
		<v-app-bar color="cyan" dark tile fixed elevation="0">
			<v-toolbar-title>
				<router-link to="/" class="title"><span>Comedy SNS</span></router-link>
			</v-toolbar-title>
			<v-spacer></v-spacer>
			<div class="header-btn mr-1" v-if="!isLogin">
				<router-link to="/login">ログイン</router-link>
			</div>
			<v-btn
				elevation="0"
				color="light-green"
				v-if="!isLogin"
				:small="$vuetify.breakpoint.xs"
				to="/register"
				rounded
			>
				<span>登録</span>
			</v-btn>
			<v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>
		</v-app-bar>
	</div>
</template>
<script>
export default {
	data() {
		return {
			drawer: false,
			group: null,
		};
	},
	methods: {
		async logout() {
			await this.$store.dispatch("auth/logout");
			if (this.status) {
				this.$router.push("/login");
			}
		},
	},
	computed: {
		isLogin() {
			return this.$store.getters["auth/check"];
		},
		isLoginUserId() {
			return this.$store.getters["auth/userId"];
		},
		username() {
			return this.$store.getters["auth/username"];
		},
		status() {
			return this.$store.getters["auth/getAuthStatus"];
		},
	},
};
</script>

<style scoped>
.title {
	text-decoration: none;
	color: #fff;
}
.header-btn {
	height: 36px;
	min-width: 64px;
	text-align: center;
}
.header-btn a {
	display: block;
	line-height: 36px;
	text-decoration: none;
	color: #fff;
}
</style>
