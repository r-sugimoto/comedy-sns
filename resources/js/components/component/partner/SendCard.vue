<template>
	<v-card class="mb-3" elevation="0" tile>
		<v-card-actions class="pl-3">
			<router-link
				:to="`/profile/${partner.partner_user.id}`"
				class="black--text text-decoration-none"
			>
				<v-avatar size="30" class="mr-1">
					<v-img :src="partner.partner_user.thumbnail_url"></v-img>
				</v-avatar>
				<span>{{ partner.partner_user.name }}</span>
			</router-link>
		</v-card-actions>
		<v-card-title class="pl-3 pb-2 subtitle-1"
			>送った申請メッセージ</v-card-title
		>
		<v-card-text class="pl-3 pb-2">{{ partner.message }}</v-card-text>
		<div class="pl-3 pr-3 mb-0">
			<v-alert
				class="mb-0"
				dense
				type="info"
				v-if="partner.application_flg === null"
			>
				申請中です。
			</v-alert>
			<v-alert
				class="mb-0"
				dense
				type="error"
				v-if="partner.application_flg === 0"
			>
				申請拒否されました。
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
export default {
	props: {
		partner: {
			type: Object,
		},
	},
};
</script>

<style></style>
