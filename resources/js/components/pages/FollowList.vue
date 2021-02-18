<template>
	<div>
		<router-link :to="`/profile/${this.id}`">戻る</router-link>
	</div>
</template>

<script>
export default {
	props: {
		id: {
			type: String,
			required: true,
		},
	},
};
</script>

<style></style>
