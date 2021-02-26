<template>
	<v-card class="mb-3" elevation="0" tile>
		<v-card-actions class="pl-3">
			<router-link
				:to="`/profile/${partner.user.id}`"
				class="black--text text-decoration-none"
			>
				<v-avatar size="30" class="mr-1">
					<v-img :src="partner.user.thumbnail_url"></v-img>
				</v-avatar>
				<span>{{ partner.user.name }}</span>
			</router-link>
		</v-card-actions>
		<v-card-title class="pl-3 pb-2 subtitle-1"
			>届いた申請メッセージ</v-card-title
		>
		<v-card-text class="pl-3 pb-2">{{ partner.message }}</v-card-text>
		<div class="pl-3 pr-3 mb-0">
			<v-card-actions v-if="partner.application_flg === null">
				<v-btn
					@click="submitApplication(1)"
					color="info"
					class="mb-1 mt-1"
					dark
					rounded
					><v-icon>mdi-check</v-icon><span>コンビ結成する</span></v-btn
				>
				<v-btn
					@click="submitApplication(0)"
					color="error"
					class="mb-1 mt-1"
					dark
					rounded
					><v-icon>mdi-close</v-icon><span>申請拒否する</span></v-btn
				>
			</v-card-actions>
			<v-alert
				class="mb-0"
				dense
				type="error"
				v-if="partner.application_flg === 0"
			>
				申請拒否しました。
			</v-alert>
			<v-alert
				class="mb-0"
				dense
				type="success"
				v-if="partner.application_flg === 1"
			>
				コンビ結成しました。
				<router-link class="white--text" :to="`/comedy/${partner.comedy_id}`">
					コンビページへ
				</router-link>
			</v-alert>
		</div>
		<v-card-actions class="pl-3">
			<v-icon color="blue-grey lighten-3" class="mr-1">
				mdi-clock-outline
			</v-icon>
			<span class="text--disabled">{{ partner.updated_at }}</span>
		</v-card-actions>
	</v-card>
</template>

<script>
import { OK } from "../../../util";
export default {
	props: {
		partner: {
			type: Object,
		},
	},
	methods: {
		async submitApplication(val) {
			if (val === 0) {
				const response = await axios.post("/api/partner/application", {
					partner_id: this.partner.id,
					application_flg: val,
					user_id: this.partner.user.id,
				});
				if (response.status === OK) {
					this.$store.dispatch("flash/showFlashMessage", {
						show: true,
						message: "申請拒否しました。",
						type: 1,
						seconds: 3000,
					});
					this.$emit("emitChangeTab");
				} else {
					this.$store.commit("error/setCode", response.status);
				}
			} else if (val === 1) {
				const response = await axios.post("/api/partner/application", {
					partner_id: this.partner.id,
					application_flg: val,
					user_id: this.partner.user.id,
				});
				if (response.status === OK) {
					this.$store.dispatch("flash/showFlashMessage", {
						show: true,
						message: "コンビ結成しました。",
						type: 0,
						seconds: 3000,
					});
					const comedy_id = response.data.comedy_id;
					this.$router
						.push({
							name: "comedy-detail",
							params: { comedy_id },
						})
						.catch((err) => {});
				} else {
					this.$store.commit("error/setCode", response.status);
				}
			}
		},
	},
};
</script>

<style></style>
