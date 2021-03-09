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
							<v-icon>mdi-account-details-outline</v-icon>
						</v-list-item-icon>
						<v-list-item-title>相方募集投稿</v-list-item-title>
					</v-list-item>
					<v-list-item to="/post">
						<v-list-item-icon>
							<v-icon>mdi-comment-multiple-outline</v-icon>
						</v-list-item-icon>
						<v-list-item-title>タイムライン</v-list-item-title>
					</v-list-item>
					<v-list-item to="/chat" v-if="isLogin">
						<v-list-item-icon>
							<v-icon>mdi-chat-processing-outline</v-icon>
						</v-list-item-icon>
						<v-list-item-title>チャット</v-list-item-title>
					</v-list-item>
					<v-list-item to="/partner" v-if="isLogin">
						<v-list-item-icon>
							<v-icon>mdi-handshake-outline</v-icon>
						</v-list-item-icon>
						<v-list-item-title>相方申請</v-list-item-title>
					</v-list-item>
					<v-list-item to="/comedy" v-if="isLogin">
						<v-list-item-icon>
							<v-icon>mdi-account-supervisor-circle-outline</v-icon>
						</v-list-item-icon>
						<v-list-item-title>結成したコンビ</v-list-item-title>
					</v-list-item>
					<v-list-item to="/search">
						<v-list-item-icon>
							<v-icon>mdi-magnify</v-icon>
						</v-list-item-icon>
						<v-list-item-title>サイト内検索</v-list-item-title>
					</v-list-item>
					<v-list-item to="/setting" v-if="isLogin">
						<v-list-item-icon>
							<v-icon>mdi-cog-outline</v-icon>
						</v-list-item-icon>
						<v-list-item-title>設定</v-list-item-title>
					</v-list-item>
				</v-list-item-group>
			</v-list>
		</v-navigation-drawer>
		<v-app-bar color="cyan" dark tile fixed elevation="0" height="64">
			<router-link to="/" class="title"><span>Comedy SNS</span></router-link>
			<v-btn
				class="ml-3"
				elevation="0"
				to="/recruit"
				rounded
				outlined
				v-if="!$vuetify.breakpoint.xs && !$vuetify.breakpoint.sm"
				><v-icon>mdi-account-details-outline</v-icon>
				<span>相方募集投稿</span>
			</v-btn>
			<v-btn
				class="ml-1"
				elevation="0"
				to="/post"
				rounded
				outlined
				v-if="!$vuetify.breakpoint.xs && !$vuetify.breakpoint.sm"
				><v-icon>mdi-comment-multiple-outline</v-icon>
				<span>タイムライン</span>
			</v-btn>
			<v-spacer></v-spacer>
			<v-row justify="end">
				<v-col cols="10">
					<v-text-field
						v-model="freeword"
						class="mb-1 mr-1"
						placeholder="サイト内検索"
						background-color="#f4f8fa"
						append-icon="mdi-magnify"
						type="text"
						solo
						hide-details
						light
						@click:append="searchSite"
						v-if="!$vuetify.breakpoint.xs"
					>
					</v-text-field>
				</v-col>
			</v-row>
			<Notification v-if="isLogin"></Notification>
			<div class="text-center" v-if="isLogin">
				<v-menu offset-y>
					<template v-slot:activator="{ on, attrs }">
						<v-btn v-bind="attrs" icon v-on="on">
							<Avatar
								:size="35"
								:thumbnail="isUserInfo.thumbnail"
								:url="isUserInfo.thumbnail_url"
							></Avatar>
						</v-btn>
					</template>
					<v-list class="p-0">
						<v-list-item :to="`/profile/${this.isLoginUserId}`" v-if="isLogin">
							<v-list-item-icon>
								<v-icon>mdi-account-circle-outline</v-icon>
							</v-list-item-icon>
							<v-list-item-title>マイページ</v-list-item-title>
						</v-list-item>
						<v-list-item v-if="isLogin" @click="logout()">
							<v-list-item-icon>
								<v-icon>mdi-logout-variant</v-icon>
							</v-list-item-icon>
							<v-list-item-title>ログアウト</v-list-item-title>
						</v-list-item>
					</v-list>
				</v-menu>
			</div>
			<div class="header-btn mr-1 ml-1" v-if="!isLogin">
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
			<v-app-bar-nav-icon
				class="ml-1"
				@click="drawer = true"
			></v-app-bar-nav-icon>
		</v-app-bar>
	</div>
</template>
<script>
import Notification from "../component/Notification.vue";
import Avatar from "../elements/Avatar.vue";
export default {
	data() {
		return {
			drawer: false,
			group: null,
			freeword: "",
		};
	},
	components: {
		Notification,
		Avatar,
	},
	methods: {
		async logout() {
			await this.$store.dispatch("auth/logout");
			if (this.status) {
				this.$router.push("/login");
			}
		},
		searchSite() {
			this.$router
				.push({
					name: "search",
					query: {
						freeword: this.freeword,
					},
				})
				.catch((err) => {});
		},
	},
	computed: {
		isLogin() {
			return this.$store.getters["auth/check"];
		},
		isLoginUserId() {
			return this.$store.getters["auth/userId"];
		},
		isUserInfo() {
			return this.$store.getters["auth/userInfo"];
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
