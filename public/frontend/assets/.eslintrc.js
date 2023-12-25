module.exports = {
    env: {
        browser: true,
        es2021: true,
        node: true,
    },
    extends: [
        "eslint:recommended",
        "prettier",
    ],
    parserOptions: {
        ecmaVersion: 12,
        sourceType: "module",
    },
    rules: {
        "no-unused-vars": "off",
        "no-undef": "off",
        "no-console": "off",
        "no-empty": "off",
        "no-constant-condition": "off",
        "no-prototype-builtins": "off",
        "no-async-promise-executor": "off",
        "no-unsafe-optional-chaining": "off",
        "no-unsafe-negation": "off",
        "no-useless-escape": "off",
        "no-useless-catch": "off",
        "no-useless-constructor": "off",
        "no-useless-computed-key": "off",
        "no-useless-rename": "off",
        "no-useless-return": "off",
        "no-useless-concat": "off",
        "no-useless-backreference": "off",
    },
};
