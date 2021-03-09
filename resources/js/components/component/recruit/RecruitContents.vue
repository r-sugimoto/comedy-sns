<template>
	<div
		v-if="
			RecruitContent.prefecture !== null || RecruitContent.generation !== null
		"
	>
		<p class="m-0 font-weight-bold black--text">募集条件</p>
		<span v-if="RecruitContent.prefecture !== null" class="mr-1">
		エリア：
		<a class="recruit-content green--text" @click="searchRegion(RecruitContent.prefecture.region.id)">{{ RecruitContent.prefecture.region.name }} </a>
		</span>
		<span v-if="RecruitContent.prefecture !== null" class="mr-1">
		都道府県：
		<a class="recruit-content green--text" @click="searchPrefecture(RecruitContent.prefecture.id)">{{ RecruitContent.prefecture.name }}</a>
		</span>
		<span v-if="RecruitContent.generation !== null" class="mr-1">
		募集年代：
		<a class="recruit-content green--text" @click="searchGeneration(RecruitContent.generation.id)">{{ RecruitContent.generation.name }}</a>
		</span>
	</div>
</template>

<script>
export default {
	data: function () {
		return {};
	},
	props: {
		RecruitContent: Object,
	},
	methods: {
		searchRegion(regionId) {
			this.$router
				.push({
					name: "recruit",
					query: {
						freeword: "",
						tag: "",
						region: regionId,
						prefecture: "",
						generation: "",
					},
				})
				.catch((err) => {});
		},
		searchPrefecture(prefectureId) {
			this.$router
				.push({
					name: "recruit",
					query: {
						freeword: "",
						tag: "",
						region: "",
						prefecture: prefectureId,
						generation: "",
					},
				})
				.catch((err) => {});
		},
		searchGeneration(generationId) {
			this.$router
				.push({
					name: "recruit",
					query: {
						freeword: "",
						tag: "",
						region: "",
						prefecture: "",
						generation: generationId,
					},
				})
				.catch((err) => {});
		},
	},
};
</script>

<style>
.recruit-content:hover{
	text-decoration: underline;
}
</style>
