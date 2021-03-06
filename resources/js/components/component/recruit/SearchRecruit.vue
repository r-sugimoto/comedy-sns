<template>
	<v-card class="p-2" :class="{ 'mb-5': !isLogin }" tile elevation="0">
		<v-card-title>
			<p class="font-weight-bold cyan--text mb-0">相方募集検索</p>
		</v-card-title>
		<validation-observer ref="observer">
			<v-form>
				<v-row>
					<v-col cols="12" sm="6" md="12" lg="12" xl="12" class="pb-0 pt-0"
						><p class="input-label">エリア</p>
						<v-select
							v-model="regionId"
							:items="regions"
							item-text="name"
							item-value="id"
							placeholder="選択してください"
							background-color="#f4f8fa"
							outlined
							clearable
						>
						</v-select
					></v-col>
					<v-col cols="12" sm="6" md="12" lg="12" xl="12" class="pb-0 pt-0">
						<p class="input-label">都道府県</p>
						<v-select
							v-model="prefectureId"
							:items="prefectures"
							item-text="name"
							item-value="id"
							placeholder="選択してください"
							background-color="#f4f8fa"
							outlined
							clearable
						>
						</v-select
					></v-col>
					<v-col class="pb-0 pt-0" cols="12" sm="6" md="12" lg="12" xl="12">
						<p class="input-label">年代</p>
						<v-select
							v-model="generationId"
							:items="generations"
							item-text="name"
							item-value="id"
							placeholder="選択してください"
							background-color="#f4f8fa"
							outlined
							clearable
						>
						</v-select>
					</v-col>
				</v-row>
				<v-row align="center">
					<v-col class="pb-0 pt-0" cols="12" sm="6" md="12" lg="12" xl="12">
						<validation-provider
							v-slot="{ errors }"
							name="フリーワード"
							rules="max:80"
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
			regions: [],
			regionId: "",
			prefectures: [],
			prefectureId: "",
			generations: [],
			generationId: "",
		};
	},
	methods: {
		async searchPost() {
			if (this.freeword === null) {
				this.freeword = "";
			}
			if (this.regionId === null) {
				this.regionId = "";
			}
			if (this.prefectureId === null) {
				this.prefectureId = "";
			}
			if (this.generationId === null) {
				this.generationId = "";
			}
			const isValid = await this.$refs.observer.validate();
			if (isValid) {
				// 選択されていない場合、リセットする
				if (this.items.length === 0) {
					this.clearTag;
				}
				this.$router
					.push({
						name: "recruit",
						query: {
							freeword: this.freeword,
							tag: this.id,
							region: this.regionId,
							prefecture: this.prefectureId,
							generation: this.generationId,
						},
					})
					.catch((err) => {});
			}
		},
		// タグ検索
		async searchTag(flg) {
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
		// 都道府県取得
		async getPrefectures() {
			const response = await axios.get("/api/prefecture");
			if (response.status === OK) {
				this.prefectures = response.data;
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
		// 地域取得
		async getRegions() {
			const response = await axios.get("/api/region");
			if (response.status === OK) {
				this.regions = response.data;
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
		// 世代一覧取得
		async getGenerations() {
			const response = await axios.get("/api/generation");
			if (response.status === OK) {
				this.generations = response.data;
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
		// getパラメーター取得
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
			if (route.query.prefecture !== undefined) {
				let pre = route.query.prefecture;
				this.prefectureId = /^[1-9][0-9]*$/.test(pre) ? pre * 1 : "";
			} else {
				this.prefectureId = "";
			}
			if (route.query.region !== undefined) {
				let region = route.query.region;
				this.regionId = /^[1-9][0-9]*$/.test(region) ? region * 1 : "";
			} else {
				this.regionId = "";
			}
			if (route.query.generation !== undefined) {
				let generation = route.query.generation;
				this.generationId = /^[1-9][0-9]*$/.test(generation)
					? generation * 1
					: "";
			} else {
				this.generationId = "";
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
		await this.getRegions();
		await this.getPrefectures();
		await this.getGenerations();
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
