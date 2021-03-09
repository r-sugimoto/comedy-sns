<template>
	<v-card class="mb-3" elevation="0" tile>
		<v-card-title class="pl-3 pt-2 pb-0 pr-3">
			<router-link :to="`/comedy/${comedy.id}`" class="black--text">
				{{ comedy.name }}
			</router-link>
		</v-card-title>
		<v-card-actions
			class="pl-3 pr-3 pt-2 pb-0"
			v-for="(user, i) in comedy.users"
			:key="`users-${i}`"
		>
			<router-link
				:to="`/profile/${user.id}`"
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
		<v-card-actions class="pl-3 pr-3 pt-2 pb-2">
			<span class="text--disabled">{{ comedy.created_at }}</span>
		</v-card-actions>
	</v-card>
</template>

<script>
import Avatar from "../elements/Avatar.vue";
export default {
	props: {
		comedy: {
			type: Object,
		},
	},
	components: {
		Avatar,
	},
};
</script>

<style></style>
