<template>
	<div>
		<v-menu offset-y left bottom max-width="300" max-height="300">
			<template v-slot:activator="{ on, attrs }">
				<v-btn icon v-bind="attrs" v-on="on" @click="showNotification">
					<v-badge :content="count" :value="count" color="red" overlap>
						<v-icon> mdi-bell-outline </v-icon>
					</v-badge>
				</v-btn>
			</template>
			<v-list class="p-0">
				<div v-for="(n, i) in notifications" :key="`notification-${i}`">
					<v-list-item
						v-if="n.action_type === 1"
						width="200"
						:to="`/post/${n.comments[0].post_id}`"
						three-line
						@click="alreadyNotification(n.id)"
					>
						<v-list-item-avatar>
							<ListAvatar
								:thumbnail="n.comments[0].user.thumbnail"
								:url="n.comments[0].user.thumbnail_url"
							></ListAvatar>
						</v-list-item-avatar>
						<v-list-item-content>
							<v-list-item-title class="list-title"
								>{{
									n.comments[0].user.name
								}}さんからコメントが届いています。</v-list-item-title
							>
							<v-list-item-subtitle>{{
								n.comments[0].message
							}}</v-list-item-subtitle>
							<v-list-item-subtitle>{{ n.created_at }}</v-list-item-subtitle>
						</v-list-item-content>
					</v-list-item>
					<v-list-item
						v-if="n.action_type === 2"
						width="200"
						:to="`/chat/${n.messages[0].room_id}`"
						three-line
						@click="alreadyNotification(n.id)"
					>
						<v-list-item-avatar>
							<ListAvatar
								:thumbnail="n.messages[0].user.thumbnail"
								:url="n.messages[0].user.thumbnail_url"
							></ListAvatar>
						</v-list-item-avatar>
						<v-list-item-content>
							<v-list-item-title class="list-title"
								>{{
									n.messages[0].user.name
								}}さんからメッセージが届いています。</v-list-item-title
							>
							<v-list-item-subtitle>{{
								n.messages[0].message
							}}</v-list-item-subtitle>
							<v-list-item-subtitle>{{ n.created_at }}</v-list-item-subtitle>
						</v-list-item-content>
					</v-list-item>
					<v-list-item
						v-if="n.action_type === 3 && n.partners[0].partner_user !== null"
						width="200"
						to="/partner"
						three-line
						@click="alreadyNotification(n.id)"
					>
						<v-list-item-avatar>
							<ListAvatar
								:thumbnail="n.partners[0].partner_user.thumbnail"
								:url="n.partners[0].partner_user.thumbnail_url"
							></ListAvatar>
						</v-list-item-avatar>
						<v-list-item-content v-if="n.partners[0].application_flg === null">
							<v-list-item-title class="list-title"
								>{{
									n.partners[0].partner_user.name
								}}さんから相方申請が届いています。</v-list-item-title
							>
							<v-list-item-subtitle>{{
								n.partners[0].message
							}}</v-list-item-subtitle>
							<v-list-item-subtitle>{{ n.created_at }}</v-list-item-subtitle>
						</v-list-item-content>
						<v-list-item-content v-if="n.partners[0].application_flg === 0">
							<v-list-item-title class="list-title"
								>{{
									n.partners[0].partner_user.name
								}}さんへの相方申請は拒否されました。</v-list-item-title
							>
							<v-list-item-subtitle>{{ n.created_at }}</v-list-item-subtitle>
						</v-list-item-content>
						<v-list-item-content v-if="n.partners[0].application_flg === 1">
							<v-list-item-title class="list-title"
								>{{
									n.partners[0].partner_user.name
								}}さんとコンビ結成しました。</v-list-item-title
							>
							<v-list-item-subtitle>{{ n.created_at }}</v-list-item-subtitle>
						</v-list-item-content>
					</v-list-item>
					<v-list-item
						v-if="n.action_type === 3 && n.partners[0].user !== null"
						width="200"
						to="/partner"
						three-line
						@click="alreadyNotification(n.id)"
					>
						<v-list-item-avatar>
							<ListAvatar
								:thumbnail="n.partners[0].user.thumbnail"
								:url="n.partners[0].user.thumbnail_url"
							></ListAvatar>
						</v-list-item-avatar>
						<v-list-item-content v-if="n.partners[0].application_flg === null">
							<v-list-item-title class="list-title"
								>{{
									n.partners[0].user.name
								}}さんから相方申請が届いています。</v-list-item-title
							>
							<v-list-item-subtitle>{{
								n.partners[0].message
							}}</v-list-item-subtitle>
							<v-list-item-subtitle>{{ n.created_at }}</v-list-item-subtitle>
						</v-list-item-content>
						<v-list-item-content v-if="n.partners[0].application_flg === 0">
							<v-list-item-title class="list-title"
								>{{
									n.partners[0].user.name
								}}さんへの相方申請は拒否されました。</v-list-item-title
							>
							<v-list-item-subtitle>{{ n.created_at }}</v-list-item-subtitle>
						</v-list-item-content>
						<v-list-item-content v-if="n.partners[0].application_flg === 1">
							<v-list-item-title class="list-title"
								>{{
									n.partners[0].user.name
								}}さんとコンビ結成しました。</v-list-item-title
							>
							<v-list-item-subtitle>{{ n.created_at }}</v-list-item-subtitle>
						</v-list-item-content>
					</v-list-item>
				</div>
			</v-list>
		</v-menu>
	</div>
</template>

<script>
import ListAvatar from "../elements/ListAvatar.vue";
import { OK } from "../../util";
export default {
	data() {
		return {
			count: null,
			notifications: [],
		};
	},
	components: {
		ListAvatar,
	},
	methods: {
		async showNotification() {
			const response = await axios.get("/api/notice");
			if (response.status === OK) {
				if (response.data.length !== 0) {
					this.count = response.data.length;
					this.notifications = response.data;
				} else {
					const response = await axios.get("/api/notice/already");
					if (response.status === OK) {
						this.count = null;
						this.notifications = response.data;
					}
				}
			}
		},
		async alreadyNotification(id) {
			const response = await axios.post(`/api/notice/${id}`);
			if (response.status === OK) {
				await this.showNotification();
			}
		},
	},
	async created() {
		await this.showNotification();
	},
};
</script>

<style>
.list-title {
	text-overflow: inherit;
	white-space: unset;
}
</style>
