module.exports = {
	transform: {
		".*\\.(vue)$": "<rootDir>/node_modules/vue-jest",
		"^.+\\.js$": "<rootDir>/node_modules/babel-jest",
		"vee-validate/dist/rules": "babel-jest",
	},
	moduleFileExtensions: ["js", "vue"],
	transformIgnorePatterns: [
		"<rootDir>/node_modules/(?!(vuetify|vee-validate))",
	],
};
