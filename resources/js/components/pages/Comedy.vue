<template>
	<v-row align="center" justify="center">
		<v-col class="pb-0" cols="12" md="8" lg="8" xl="8">
			<v-card elevation="0" class="p-3">
				<v-card-title class="justify-center mb-5">
					<h2 class="cyan--text font-weight-bold mb-0">結成したコンビ一覧</h2>
				</v-card-title>
				<ComedyCard
					v-for="(comedy, i) in comedies"
					:key="`comedies-${i}`"
					:comedy="comedy"
					style="border: double 5px #80deea"
				></ComedyCard>
				<v-card-text class="p-0" v-if="message !== ''">{{
					message
				}}</v-card-text>
			</v-card>
		</v-col>
	</v-row>
</template>

<script>
import { OK } from "../../util";
import ComedyCard from "../component/ComedyCard.vue";
export default {
	data() {
		return {
			comedies: [],
			message: "",
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
				if (this.comedies.length === 0) {
					this.message = "結成したコンビが見つかりませんでした。";
				}
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
