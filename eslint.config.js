// eslint.config.js
import eslintPluginSecurity from 'eslint-plugin-security';

export default [
  {
    files: ['**/*.js'],
    languageOptions: {
      ecmaVersion: 2022,
      sourceType: 'module',
    },
    plugins: {
      security: eslintPluginSecurity,
    },
    rules: {
      ...eslintPluginSecurity.configs.recommended.rules,
    },
  },
];