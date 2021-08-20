<template>
	<div>
		<template>
			<v-btn icon @click="clickDialog">
				<v-icon> mdi-cog-outline </v-icon>
			</v-btn>
		</template>
		<v-dialog v-model="dialog" width="600" persistent no-click-animation>
			<v-card class="p-3">
				<v-card-title class="pt-0 pl-0 pr-0 justify-space-between">
					<h2 class="cyan--text font-weight-bold mb-0">コンビ名設定</h2>
					<v-btn class="mb-3" icon @click="reset">
						<v-icon color="red">mdi-close</v-icon>
					</v-btn>
				</v-card-title>

				<validation-observer ref="observer">
					<v-form>
						<validation-provider
							v-slot="{ errors }"
							name="コンビ名"
							rules="required|max:30"
						>
							<p class="input-label">コンビ名</p>
							<v-text-field
								:error-messages="errors"
								background-color="#f4f8fa"
								placeholder="コンビ名を入力してください。"
								type="text"
								name="name"
								v-model="name"
								required
								outlined
							></v-text-field>
						</validation-provider>
					</v-form>
				</validation-observer>
				<v-card-actions class="p-0">
					<v-btn
						class="justify-right"
						color="error"
						elevation="0"
						rounded
						dark
						@click="deleteComedy"
					>
						解散する
					</v-btn>
					<v-spacer></v-spacer>
					<v-btn
						class="justify-right"
						color="cyan"
						elevation="0"
						rounded
						dark
						@click="editComedy"
					>
						変更する
					</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</div>
</template>

<script>
import { OK } from "../../../util";
export default {
	data() {
		return {
			dialog: false,
			message: null,
			name: this.comedyName,
		};
	},
	props: {
		comedyName: {
			type: String,
			required: true,
		},
		id: {
			type: Number,
			required: true,
		},
	},
	methods: {
		clickDialog() {
			this.dialog = true;
		},
		reset() {
			this.$refs.observer.reset();
			Object.assign(this.$data, this.$options.data.call(this));
		},
		async deleteComedy() {
			if (confirm("本当に解散しますか？")) {
				const response = await axios.delete(`/api/comedy/${this.id}/delete`);
				if (response.status === OK) {
					await this.$store.dispatch("flash/showFlashMessage", {
						show: true,
						message: "コンビ解散しました。",
						type: 1,
						seconds: 3000,
					});
					this.$router.push({ name: "comedy" }).catch((err) => {});
				}
			}
		},
		async editComedy() {
			const isValid = await this.$refs.observer.validate();
			if (isValid) {
				const response = await axios.post("/api/comedy/edit", {
					id: this.id,
					name: this.name,
				});
				if (response.status === OK) {
					this.reset();
					await this.$store.dispatch("flash/showFlashMessage", {
						show: true,
						message: "コンビ名変更しました。",
						type: 0,
						seconds: 3000,
					});
					this.$emit("emitShowComedy");
				}
			}
		},
	},
};
</script>

<style></style>
