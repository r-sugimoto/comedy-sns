<template>
	<v-avatar :size="size">
		<v-img v-if="thumbnail !== null" :src="url"></v-img>
		<v-icon v-else>mdi-penguin</v-icon>
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
