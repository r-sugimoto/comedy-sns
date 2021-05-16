<template>
	<v-card class="p-3" elevation="0" tile>
		<v-card-title class="justify-center mt-2 mb-5">
			<h2 class="cyan--text font-weight-bold mb-0">プロフィール設定</h2>
		</v-card-title>
		<validation-observer ref="observer">
			<v-form>
				<validation-provider
					v-slot="{ errors }"
					rules="size:5000|mimes:jpeg,png,jpg,gif"
					name="プロフィール画像"
				>
					<p class="input-label">プロフィール画像（サイズ：5MB以内）</p>
					<v-file-input
						:error-messages="errors"
						background-color="#f4f8fa"
						placeholder="拡張子：jpeg,png,jpg,gif"
						@change="handlePictureFile()"
						prepend-icon=""
						v-model="pictureValue"
						:rules="pictureRules"
						outlined
					>
					</v-file-input>
				</validation-provider>
				<div class="text-center">
					<v-avatar size="200" color="gray">
						<v-img :src="preview"></v-img>
					</v-avatar>
				</div>
				<validation-provider
					v-slot="{ errors }"
					name="ユーザー名"
					rules="required|max:20"
				>
					<p class="input-label">ユーザ名</p>
					<v-text-field
						:error-messages="errors"
						background-color="#f4f8fa"
						type="text"
						name="name"
						v-model="userSettingForm.name"
						required
						outlined
					/>
				</validation-provider>
				<validation-provider
					v-slot="{ errors }"
					name="自己紹介文"
					rules="max:280"
				>
					<p class="input-label">自己紹介文</p>
					<v-textarea
						:error-messages="errors"
						background-color="#f4f8fa"
						type="text"
						name="message"
						v-model="userSettingForm.introduction"
						required
						outlined
					></v-textarea>
				</validation-provider>
				<p class="input-label">タグ</p>
				<vue-tags-input
					placeholder="タグを5個まで入力できます"
					v-model="tag"
					:tags="userSettingForm.tags"
					@tags-changed="(newTags) => (userSettingForm.tags = newTags)"
					@before-adding-tag="checkTag"
				/>
				<div class="v-messages__message error--text tag-error-text">
					{{ tagError }}
				</div>
				<validation-provider v-slot="{ errors }" name="年齢" rules="max:3">
					<p class="input-label">年齢</p>
					<v-select
						:error-messages="errors"
						background-color="#f4f8fa"
						type="text"
						name="age"
						v-model="userSettingForm.age"
						:items="ages"
						clearable
						required
						outlined
					>
					</v-select>
				</validation-provider>
				<v-checkbox
					v-model="userSettingForm.publishedAge"
					label="年齢を非公開にする"
					name="remember"
					class="m-0"
				></v-checkbox>
				<p class="input-label">都道府県</p>
				<v-select
					v-model="userSettingForm.prefectureId"
					:items="prefectures"
					item-text="name"
					item-value="id"
					background-color="#f4f8fa"
					outlined
					clearable
				>
				</v-select>
				<v-checkbox
					v-model="userSettingForm.publishedPrefecture"
					label="都道府県を非公開にする"
					name="remember"
					class="m-0"
				></v-checkbox>
				<validation-provider
					v-slot="{ errors }"
					name="Twitterアカウント"
					rules="max:15"
				>
					<p class="input-label">Twitterアカウント</p>
					<v-text-field
						:error-messages="errors"
						background-color="#f4f8fa"
						placeholder="@マーク以降のユーザー名"
						type="text"
						name="name"
						v-model="userSettingForm.twitter"
						required
						outlined
					/>
				</validation-provider>
				<validation-provider
					v-slot="{ errors }"
					name="instagramアカウント"
					rules="max:30"
				>
					<p class="input-label">instagramアカウント</p>
					<v-text-field
						:error-messages="errors"
						background-color="#f4f8fa"
						placeholder="ユーザーネーム"
						type="text"
						name="name"
						v-model="userSettingForm.instagram"
						required
						outlined
					/>
				</validation-provider>
				<validation-provider
					v-slot="{ errors }"
					name="LINEアカウント"
					rules="max:30"
				>
					<p class="input-label">LINEアカウント</p>
					<v-text-field
						:error-messages="errors"
						background-color="#f4f8fa"
						placeholder="LINEID"
						type="text"
						name="name"
						v-model="userSettingForm.line"
						required
						outlined
					/>
				</validation-provider>
				<div class="text-right">
					<v-btn
						@click="postUserSetting"
						class="mt-2"
						color="cyan"
						elevation="0"
						large
						rounded
					>
						<span class="white--text">設定</span>
					</v-btn>
				</div>
			</v-form>
		</validation-observer>
	</v-card>
</template>

<script>
import { OK } from "../../../util";
const ageRange = [...Array(70)].map((v, i) => i + 16);
export default {
	data() {
		return {
			pictureRules: [],
			ages: ageRange,
			prefectures: [],
			pictureValue: null,
			preview: null,
			thumbnail: null,
			tag: "",
			tagError: null,
			userSettingForm: {
				pictureFile: [],
				name: "",
				introduction: "",
				tags: [],
				age: "",
				publishedAge: 0,
				prefectureId: "",
				publishedPrefecture: 0,
				twitter: "",
				instagram: "",
				line: "",
			},
		};
	},
	methods: {
		// ユーザー情報設定
		async postUserSetting() {
			const isValid = await this.$refs.observer.validate();
			if (isValid) {
				const formData = new FormData();
				if (this.userSettingForm.publishedPrefecture) {
					formData.append("published_prefecture", 1);
				} else {
					formData.append("published_prefecture", 0);
				}
				if (this.userSettingForm.publishedAge) {
					formData.append("published_age", 1);
				} else {
					formData.append("published_age", 0);
				}
				formData.append("name", this.userSettingForm.name);
				formData.append("age", this.userSettingForm.age);
				formData.append("introduction", this.userSettingForm.introduction);
				formData.append("prefecture_id", this.userSettingForm.prefectureId);
				formData.append("tags", JSON.stringify(this.userSettingForm.tags));
				formData.append("twitter", this.userSettingForm.twitter);
				formData.append("instagram", this.userSettingForm.instagram);
				formData.append("line", this.userSettingForm.line);
				if (this.userSettingForm.pictureFile.length) {
					formData.append("thumbnail", this.userSettingForm.pictureFile[0]);
				}
				const { status } = await axios.post("/api/user/setting", formData);
				if (status === OK) {
					this.$store.dispatch("flash/showFlashMessage", {
						show: true,
						message: "プロフィール更新完了しました。",
						type: 0,
						seconds: 3000,
					});
					this.$router.go({
						path: this.$router.currentRoute.path,
						force: true,
					});
				} else {
					this.$store.commit("error/setCode", status);
				}
			}
		},
		// ユーザー情報取得
		async getUserSetting() {
			const { status, data } = await axios.get("/api/user/setting");
			if (status === OK) {
				this.thumbnail = data.thumbnail;
				if (this.thumbnail === null) {
					this.preview = "/images/penguin.png";
				} else {
					this.preview = data.thumbnail_url;
				}
				this.userSettingForm.name = data.name;
				this.userSettingForm.prefectureId = data.prefecture_id;
				this.userSettingForm.introduction = data.introduction;
				this.userSettingForm.age = data.age;
				if (data.published_age_flg === 0) {
					this.userSettingForm.publishedAge = false;
				} else {
					this.userSettingForm.publishedAge = true;
				}
				if (data.published_prefecture_flg === 0) {
					this.userSettingForm.publishedPrefecture = false;
				} else {
					this.userSettingForm.publishedPrefecture = true;
				}
				for (var i = 0; i < data.tags.length; i++) {
					this.$set(this.userSettingForm.tags, i, {
						text: data.tags[i].name,
					});
				}
				if (data.social !== null) {
					if (data.social.twitter_id !== null) {
						this.userSettingForm.twitter = data.social.twitter_id;
					}
					if (data.social.instagram_id !== null) {
						this.userSettingForm.instagram = data.social.instagram_id;
					}
					if (data.social.line_id !== null) {
						this.userSettingForm.line = data.social.line_id;
					}
				}
			} else {
				this.$store.commit("error/setCode", status);
			}
		},
		async getPrefectures() {
			const { status, data } = await axios.get("/api/prefecture");
			if (status === OK) {
				this.prefectures = data;
			} else {
				this.$store.commit("error/setCode", status);
			}
		},
		// 画像ファイル格納
		handlePictureFile() {
			this.pictureRules.pic0 = [];
			if (
				event.target.files !== void 0 &&
				event.target.files !== undefined &&
				event.target.files.length !== 0
			) {
				const file = event.target.files[0];
				this.userSettingForm.pictureFile[0] = file;
				this.thumbnail = file.name;
				this.preview = URL.createObjectURL(file);
			} else {
				this.userSettingForm.pictureFile[0] = [];
				this.thumbnail = null;
				this.preview = null;
			}
		},
		checkTag(obj) {
			this.tagError = null;
			if (this.userSettingForm.tags.length >= 5) {
				this.tagError = "タグは5個までです。";
			} else {
				if (obj.tag.text.length <= 20) {
					obj.addTag();
				} else {
					this.tagError = "タグは20文字までです。";
				}
			}
		},
	},
	created() {
		this.getUserSetting();
		this.getPrefectures();
	},
};
</script>

<style></style>
