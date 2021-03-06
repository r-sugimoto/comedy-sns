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
		<v-row>
			<v-col :cols="productCols" v-for="item in ProductItems" :key="item.id">
				<v-img
					v-if="item.type === 0"
					:src="item.product_url"
					:lazy-src="item.product_url"
					@click="previewDialog(item.product_url)"
					class="product-image"
				></v-img>
				<div class="text-center" v-if="item.type === 1">
					<video
						width="90%"
						height="100%"
						:src="item.product_url"
						preload="none"
						controls
					></video>
				</div>
				<div class="frame-wrapper__video mx-auto" v-if="item.type === 2">
					<iframe :src="`https://www.youtube.com/embed/${item.name}`" frameborder="0" allowfullscreen></iframe>
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
	},
};
</script>

<style>
.product-image {
	object-fit: cover;
}
.frame-wrapper__video {
  position: relative;
  width: 90%;
  height: 0;
  padding-bottom: 56.25%;
  overflow: hidden;
}

.frame-wrapper__video iframe {
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
}
</style>
