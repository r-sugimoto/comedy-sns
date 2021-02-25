<template>
	<div class="profile-tabs">
		<v-tabs background-color="cyan" class="mt-n3" dark>
			<v-tab @click="changeTab(1)">送った申請</v-tab>
			<v-tab @click="changeTab(2)">届いた申請</v-tab>
		</v-tabs>
	</div>
</template>

<script>
import { OK } from "../../util";
export default {
	data() {
		return {
			partners: [],
		};
	},
	methods: {
		async changeTab(val) {
			this.partners.splice(0, this.partners.length);
			await this.showPartners(val);
		},
		async showPartners(val) {
			const response = await axios.post(`/api/partner/${val}`);
			if (response.status === OK) {
				this.partners = response.data;
				console.log(this.partners);
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
	},
	computed: {
		isLoginUserId() {
			return this.$store.getters["auth/userId"];
		},
	},
	async created() {
		await this.showPartners(1);
	},
};
</script>

<style></style>
