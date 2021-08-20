<template>
	<v-avatar :size="size" color="white">
		<v-img v-if="thumbnail !== null" :src="url"></v-img>
		<v-img v-else src="/images/penguin.png"></v-img>
	</v-avatar>
</template>

<script>
export default {
	props: {
		thumbnail: {
			type: String,
		},
		url: {
			type: String,
		},
		size: {
			type: Number,
		},
	},
};
</script>

<style></style>
