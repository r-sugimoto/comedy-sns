<template>
	<div class="mt-n3 profile-tabs">
		<ComedyCard
			v-for="(comedy, i) in comedies"
			:key="`comedies-${i}`"
			:comedy="comedy"
		></ComedyCard>
	</div>
</template>

<script>
import { OK } from "../../util";
import ComedyCard from "../component/ComedyCard.vue";
export default {
	data() {
		return {
			comedies: [],
		};
	},
	components: {
		ComedyCard,
	},
	methods: {
		async showComedies() {
			const response = await axios.get(`/api/comedy`);
			if (response.status === OK) {
				this.comedies = response.data;
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
	},
	async created() {
		await this.showComedies();
	},
};
</script>

<style></style>
