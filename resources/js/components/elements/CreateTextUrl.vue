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
		var elements = a.map(function (x, i) {
			if (i % 2) {
				return createElement(
					"a",
					{
						attrs: {
							href: x,
							target: "_blank",
							rel: "noopener noreferrer nofollow",
						},
					},
					x
				);
			} else {
				return this._v(x);
			}
		}, this);
		return createElement("span", elements);
	},
};
</script>

<style></style>
