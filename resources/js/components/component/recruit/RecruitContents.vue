<template>
	<div
		v-if="
			RecruitContent.prefecture !== null || RecruitContent.generation !== null
		"
	>
		<p class="m-0 font-weight-bold">募集条件</p>
		<v-btn
			text
			class="p-0 mr-2"
			v-if="RecruitContent.prefecture !== null"
			@click="searchRegion(RecruitContent.prefecture.region.id)"
		>
			<span> エリア：{{ RecruitContent.prefecture.region.name }} </span>
		</v-btn>
		<v-btn
			text
			class="p-0 mr-2"
			v-if="RecruitContent.prefecture !== null"
			@click="searchPrefecture(RecruitContent.prefecture.id)"
		>
			<span> 都道府県：{{ RecruitContent.prefecture.name }} </span>
		</v-btn>
		<v-btn
			text
			class="p-0 mr-2"
			v-if="RecruitContent.generation !== null"
			@click="searchGeneration(RecruitContent.generation.id)"
		>
			<span> 募集年代：{{ RecruitContent.generation.name }} </span>
		</v-btn>
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

<style></style>
