<template>
	<v-img :src="thumbnailUrl"></v-img>
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
	},
	computed: {
		thumbnailUrl() {
			if (this.thumbnail !== null) {
				return this.url;
			} else {
				return "/images/penguin.png";
			}
		},
	},
};
</script>

<style></style>
