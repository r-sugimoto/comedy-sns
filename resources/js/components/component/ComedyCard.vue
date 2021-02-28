<template>
	<div>
		<v-card class="mb-3 mx-auto" elevation="0" tile>
			<v-card-title class="pl-3 pt-1 pb-1">
				<router-link :to="`/comedy/${comedy.id}`" class="black--text">
					{{ comedy.name }}
				</router-link>
			</v-card-title>
			<v-card-actions
				class="pl-3 pt-0"
				v-for="(user, i) in comedy.users"
				:key="`users-${i}`"
			>
				<router-link
					:to="`/profile/${user.id}`"
					class="black--text text-decoration-none"
				>
					<v-avatar size="30" class="mr-1">
						<v-img :src="user.thumbnail_url"></v-img>
					</v-avatar>
					<span>{{ user.name }}</span>
				</router-link>
			</v-card-actions>
			<v-card-actions class="pl-3 pt-0">
				<v-icon color="blue-grey lighten-3" class="mr-1">
					mdi-clock-outline
				</v-icon>
				<span class="text--disabled">{{ comedy.created_at }}</span>
			</v-card-actions>
		</v-card>
	</div>
</template>

<script>
export default {
	props: {
		comedy: {
			type: Object,
		},
	},
};
</script>

<style></style>
