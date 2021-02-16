<template>
	<div id="default-loading" v-show="isLoading">
		<v-progress-circular indeterminate color="primary" />
	</div>
</template>

<script>
export default {
	computed: {
		isLoading() {
			return this.$store.getters["loading/getLoading"];
		},
	},
};
</script>

<style scoped>
#default-loading {
	display: flex;
	justify-content: center;
	align-items: center;
	width: 100%;
	height: 100%;
	z-index: 9;
	position: fixed;
}
</style>
