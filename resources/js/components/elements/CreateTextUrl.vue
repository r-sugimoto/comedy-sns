<script>
export default {
	props: {
		text: {
			type: String,
		},
	},
	render: function (createElement) {
		var a = this.text.split(
			/(https?:\/\/[\w!?\/\+\-_~=;\.,*&@#$%\(\)\'\[\]]+)/i
		);
		console.log(a);
		var elements = a.map(function (x, i) {
			console.log(i);
			console.log(x);
			if (i % 2) {
				return createElement("a", { attrs: { href: x } }, x);
			} else {
				return this._v(x);
			}
		}, this);
		return createElement("span", elements);
	},
};
</script>

<style></style>
