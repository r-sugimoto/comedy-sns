<template>
	<div id="flash">
		<div id="flash-message">
			<transition appear>
				<!-- 0:成功 1:エラー -->
				<v-alert dense type="success" v-show="isShow" v-if="isType === 0">
					{{ isMessage }}
				</v-alert>
				<v-alert dense type="error" v-show="isShow" v-if="isType === 1">
					{{ isMessage }}
				</v-alert>
			</transition>
		</div>
	</div>
</template>

<script>
export default {
	computed: {
		isShow() {
			return this.$store.getters["flash/getShowFlash"];
		},
		isMessage() {
			return this.$store.getters["flash/getFlashMessage"];
		},
		isType() {
			return this.$store.getters["flash/getFlashType"];
		},
		isSeconds() {
			return this.$store.getters["flash/getFlashSeconds"];
		},
	},
	updated() {
		setTimeout(() => {
			this.$store.commit("flash/setShowFlash", false);
		}, this.isSeconds);
	},
};
</script>

<style scoped>
#flash {
	display: flex;
	justify-content: center;
	align-items: center;
}
#flash-message {
	z-index: 999;
	position: fixed;
}
.v-enter-active,
.v-leave-active {
	transition: opacity 1.5s;
}

.v-enter,
.v-leave-to {
	opacity: 0;
}
</style>
