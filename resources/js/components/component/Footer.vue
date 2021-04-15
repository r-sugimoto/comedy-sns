<template>
	<v-card class="footer" elevation="0" tile>
		<v-footer class="cyan">
			<v-row justify="center" no-gutters>
				<v-btn
					text
					rounded
					dark
					style="text-transform: none"
					href="https://twitter.com/comenion_"
					target="_blank"
					>公式Twitter</v-btn
				>
				<v-btn
					text
					rounded
					dark
					href="https://ryu-nosu.com/category/comenion/"
					target="_blank"
					>公式ブログ</v-btn
				>
				<v-btn text rounded dark to="/kiyaku">利用規約</v-btn>
				<v-btn text rounded dark to="/privacy">プライバシーポリシー</v-btn>
				<v-col class="text-center tc-w mt-3 mb-3" cols="12">
					<strong>2021 - Comenion</strong>
				</v-col>
			</v-row>
		</v-footer>
	</v-card>
</template>

<style>
.footer {
	margin-top: 60px;
}
</style>
