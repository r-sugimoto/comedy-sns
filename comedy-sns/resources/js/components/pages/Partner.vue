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
					<v-list-item @click="changeTab(1)">
						<v-list-item-icon>
							<v-icon>mdi-clipboard-arrow-right-outline</v-icon>
						</v-list-item-icon>
						<v-list-item-title>送った申請</v-list-item-title>
					</v-list-item>
					<v-list-item @click="changeTab(2)">
						<v-list-item-icon>
							<v-icon>mdi-clipboard-arrow-left-outline</v-icon>
						</v-list-item-icon>
						<v-list-item-title>届いた申請</v-list-item-title>
					</v-list-item>
				</v-list-item-group>
			</v-list>
			<v-tabs
				background-color="cyan"
				:show-arrows="$vuetify.breakpoint.xsOnly"
				v-else
				dark
			>
				<v-tab @click="changeTab(1)">送った申請</v-tab>
				<v-tab @click="changeTab(2)">届いた申請</v-tab>
			</v-tabs>
		</v-col>
		<v-col
			cols="12"
			md="8"
			lg="8"
			xl="8"
			:class="{ 'pt-0': $vuetify.breakpoint.xs || $vuetify.breakpoint.sm }"
		>
			<div v-for="(partner, i) in partners" :key="i">
				<SendCard :partner="partner" v-if="tab === 1"></SendCard>
				<ArriveCard
					:partner="partner"
					@emitChangeTab="changeTab(2)"
					v-if="tab === 2"
				></ArriveCard>
			</div>
		</v-col>
	</v-row>
</template>

<script>
import { OK } from "../../util";
import SendCard from "../component/partner/SendCard.vue";
import ArriveCard from "../component/partner/ArriveCard.vue";
export default {
	data() {
		return {
			tab: 1,
			item: 0,
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
			this.tab = val;
			this.item = val - 1;
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
