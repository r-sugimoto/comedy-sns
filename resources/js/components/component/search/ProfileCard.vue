<template>
	<div>
		<v-card
			tile
			elevation="0"
			class="mb-4"
			:class="{ 'pb-2': user.tags.length !== 0 || user.introduction !== null }"
		>
			<router-link
				:to="`profile/${user.id}`"
				class="black--text text-decoration-none"
			>
				<v-card-actions>
					<v-avatar size="30" color="gray" class="mr-1">
						<v-img :src="user.thumbnail_url"></v-img>
					</v-avatar>
					{{ user.name }}
				</v-card-actions>
			</router-link>
			<v-card-text class="font-weight-bold p-0 pl-2 pr-2 mb-1">
				{{ user.introduction }}
			</v-card-text>
			<div class="pl-2">
				<Tag
					v-for="tag in user.tags"
					:key="`profile-tags-${tag.id}`"
					:tag-item="tag"
					:push-name="'profile'"
				></Tag>
			</div>
		</v-card>
	</div>
</template>

<script>
import Tag from "../Tag.vue";
export default {
	props: {
		user: {
			type: Object,
		},
	},
	components: {
		Tag,
	},
};
</script>

<style></style>
