<template>
	<v-menu offset-y v-if="userIdCheck">
		<template v-slot:activator="{ on, attrs }">
			<v-btn large v-bind="attrs" v-on="on" icon>
				<v-icon>mdi-dots-vertical</v-icon>
			</v-btn>
		</template>
		<v-list class="p-0">
			<v-list-item v-if="userIdCheck" @click="deleteItem">
				<v-list-item-content>
					<v-list-item-title>削除</v-list-item-title>
				</v-list-item-content>
			</v-list-item>
		</v-list>
	</v-menu>
</template>

<script>
import { OK } from "../../util";
export default {
	data() {
		return {};
	},
	props: {
		commentId: Number,
		userIdCheck: Boolean,
	},
	methods: {
		async deleteItem() {
			const response = await axios.delete(`/api/comment/${this.commentId}`);
			if (response.status === OK) {
				this.$store.dispatch("flash/showFlashMessage", {
					show: true,
					message: "コメント削除しました。",
					type: 1,
					seconds: 3000,
				});
				this.addShowPostDetail();
			} else {
				this.$store.commit("error/setCode", response.status);
			}
		},
		// 親コンポーネントshowPostDetail発火
		addShowPostDetail() {
			this.$emit("addShowPostDetail");
		},
	},
};
</script>
