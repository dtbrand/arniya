import js from "@eslint/js";
import globals from "globals";

export default [
  js.configs.recommended,
  {
    languageOptions: {
      ecmaVersion: 2022,
      sourceType: "module",
      globals: {
        ...globals.browser,
        ...globals.node,
        ...globals.jquery,
        showToast: "readonly",
        bootstrap: "readonly",
        jspdf: "readonly",
        html2canvas: "readonly",
        Chart: "readonly",
      },
    },
    rules: {
      "no-unused-vars": ["warn", { argsIgnorePattern: "^_" }],
      "no-console": "off",
      "no-undef": "warn",
      "no-empty": "warn",
    },
    ignores: [
      "node_modules/**",
      "vendor/**",
      "scratch/**",
      ".uix/**",
      "playwright-report/**",
      "test-results/**",
    ],
  },
];
