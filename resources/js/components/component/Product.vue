<template>
	<div>
		<v-dialog v-model="dialog" width="500" height="500">
			<div style="position: fixed">
				<v-btn icon large @click="dialog = false">
					<v-icon color="red">mdi-close</v-icon>
				</v-btn>
			</div>
			<img :src="img" />
		</v-dialog>
		<v-row class="p-1">
			<v-col :cols="productCols" v-for="item in ProductItems" :key="item.id">
				<v-img
					v-if="item.type === 0"
					:src="item.product_url"
					:lazy-src="item.product_url"
					@click="previewDialog(item.product_url)"
					class="product-image"
				></v-img>
				<div class="text-center">
					<video
						width="80%"
						height="100%"
						v-if="item.type === 1"
						:src="item.product_url"
						preload="none"
						controls
					></video>
					<youtube
						v-if="item.type === 2"
						:video-id="item.name"
						:width="youtubeWidth"
						:height="youtubeHeight"
					/>
				</div>
			</v-col>
		</v-row>
	</div>
</template>

<script>
export default {
	data() {
		return {
			dialog: false,
			img: "",
		};
	},
	props: {
		ProductItems: Array,
	},
	methods: {
		previewDialog(url) {
			this.dialog = true;
			this.img = url;
		},
	},
	computed: {
		productCols() {
			if (this.ProductItems[0].type === 0) {
				return 4;
			} else {
				return 12;
			}
		},
		youtubeHeight() {
			switch (this.$vuetify.breakpoint.name) {
				case "xs":
					return "180px";
				case "sm":
					return "360px";
				case "md":
					return "360px";
				case "lg":
					return "360px";
				case "xl":
					return "360px";
			}
		},
		youtubeWidth() {
			switch (this.$vuetify.breakpoint.name) {
				case "xs":
					return "90%";
				case "sm":
					return "640px";
				case "md":
					return "640px";
				case "lg":
					return "640px";
				case "xl":
					return "640px";
			}
		},
	},
};
</script>

<style>
.product-image {
	object-fit: cover;
}
</style>
