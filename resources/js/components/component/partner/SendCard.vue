<template>
	<v-card class="mb-4" elevation="0" tile>
		<v-card-actions class="pl-3 pr-3 pb-2 pt-2">
			<router-link
				:to="`/profile/${partner.partner_user.id}`"
				class="black--text text-decoration-none"
			>
				<Avatar
					:size="30"
					:thumbnail="partner.partner_user.thumbnail"
					:url="partner.partner_user.thumbnail_url"
					class="mr-1"
				></Avatar>
				<span class="va-m">{{ partner.partner_user.name }}</span>
			</router-link>
		</v-card-actions>
		<v-card-title class="pl-3 pr-3 pb-0 pt-2 subtitle-1"
			>送った申請メッセージ</v-card-title
		>
		<v-card-text class="pl-3 pr-3 pb-2 pt-0">{{ partner.message }}</v-card-text>
		<div class="pl-3 pr-3 pt-2">
			<v-alert
				elevation="0"
				class="mb-0"
				dense
				type="info"
				v-if="partner.application_flg === null"
			>
				申請中です。
			</v-alert>
			<v-alert
				elevation="0"
				class="mb-0"
				dense
				type="error"
				v-if="partner.application_flg === 0"
			>
				申請拒否されました。
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
export default {
	props: {
		partner: {
			type: Object,
		},
	},
	components: {
		Avatar,
	},
};
</script>

<style></style>
