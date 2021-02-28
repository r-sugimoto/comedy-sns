<template>
	<div>
		<v-menu offset-y>
			<template v-slot:activator="{ on, attrs }">
				<v-btn icon v-bind="attrs" v-on="on" @click="showNotification">
					<v-badge :content="count" :value="count" color="red" overlap>
						<v-icon> mdi-bell-outline </v-icon>
					</v-badge>
				</v-btn>
			</template>
			<v-list>
				<v-list-item>
					<v-list-item-content>
						<v-list-item-title>通知が見つかりませんでした。</v-list-item-title>
					</v-list-item-content>
				</v-list-item>
			</v-list>
		</v-menu>
	</div>
</template>

<script>
export default {
	data() {
		return {
			count: 111,
			show: false,
		};
	},
	methods: {
		showNotification() {
			this.count = null;
		},
	},
};
</script>

<style></style>
