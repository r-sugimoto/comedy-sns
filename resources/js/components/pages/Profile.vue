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
			<ProfileCard :id="id" />
		</v-col>
		<v-col
			cols="12"
			md="8"
			lg="8"
			xl="8"
			:class="{ 'pt-0': $vuetify.breakpoint.xs || $vuetify.breakpoint.sm }"
		>
			<ProfileTabs :user-id="id" />
		</v-col>
	</v-row>
</template>

<script>
import ProfileCard from "../component/ProfileCard.vue";
import ProfileTabs from "../component/profile/ProfileTabs.vue";
export default {
	data() {
		return {};
	},
	components: {
		ProfileCard,
		ProfileTabs,
	},
	props: {
		id: {
			type: String,
			required: true,
		},
	},
};
</script>

<style></style>
