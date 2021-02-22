<template>
	<v-btn text color="cyan" @click="routeBack" class="pl-1">
		<v-icon>mdi-chevron-left</v-icon>
		<span>戻る</span>
	</v-btn>
</template>

<script>
export default {
	methods: {
		routeBack() {
			this.$router.back();
		},
	},
};
</script>

<style></style>
