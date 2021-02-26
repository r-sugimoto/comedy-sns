<template>
	<div class="profile-tabs">
		<v-tabs background-color="cyan" class="mt-n3" dark>
			<v-tab @click="changeTab(1)">送った申請</v-tab>
			<v-tab @click="changeTab(2)">届いた申請</v-tab>
		</v-tabs>
		<div v-for="(partner, i) in partners" :key="i">
			<SendCard :partner="partner" v-if="tabValue === 1"></SendCard>
			<ArriveCard
				:partner="partner"
				@emitChangeTab="changeTab(2)"
				v-if="tabValue === 2"
			></ArriveCard>
		</div>
	</div>
</template>

<script>
import { OK } from "../../util";
import SendCard from "../component/partner/SendCard.vue";
import ArriveCard from "../component/partner/ArriveCard.vue";
export default {
	data() {
		return {
			tabValue: 1,
			partners: [],
		};
	},
	components: {
		SendCard,
		ArriveCard,
	},
	methods: {
		async changeTab(val) {
			this.partners.splice(0, this.partners.length);
			this.tabValue = val;
			await this.showPartners(val);
		},
		async showPartners(val) {
			this.$store.commit("loading/setLoading", true);
			const response = await axios.post(`/api/partner/${val}`);
			if (response.status === OK) {
				this.partners = response.data;
			} else {
				this.$store.commit("error/setCode", response.status);
			}
			this.$store.commit("loading/setLoading", false);
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
