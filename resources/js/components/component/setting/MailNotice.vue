<template>
	<v-card class="p-3" elevation="0" tile>
		<v-card-title class="justify-center mt-2 mb-5">
			<h2 class="cyan--text font-weight-bold mb-0">メール通知設定</h2>
		</v-card-title>
		<v-form>
			<v-switch
				v-model="mailSwitch"
				inset
				color="success"
				label="メールで通知を受け取る"
			></v-switch>
			<v-card elevation="0" class="ml-2" tile v-if="mailSwitch === true">
				<v-card-text class="m-0 p-0 mb-2 font-weight-bold"
					>詳細設定</v-card-text
				>
				<v-switch
					v-model="comment"
					inset
					class="m-0 p-0"
					color="success"
					label="コメント"
				></v-switch>
				<v-switch
					v-model="message"
					inset
					class="m-0 p-0"
					color="success"
					label="ダイレクトメッセージ"
				></v-switch>
				<v-switch
					v-model="partner"
					inset
					class="m-0 p-0"
					color="success"
					label="相方申請"
				></v-switch>
			</v-card>
		</v-form>
	</v-card>
</template>

<script>
export default {
	data() {
		return {
			mailSwitch: false,
			comment: true,
			message: true,
			partner: true,
		};
	},
};
</script>

<style></style>
