<template>
	<v-dialog
		v-model="dialog"
		max-width="1000"
		:fullscreen="$vuetify.breakpoint.xsOnly"
		persistent
		no-click-animation
	>
		<template v-slot:activator="{ on, attrs }">
			<v-layout column class="fab-container">
				<v-btn
					fab
					large
					dark
					color="cyan"
					v-bind="attrs"
					v-if="!dialog"
					v-on="on"
				>
					<v-icon dark> mdi-pencil </v-icon>
				</v-btn>
			</v-layout>
		</template>
		<v-card class="p-3" elevation="0" tile>
			<div class="text-right">
				<v-btn icon @click="closeForm">
					<v-icon color="red">mdi-close</v-icon>
				</v-btn>
			</div>
			<validation-observer ref="observer">
				<v-form>
					<validation-provider
						v-slot="{ errors }"
						name="タイトル"
						rules="required|max:50"
					>
						<p class="input-label">タイトル</p>
						<v-text-field
							:error-messages="errors"
							background-color="#f4f8fa"
							placeholder="タイトルを入力してください"
							type="text"
							name="title"
							v-model="newPostForm.title"
							required
							outlined
						></v-text-field>
					</validation-provider>
					<validation-provider
						v-slot="{ errors }"
						name="メッセージ"
						rules="required|max:280"
					>
						<p class="input-label">メッセージ</p>
						<v-textarea
							:error-messages="errors"
							background-color="#f4f8fa"
							placeholder="メッセージを入力してください"
							type="text"
							name="message"
							v-model="newPostForm.message"
							required
							outlined
						></v-textarea>
					</validation-provider>
					<p class="input-label">タグ</p>
					<vue-tags-input
						placeholder="タグを5個まで入力できます"
						v-model="tag"
						:tags="newPostForm.tags"
						@tags-changed="(newTags) => (newPostForm.tags = newTags)"
						@before-adding-tag="checkTag"
					/>
					<div class="v-messages__message error--text tag-error-text">
						{{ tagError }}
					</div>
					<v-row class="m-0 p-0">
						<v-col cols="12" sm="6" md="6" lg="12" xl="12" class="p-0">
						<p class="input-label">エリア</p>
							<v-select
								v-model="regionId"
								:items="regions"
								item-text="name"
								item-value="id"
								placeholder="選択してください"
								background-color="#f4f8fa"
								@change="searchPrefectures"
								outlined
								clearable
								>
							</v-select>
						</v-col>
						<v-col cols="12" sm="6" md="6" lg="12" xl="12" class="p-0">
									<p class="input-label">都道府県</p>
									<v-select
										v-model="newPostForm.prefectureId"
										:items="prefectures"
										item-text="name"
										item-value="id"
										placeholder=""
										background-color="#f4f8fa"
										:disabled="preDisabled"
										outlined
										clearable
									>
									</v-select>
						</v-col>
						<v-col class="p-0" cols="12" sm="6" md="6" lg="12" xl="12">
							<p class="input-label">年代</p>
							<v-select
								v-model="newPostForm.generationId"
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
					<v-tabs
						background-color="cyan"
						dark
						:show-arrows="$vuetify.breakpoint.xsOnly"
					>
						<v-tab @click="productInput(0)">画像</v-tab>
						<v-tab @click="productInput(1)">動画</v-tab>
						<v-tab @click="productInput(2)">youtube</v-tab>
					</v-tabs>
					<p class="input-label mt-2 pl-0" v-html="products.label"></p>
					<v-row class="m-0 p-0" v-show="products.pictureShow">
						<v-col class="p-0" cols="11" sm="11" md="4" lg="4" xl="4">
							<validation-provider
								v-slot="{ errors }"
								ref="picture"
								rules="size:2000|mimes:jpeg,png,jpg,gif"
								name="画像1"
							>
								<v-file-input
									:error-messages="errors"
									background-color="#f4f8fa"
									placeholder="拡張子：jpeg,png,jpg,gif"
									@change="pictureHandleFile(0)"
									v-model="products.pictureValues[0]"
									:rules="pictureRules.pic0"
									outlined
								>
								</v-file-input>
							</validation-provider>
							<div class="text-center">
								<v-img
									v-show="null !== preview.url0"
									:src="preview.url0"
									:lazy-src="preview.url0"
								></v-img>
							</div>
						</v-col>
						<v-col class="p-0" cols="11" sm="11" md="4" lg="4" xl="4">
							<validation-provider
								v-slot="{ errors }"
								rules="size:2000|mimes:jpeg,png,jpg,gif"
								name="画像2"
							>
								<v-file-input
									:error-messages="errors"
									background-color="#f4f8fa"
									placeholder="拡張子：jpeg,png,jpg,gif"
									@change="pictureHandleFile(1)"
									v-model="products.pictureValues[1]"
									:rules="pictureRules.pic1"
									outlined
								>
								</v-file-input>
							</validation-provider>
							<div class="text-center">
								<v-img
									v-show="null !== preview.url1"
									:src="preview.url1"
									:lazy-src="preview.url1"
								></v-img>
							</div>
						</v-col>
						<v-col class="p-0" cols="11" sm="11" md="4" lg="4" xl="4">
							<validation-provider
								v-slot="{ errors }"
								rules="size:2000|mimes:jpeg,png,jpg,gif"
								name="画像3"
							>
								<v-file-input
									:error-messages="errors"
									background-color="#f4f8fa"
									placeholder="拡張子：jpeg,png,jpg,gif"
									@change="pictureHandleFile(2)"
									v-model="products.pictureValues[2]"
									:rules="pictureRules.pic2"
									outlined
								>
								</v-file-input>
							</validation-provider>
							<div class="text-center">
								<v-img
									v-show="null !== preview.url2"
									:src="preview.url2"
									:lazy-src="preview.url2"
								></v-img>
							</div>
						</v-col>
					</v-row>
					<v-row class="m-0 p-0" v-show="products.movieShow">
						<v-col class="p-0" cols="11" sm="11" md="4" lg="4" xl="4">
							<validation-provider
								v-slot="{ errors }"
								rules="size:200000|mimes:mp4,flv,mov,wmv"
								name="動画"
							>
								<v-file-input
									:error-messages="errors"
									background-color="#f4f8fa"
									placeholder="拡張子：mp4,flv,mov,wmv"
									@change="movieHandleFile"
									v-model="products.movieValue"
									:rules="movieRules"
									outlined
								>
								</v-file-input>
							</validation-provider>
						</v-col>
					</v-row>
					<v-row class="m-0 p-0" v-show="products.youtubeShow">
						<v-col class="p-0" cols="11">
							<v-text-field
								background-color="#f4f8fa"
								placeholder="https://www.youtube.com/watch?v=XXXXXXXXXX"
								v-model="products.youtubePath"
								:rules="[rules.youtubePathCheck]"
								@change="youtubePathCheck"
								outlined
							/>
						</v-col>
					</v-row>
				</v-form>
			</validation-observer>
			<div class="ta-r p-2 mt-2">
				<v-btn
					@click="newPost"
					color="cyan"
					elevation="0"
					:loading="btnLoading"
					large
					rounded
					dark
					>投稿する
				</v-btn>
			</div>
		</v-card>
	</v-dialog>
</template>

<script>
import { OK, CREATED, UNPROCESSABLE_ENTITY } from "../../../util";
export default {
	data() {
		return {
			dialog: false,
			btnLoading: false,
			regions: [],
			regionId: "",
			prefectures: [],
			generations: [],
			preDisabled: true,
			errors: [],
			tag: "",
			tagError: null,
			movieRules: [],
			pictureRules: {
				pic0: [],
				pic1: [],
				pic2: [],
			},
			rules: {
				youtubePathCheck: (value) => {
					return (
						/\?v=([^&]+)/.test(value) || "正しいYoutubeURLを入力してください。"
					);
				},
			},
			newPostForm: {
				title: null,
				message: null,
				tags: [],
				prefectureId: "",
				generationId: "",
				pictureFiles: ["", "", ""],
				movieFile: [],
				youtubeId: null,
				type: 0,
			},
			products: {
				label: "画像（サイズ：2MB以内)",
				pictureValues: [],
				pictureUrls: [],
				movieValue: null,
				youtubePath: "",
				pictureShow: true,
				movieShow: false,
				youtubeShow: false,
			},
			preview: {
				url0: null,
				url1: null,
				url2: null,
			},
		};
	},
	methods: {
		async newPost() {
			const isValid = await this.$refs.observer.validate();
			if (isValid) {
				const formData = new FormData();
				formData.append("title", this.newPostForm.title);
				formData.append("message", this.newPostForm.message);
				formData.append("prefecture", this.newPostForm.prefectureId);
				formData.append("generation", this.newPostForm.generationId);
				formData.append("tags", JSON.stringify(this.newPostForm.tags));
				// 画像
				if (this.newPostForm.type === 0) {
					let setting = false;
					for (var i = 0; i < this.newPostForm.pictureFiles.length; i++) {
						// 空の場合0
						if (this.newPostForm.pictureFiles[i] !== "") {
							let file = this.newPostForm.pictureFiles[i];
							formData.append("picture_files[" + i + "]", file);
							setting = true;
						}
					}
					if (setting) {
						formData.append("type", this.newPostForm.type);
					}
				}
				// 動画
				if (this.newPostForm.type === 1 && this.newPostForm.movieFile.length) {
					formData.append("type", this.newPostForm.type);
					formData.append("movie_file", this.newPostForm.movieFile[0]);
				}
				// youtube
				if (
					this.newPostForm.type === 2 &&
					this.newPostForm.youtubeId !== null
				) {
					formData.append("type", this.newPostForm.type);
					formData.append("youtube_path", this.newPostForm.youtubeId[1]);
				}
				this.btnLoading = true;
				const response = await axios.post("/api/recruit/new", formData);
				if (response.status === CREATED) {
					await this.$store.dispatch("flash/showFlashMessage", {
						show: true,
						message: "投稿完了しました。",
						type: 0,
						seconds: 3000,
					});
					// 投稿完了TOPへ遷移
					await this.reset();
					this.addPostReload();
					this.$router.push({ name: "recruit" }).catch((err) => {});
				} else if (response.status === UNPROCESSABLE_ENTITY) {
					this.pictureRules.pic0 = response.data.errors["picture_files.0"];
					this.pictureRules.pic1 = response.data.errors["picture_files.1"];
					this.pictureRules.pic2 = response.data.errors["picture_files.2"];
					this.movieRules = response.data.errors.movie_file;
				} else {
					this.$store.commit("error/setCode", response.status);
				}
				this.btnLoading = false;
			}
		},
		async searchPrefectures() {
			const response = await axios.post("/api/prefecture/region/search", {
				region: this.regionId,
			});
			if (response.status === OK) {
				this.prefectures = response.data;
				if (response.data.length !== 0) {
					this.preDisabled = false;
				} else {
					this.preDisabled = true;
				}
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
		async getRegions() {
			const response = await axios.get("/api/region");
			if (response.status === OK) {
				this.regions = response.data;
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
		async getGenerations() {
			const response = await axios.get("/api/generation");
			if (response.status === OK) {
				this.generations = response.data;
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
		// 画像ファイル格納
		pictureHandleFile(val) {
			this.pictureRules.pic0 = [];
			this.pictureRules.pic1 = [];
			this.pictureRules.pic2 = [];
			if (
				event.target.files !== void 0 &&
				event.target.files !== undefined &&
				event.target.files.length !== 0
			) {
				const file = event.target.files[0];
				this.newPostForm.pictureFiles[val] = file;
				if (val === 0) {
					this.preview.url0 = URL.createObjectURL(file);
				} else if (val === 1) {
					this.preview.url1 = URL.createObjectURL(file);
				} else if (val === 2) {
					this.preview.url2 = URL.createObjectURL(file);
				}
			} else {
				this.newPostForm.pictureFiles[val] = "";
				if (val === 0) {
					this.preview.url0 = null;
				} else if (val === 1) {
					this.preview.url1 = null;
				} else if (val === 2) {
					this.preview.url2 = null;
				}
			}
		},
		// 動画ファイル情報格納
		async movieHandleFile() {
			this.movieRules = [];
			if (event.target.files !== void 0) {
				this.newPostForm.movieFile[0] = event.target.files[0];
			} else {
				this.newPostForm.movieFile = [];
			}
		},
		// youtubeID取り出す
		youtubePathCheck() {
			this.newPostForm.youtubeId = this.products.youtubePath.match(
				/\?v=([^&]+)/
			);
		},
		productInput(product_id) {
			if (product_id !== this.newPostForm.type) {
				this.newPostForm.type = product_id;
				if (product_id === 0) {
					this.initProducts();
					this.products.pictureShow = true;
					this.products.label = "画像（サイズ：2MB以内）";
				}
				if (product_id === 1) {
					this.initProducts();
					this.products.movieShow = true;
					this.products.label = "動画（サイズ：200MB以内）";
				}
				if (product_id === 2) {
					this.initProducts();
					this.products.youtubeShow = true;
					this.products.label = "Youtube";
				}
			}
		},
		checkTag(obj) {
			this.tagError = null;
			if (this.newPostForm.tags.length >= 5) {
				this.tagError = "タグは5個までです。";
			} else {
				if (obj.tag.text.length <= 20) {
					obj.addTag();
				} else {
					this.tagError = "タグは20文字までです。";
				}
			}
		},
		async closeForm() {
			this.dialog = false;
			await this.reset();
		},
		// productsのdata初期化メソッド
		initProducts() {
			this.newPostForm.pictureFiles = [];
			this.products.pictureValues = [];
			this.newPostForm.movieFile = [];
			this.products.movieValue = null;
			this.products.youtubePath = "";
			this.newPostForm.youtubeId = null;
			this.products.pictureShow = false;
			this.products.movieShow = false;
			this.products.youtubeShow = false;
			this.preview.url0 = null;
			this.preview.url1 = null;
			this.preview.url2 = null;
		},
		// data初期化メソッド
		async reset() {
			this.$refs.observer.reset();
			Object.assign(this.$data, this.$options.data.call(this));
			await this.getRegions();
			await this.getGenerations();
		},
		// 親コンポーネントpostReload発火
		addPostReload() {
			this.$emit("addPostReload");
		},
	},
	async created() {
		await this.getRegions();
		await this.getGenerations();
	},
};
</script>

<style></style>
