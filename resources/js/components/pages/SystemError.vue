<template>
	<v-row>
		<v-col cols="12" class="pb-0">
			<RouteBack></RouteBack>
		</v-col>
		<v-col cols="12">
			<v-alert dense type="error"> システムエラーが発生しました。 </v-alert>
		</v-col>
	</v-row>
</template>
<script>
import RouteBack from "../component/RouteBack.vue";

export default {
	data() {
		return {};
	},
	components: {
		RouteBack,
	},
};
</script>
