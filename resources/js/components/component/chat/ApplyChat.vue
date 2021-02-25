<template>
	<div class="msg">
		<span v-if="msg.partner.application_flg === null">
			<p>【相方申請が届いています】<br />{{ msg.message }}</p>
			<v-btn
				@click="submitApplication(1)"
				color="info"
				class="mb-1 mt-1"
				dark
				rounded
				><v-icon>mdi-check</v-icon><span>コンビ結成する</span></v-btn
			>
			<v-btn
				@click="submitApplication(0)"
				color="error"
				class="mb-1 mt-1"
				dark
				rounded
				><v-icon>mdi-close</v-icon><span>申請拒否する</span></v-btn
			>
		</span>
		<span v-if="msg.partner.application_flg === 0">
			<v-icon class="mb-1">mdi-close</v-icon>
			<router-link to="/partner"> 申請拒否しました。 </router-link>
		</span>
		<span v-if="msg.partner.application_flg === 1">
			<v-icon class="mb-1"> mdi-check </v-icon>
			<router-link :to="`/comedy/${msg.partner.comedy_id}`">
				コンビ結成しました。
			</router-link>
		</span>
	</div>
</template>

<script>
import { OK } from "../../../util";
export default {
	props: {
		msg: {
			type: Object,
		},
	},
	methods: {
		async submitApplication(val) {
			console.log(this.msg);
			if (val === 0) {
				const response = await axios.post("/api/partner/application", {
					room_id: this.msg.room_id,
					partner_id: this.msg.partner_id,
					application_flg: val,
				});
				if (response.status === OK) {
					this.$store.dispatch("flash/showFlashMessage", {
						show: true,
						message: "申請拒否しました。",
						type: 1,
						seconds: 3000,
					});
				} else {
					this.$store.commit("error/setCode", response.status);
				}
			} else if (val === 1) {
				const response = await axios.post("/api/partner/application", {
					room_id: this.msg.room_id,
					partner_id: this.msg.partner_id,
					application_flg: val,
				});
				if (response.status === OK) {
					this.$store.dispatch("flash/showFlashMessage", {
						show: true,
						message: "コンビ結成しました。",
						type: 0,
						seconds: 3000,
					});
					const comedy_id = response.data.comedy_id;
					this.$router
						.push({
							name: "comedy-detail",
							params: { comedy_id },
						})
						.catch((err) => {});
				} else {
					this.$store.commit("error/setCode", response.status);
				}
			}
			this.$emit("emitShowMessages");
		},
	},
};
</script>

<style></style>
