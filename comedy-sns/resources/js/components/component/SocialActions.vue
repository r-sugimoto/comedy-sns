<template>
	<v-card-actions class="pl-2 pr-2 pt-0 pb-0">
		<v-btn
			v-if="socials.twitter_id !== null"
			large
			icon
			:href="`https://twitter.com/${socials.twitter_id}`"
			target="_blank"
			color="#1DA1F2"
			rel="noopener noreferrer nofollow"
		>
			<v-icon> mdi-twitter </v-icon>
		</v-btn>
		<v-btn
			v-if="socials.instagram_id !== null"
			large
			icon
			:href="`https://www.instagram.com/${socials.instagram_id}`"
			target="_blank"
			color="#C13584"
			rel="noopener noreferrer nofollow"
		>
			<v-icon>mdi-instagram</v-icon>
		</v-btn>
		<v-btn
			v-if="socials.line_id !== null"
			small
			rounded
			dark
			target="_blank"
			rel="noopener noreferrer nofollow"
			color="green"
			elevation="0"
			@click="copyLine"
		>
			LINEIDをコピー
		</v-btn>
	</v-card-actions>
</template>

<script>
export default {
	props: {
		socials: {
			type: Object,
		},
	},
	methods: {
		copyLine() {
			navigator.clipboard
				.writeText(this.socials.line_id)
				.then(() => {
					this.$store.dispatch("flash/showFlashMessage", {
						show: true,
						message: "LINEIDをコピーしました。",
						type: 0,
						seconds: 3000,
					});
				})
				.catch((e) => {
					this.$store.dispatch("flash/showFlashMessage", {
						show: true,
						message: "しばらく経ってからもう一度お試しください。",
						type: 1,
						seconds: 3000,
					});
				});
		},
	},
};
</script>

<style></style>
