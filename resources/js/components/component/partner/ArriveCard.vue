<template>
	<v-card class="mb-4" elevation="0" tile>
		<v-card-actions class="pl-3 pr-3 pb-2 pt-2">
			<router-link
				:to="`/profile/${partner.user.id}`"
				class="black--text text-decoration-none"
			>
				<Avatar
					:size="30"
					:thumbnail="partner.user.thumbnail"
					:url="partner.user.thumbnail_url"
					class="mr-1"
				></Avatar>
				<span class="va-m">{{ partner.user.name }}</span>
			</router-link>
		</v-card-actions>
		<v-card-title class="pl-3 pr-3 pb-0 pt-2 subtitle-1"
			>届いた申請メッセージ</v-card-title
		>
		<v-card-text class="pl-3 pr-3 pb-2 pt-0">{{ partner.message }}</v-card-text>
		<div class="pl-3 pr-3 pt-2">
			<div v-if="partner.application_flg === null">
				<v-btn
					elevation="0"
					@click="submitApplication(1)"
					color="success"
					dark
					rounded
					><v-icon>mdi-check</v-icon><span>コンビ結成</span></v-btn
				>
				<v-btn
					elevation="0"
					@click="submitApplication(0)"
					color="error"
					dark
					rounded
					><v-icon>mdi-close</v-icon><span>申請拒否</span></v-btn
				>
			</div>
			<v-alert
				elevation="0"
				class="mb-0"
				dense
				type="error"
				v-if="partner.application_flg === 0"
			>
				申請拒否しました。
			</v-alert>
			<v-alert
				elevation="0"
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
		<v-card-actions class="pl-3 pr-3 pt-2 pb-2">
			<span class="text--disabled">{{ partner.updated_at }}</span>
		</v-card-actions>
	</v-card>
</template>

<script>
import Avatar from "../../elements/Avatar.vue";
import { OK } from "../../../util";
export default {
	props: {
		partner: {
			type: Object,
		},
	},
	components: {
		Avatar,
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
							path: `comedy/${comedy_id}`,
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
