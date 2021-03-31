module.exports = {
  extends: "stylelint-config-recommended",
  rules: {
    "no-descending-specificity" : null,
    "at-rule-no-unknown": [true, {
      "ignoreAtRules": ["function", "if", "each", "include", "mixin"]
    }]
  }
};
