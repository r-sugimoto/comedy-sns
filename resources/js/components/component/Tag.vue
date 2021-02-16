<template>
	<a class="font-weight-bold cyan-text tag mr-1" @click="SearchTag(TagItem.id)">
		#{{ TagItem.name }}
	</a>
</template>

<script>
export default {
	data: function () {
		return {};
	},
	props: {
		TagItem: Object,
		pushName: String,
	},
	methods: {
		SearchTag(tagId) {
			if (this.pushName === "post") {
				this.$router
					.push({
						name: this.pushName,
						query: {
							freeword: "",
							tag: tagId,
						},
					})
					.catch((err) => {});
			} else if (this.pushName === "recruit") {
				this.$router
					.push({
						name: this.pushName,
						query: {
							freeword: "",
							tag: tagId,
							region: "",
							prefecture: "",
							generation: "",
						},
					})
					.catch((err) => {});
			}
		},
	},
};
</script>

<style>
.tag {
	text-decoration: none !important;
}
</style>
