<template>
	<v-card class="p-2" :class="{ 'mb-5': !isLogin }" tile elevation="0">
		<v-card-title>
			<p class="font-weight-bold mb-0 cyan--text">タイムライン検索</p>
		</v-card-title>
		<validation-observer ref="observer">
			<v-form>
				<v-row align="center">
					<v-col class="pb-0 pt-0" cols="12" sm="6" md="12" lg="12" xl="12">
						<validation-provider
							v-slot="{ errors }"
							name="フリーワード"
							rules="max:50"
						>
							<p class="input-label">フリーワード</p>
							<v-text-field
								:error-messages="errors"
								background-color="#f4f8fa"
								type="text"
								placeholder="フリーワードを入力してください"
								v-model="freeword"
								clearable
								outlined
							>
							</v-text-field>
						</validation-provider>
					</v-col>
					<v-col class="pb-0 pt-0" cols="12" sm="6" md="12" lg="12" xl="12">
						<p class="input-label">タグ</p>
						<v-autocomplete
							v-model="name"
							background-color="#f4f8fa"
							:items="items"
							:search-input.sync="search"
							placeholder="タグ名を入力してください"
							:cache-items="false"
							:hide-no-data="true"
							append-icon=""
							outlined
							clearable
							@click:clear="clearTag"
							append-outer-icon="mdi-magnify"
							@click:append-outer="searchPost"
						></v-autocomplete>
					</v-col>
				</v-row>
			</v-form>
		</validation-observer>
	</v-card>
</template>

<script>
import { OK } from "../../../util";
export default {
	data() {
		return {
			errors: "",
			name: "",
			id: "",
			freeword: "",
			items: [],
			value: "",
			search: null,
		};
	},
	methods: {
		async searchPost() {
			const isValid = await this.$refs.observer.validate();
			if (isValid) {
				if (this.freeword === null) {
					this.freeword = "";
				}
				// 選択されていない場合、リセットする
				if (this.items.length === 0) {
					this.clearTag;
				}
				this.$router
					.push({
						name: "post",
						query: { freeword: this.freeword, tag: this.id },
					})
					.catch((err) => {});
			}
		},
		async searchTag(flg) {
			// タグ検索
			const response = await axios.post("/api/tag/search", {
				id: this.id,
				name: this.value,
			});
			this.items.splice(0, this.items.length);
			if (response.status === OK) {
				if (response.data.length !== 0) {
					response.data.forEach((tags) => {
						this.items.push(tags.name);
						if (flg === 1) {
							if (this.id === tags.id) {
								this.name = tags.name;
								this.id = tags.id;
							}
						} else if (flg === 2) {
							if (this.value === tags.name) {
								this.name = tags.name;
								this.id = tags.id;
							}
						}
					});
				} else {
					this.id = "";
				}
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
		async checkRoute(route) {
			if (route.query.freeword !== undefined) {
				this.freeword = route.query.freeword;
			} else {
				this.freeword = "";
			}
			if (route.query.tag !== undefined) {
				let tag = route.query.tag;
				this.id = /^[1-9][0-9]*$/.test(tag) ? tag * 1 : "";
			} else {
				this.id = "";
			}
			this.value = "";
			await this.searchTag(1);
		},
		clearTag() {
			this.items.splice(0, this.items.length);
			this.name = "";
			this.id = "";
		},
	},
	computed: {
		isLogin() {
			return this.$store.getters["auth/check"];
		},
	},
	watch: {
		// タグ検索機能
		async search(val) {
			let self = this;
			self.value = val;
			if (self.value === "") {
				this.items.splice(0, this.items.length);
				this.id = "";
			}
			await this.searchTag(2);
		},
		// パスが変更された時
		async $route(to, from) {
			await this.checkRoute(to);
		},
	},
	// 初期表示
	async created() {
		await this.checkRoute(this.$route);
	},
};
</script>

<style>
.v-card__title {
	padding: 0;
	padding-bottom: 10px;
}

.v-application--is-ltr .v-input__append-outer {
	margin-left: 10px;
	margin-right: 10px;
}
</style>
