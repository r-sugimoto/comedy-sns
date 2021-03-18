import Vue from "vue";
import VueRouter from "vue-router";
import Vuetify from "vuetify";
import {
	ValidationProvider,
	ValidationObserver,
	localize,
	extend,
} from "vee-validate";
import ja from "vee-validate/dist/locale/ja.json";
import * as rules from "vee-validate/dist/rules";
for (let rule in rules) {
	extend(rule, rules[rule]);
}
localize("ja", ja);

import flushPromises from "flush-promises";
import { mount, createLocalVue } from "@vue/test-utils";

const localVue = createLocalVue();
localVue.use(VueRouter);
localVue.component("ValidationProvider", ValidationProvider);
localVue.component("ValidationObserver", ValidationObserver);

const router = new VueRouter();

Vue.use(Vuetify);

import Register from "../../../components/pages/Register.vue";

describe("Register.vue", () => {
	let vuetify;
	beforeEach(() => {
		vuetify = new Vuetify();
	});
	const mount_register = function () {
		return mount(Register, {
			localVue,
			vuetify,
			router,
			sync: false,
		});
	};
	it("バリデーション_未入力チェック", async () => {
		const wrapper = mount_register();
		wrapper.find('[name="name"]').setValue("");
		wrapper.find('[name="email"]').setValue("");
		wrapper.find('[name="password"]').setValue("");
		wrapper.find('[name="password_confirmation"]').setValue("");
		await flushPromises();
		expect(wrapper.findAll(".v-messages__message").at(0).text()).toEqual(
			"ユーザー名は必須項目です"
		);
		expect(wrapper.findAll(".v-messages__message").at(1).text()).toEqual(
			"メールアドレスは必須項目です"
		);
		expect(wrapper.findAll(".v-messages__message").at(2).text()).toEqual(
			"パスワードは必須項目です"
		);
		expect(wrapper.findAll(".v-messages__message").at(3).text()).toEqual(
			"確認用パスワードは必須項目です"
		);
	});
	it("バリデーション_最大文字数チェック", async () => {
		const wrapper = mount_register();
		wrapper.find('[name="name"]').setValue("aiueoaiueoaiueoaiueoa");
		wrapper
			.find('[name="email"]')
			.setValue(
				"aiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoaiueoai@test.com"
			);
		wrapper.find('[name="password"]').setValue("passwordpasswordpassw");
		wrapper
			.find('[name="password_confirmation"]')
			.setValue("passwordpasswordpassw");
		await flushPromises();
		expect(wrapper.findAll(".v-messages__message").at(0).text()).toEqual(
			"ユーザー名は20文字以内にしてください"
		);
		expect(wrapper.findAll(".v-messages__message").at(1).text()).toEqual(
			"メールアドレスは255文字以内にしてください"
		);
		expect(wrapper.findAll(".v-messages__message").at(2).text()).toEqual(
			"パスワードは20文字以内にしてください"
		);
		expect(wrapper.findAll(".v-messages__message").at(3).text()).toEqual(
			"確認用パスワードは20文字以内にしてください"
		);
	});
	it("バリデーション_最小文字数チェック", async () => {
		const wrapper = mount_register();
		wrapper.find('[name="password"]').setValue("pass");
		wrapper.find('[name="password_confirmation"]').setValue("pass");
		await flushPromises();
		expect(wrapper.findAll(".v-messages__message").at(0).text()).toEqual(
			"パスワードは8文字以上でなければなりません"
		);
		expect(wrapper.findAll(".v-messages__message").at(1).text()).toEqual(
			"確認用パスワードは8文字以上でなければなりません"
		);
	});
	it("バリデーション_メールアドレス形式チェック", async () => {
		const wrapper = mount_register();
		wrapper.find('[name="email"]').setValue("aiueo");
		await flushPromises();
		expect(wrapper.findAll(".v-messages__message").at(0).text()).toEqual(
			"メールアドレスは有効なメールアドレスではありません"
		);
	});
	it("バリデーション_パスワード不一致", async () => {
		const wrapper = mount_register();
		wrapper.find('[name="password"]').setValue("password");
		wrapper.find('[name="password_confirmation"]').setValue("passwordpassword");
		await flushPromises();
		expect(wrapper.findAll(".v-messages__message").at(0).text()).toEqual(
			"パスワードが一致しません"
		);
	});
	it("バリデーション_成功", async () => {
		const wrapper = mount_register();
		wrapper.find('[name="name"]').setValue("テスト");
		wrapper.find('[name="email"]').setValue("test@example.com");
		wrapper.find('[name="password"]').setValue("password");
		wrapper.find('[name="password_confirmation"]').setValue("password");
		await flushPromises();
		// バリデーション エラーの場合、クラス：v-messages__messageが存在する
        // 存在した場合true　存在しない場合false
		expect(wrapper.find(".v-messages__message").exists()).toBe(false);
	});
});
