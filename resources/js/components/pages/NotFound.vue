<template>
	<div>
		<div class="pl-0">
			<RouteBack></RouteBack>
		</div>
		<div>
			<v-alert dense type="info">
				お探しのページは見つかりませんでした。
			</v-alert>
		</div>
	</div>
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
