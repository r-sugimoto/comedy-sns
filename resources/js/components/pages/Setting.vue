<template>
	<v-row>
		<v-col
			cols="12"
			md="4"
			lg="4"
			xl="4"
			class="pb-0"
			:class="{ 'pr-0': !$vuetify.breakpoint.xs && !$vuetify.breakpoint.sm }"
		>
			<v-list
				nav
				dense
				v-if="!$vuetify.breakpoint.xs && !$vuetify.breakpoint.sm"
			>
				<v-list-item-group v-model="item">
					<v-list-item>
						<v-list-item-icon>
							<v-icon>mdi-account-cog-outline</v-icon>
						</v-list-item-icon>
						<v-list-item-title>プロフィール設定</v-list-item-title>
					</v-list-item>
					<v-list-item>
						<v-list-item-icon>
							<v-icon>mdi-email-edit-outline</v-icon>
						</v-list-item-icon>
						<v-list-item-title>メールアドレス設定</v-list-item-title>
					</v-list-item>
					<v-list-item>
						<v-list-item-icon>
							<v-icon>mdi-email-receive-outline</v-icon>
						</v-list-item-icon>
						<v-list-item-title>メール通知設定</v-list-item-title>
					</v-list-item>
					<v-list-item>
						<v-list-item-icon>
							<v-icon>mdi-account-off-outline</v-icon>
						</v-list-item-icon>
						<v-list-item-title>退会</v-list-item-title>
					</v-list-item>
				</v-list-item-group>
			</v-list>
			<v-tabs
				background-color="cyan"
				dark
				:show-arrows="$vuetify.breakpoint.xsOnly"
				v-else
			>
				<v-tab class="text-decoration-none" @click="item = 0"
					>プロフィール設定</v-tab
				>
				<v-tab class="text-decoration-none" @click="item = 1"
					>メールアドレス設定</v-tab
				>
				<v-tab class="text-decoration-none" @click="item = 2"
					>メール通知設定</v-tab
				>
				<v-tab class="text-decoration-none" @click="item = 3">退会</v-tab>
			</v-tabs>
		</v-col>
		<v-col
			cols="12"
			md="8"
			lg="8"
			xl="8"
			:class="{ 'pt-0': $vuetify.breakpoint.xs || $vuetify.breakpoint.sm }"
		>
			<ProfileSetting v-if="item === 0" />
			<MailSetting v-if="item === 1" />
			<MailNotice v-if="item === 2" />
			<WithdrawalSetting v-if="item === 3" />
		</v-col>
	</v-row>
</template>

<script>
import ProfileSetting from "../component/setting/ProfileSetting.vue";
import MailSetting from "../component/setting/MailSetting.vue";
import MailNotice from "../component/setting/MailNotice.vue";
import WithdrawalSetting from "../component/setting/WithdrawalSetting.vue";
export default {
	data() {
		return {
			item: 0,
		};
	},
	components: {
		ProfileSetting,
		MailSetting,
		MailNotice,
		WithdrawalSetting,
	},
};
</script>

<style></style>
