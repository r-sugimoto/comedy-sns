<template>
	<v-card
		tile
		elevation="0"
		class="mb-4"
		:class="{ 'pb-2': user.tags.length !== 0 || user.introduction !== null }"
	>
		<v-card-actions class="pl-3 pr-3 pb-2 pt-2">
			<router-link
				:to="`profile/${user.id}`"
				class="black--text text-decoration-none"
			>
				<Avatar
					:size="30"
					:thumbnail="user.thumbnail"
					:url="user.thumbnail_url"
					class="mr-1"
				></Avatar>
				<span class="va-m">
					{{ user.name }}
				</span>
			</router-link>
		</v-card-actions>
		<v-card-text class="font-weight-bold pl-3 pr-3 pb-0 pt-0">
			<CreateTextUrl :text="user.introduction" />
			<Tag
				v-for="(tag, i) in user.tags"
				:key="`profile-tags-${i}`"
				:tag-item="tag"
				:push-name="'profile'"
			></Tag>
		</v-card-text>
	</v-card>
</template>

<script>
import Tag from "../Tag.vue";
import Avatar from "../../elements/Avatar.vue";
import CreateTextUrl from "../../elements/CreateTextUrl.vue";
export default {
	props: {
		user: {
			type: Object,
		},
	},
	components: {
		Tag,
		Avatar,
		CreateTextUrl,
	},
};
</script>

<style></style>
