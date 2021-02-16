<template>
	<v-btn align="center" :to="url" large icon>
		<v-icon class="mr-1"> mdi-comment-text-multiple</v-icon>
		<span class="mr-1">{{ count }}</span>
	</v-btn>
</template>

<script>
export default {
	data: function () {
		return {
			count: this.CommentsCount,
		};
	},
	props: {
		CommentsCount: Number,
		PostId: Number,
		url: String,
	},
};
</script>

<style></style>
