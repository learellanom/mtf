function _extends() {
  _extends = Object.assign || function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];

      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }

    return target;
  };

  return _extends.apply(this, arguments);
}

/**
 * @typedef {Object} FormatOptions
 * 
 * @property {string} [currency=""] The string to be used as currency symbol.
 *
 * It can be the respective sign (like "$"), currency code (like "GBP"),
 * or a word (like "peso").
 * 
 * @property {string} [decimalDelimiter="."] The string that separates the
 * integer and the fractional parts of the number.
 * 
 * @property {"fluid"|"minmax"|"fixed"} [decimals="minmax"] Sets the amount of
 * decimal places the number will have.
 *
 * - "fixed" — the amount of places will always stay at `maxDecimal`.
 *   `minDecimal` has no effect.
 * - "fluid" — the amount of places will stay at any number between `minDecimal`
 *   and `maxDecimal`, in order not to have trailing zeros.
 * - "minmax" — the amount of places will stay at `maxDecimal` unless it's
 *   possible to be at `minDecimal` without having trailing zeros.
 * 
 * @property {number} [maxDecimal=2] The maximum number of decimal places
 * allowed in the number.
 * 
 * @property {number} [minDecimal=2] The minimum number of decimal places
 * allowed in the number. Has no effect when `decimals` is set to `"fixed"`.
 * 
 * @property {"before"|"after"} [position="after"] Sets the position of the
 * currency symbol with respect to the number.
 * 
 * @property {boolean} [spaced=true] Sets whether there should be a space
 * between the number and the currency symbol.
 * 
 * @property {string} [thousandsDelimiter=""] A string that separates the
 * thousands of the number.
 */

/**
 * Default options for formatting.
 * 
 * @type {FormatOptions}
 */
const defaultOpts = {
  currency: "",
  position: "after",
  spaced: true,
  decimals: "minmax",
  minDecimal: 0,
  maxDecimal: 2,
  decimalDelimiter: ".",
  thousandsDelimiter: ""
};
/**
 * Prettifies a number according to the previously defined format.
 * 
 * @callback PrettifyFunction
 * @param {number|string} number the number to be currency formatted
 * @returns {string} formatted number
 */

/**
 * Returns a curried function to prettify a number according to the given format
 *
 * ## Usage
 * ```
 * > const euros = prettify({currency: "EUR"});
 * > euros("12.345")
 * "12.34 EUR"
 *
 * > const rubles = prettify({
 *     currency: "₽",
 *     decimals: "fixed",
 *     decimalDelimiter: ",",
 *     thousandsDelimiter: " "
 *   });
 * > rubles(56789)
 * "56 789,00 ₽"
 * ```
 * @callback PrettifyFunctionFactory
 * @param {FormatOptions} options formatting options
 * @returns {PrettifyFunction} the formatting function
 */

/**
 * Prettifies a number according to the given format
 *
 * ## Usage
 * ```
 * > prettify({currency: "USD"}, 5);
 * "5 USD"
 *
 * > prettify({
 *     currency: "₽",
 *     decimals: "fixed",
 *     decimalDelimiter: ",",
 *     thousandsDelimiter: " "
 *   }, "56789.0");
 * "56 789,00 ₽"
 * ```
 * @callback PrettyMoneyFunction
 * @param {FormatOptions} options formatting options
 * @param {number|string} number the number to be currency formatted
 * @returns {string} the format results
 */

/**
 * @type {PrettifyFunctionFactory & PrettyMoneyFunction} 
 */

const prettyMoney = function (options, number) {
  /** @type {FormatOptions} */
  const _opts = _extends({}, defaultOpts, options);

  function prettify(number) {
    number = Number(number);

    if (isNaN(number)) {
      number = "NaN";
    } else {
      const tens = Math.pow(10, _opts.maxDecimal);
      number = Math.floor(number * tens).toString(); // Code taken from lodash.repeat (MIT license)
      // Source: https://github.com/lodash/lodash/blob/2f79053d7bc7c9c9561a30dda202b3dcd2b72b90/repeat.js#L20
      // In particular, the exponentiation by squaring algorithm was taken

      let zeroes = _opts.maxDecimal + 1 - number.length;

      if (zeroes > 0) {
        let padWith = "0";

        do {
          if (zeroes % 2 != 0) {
            number = padWith + number;
          }

          zeroes = Math.floor(zeroes / 2);

          if (zeroes != 0) {
            padWith += padWith;
          }
        } while (zeroes != 0);
      }

      const splitIdx = number.length - _opts.maxDecimal;
      const wholePart = number.slice(0, splitIdx).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1" + _opts.thousandsDelimiter);
      let decimalPart = number.slice(splitIdx);

      if (_opts.decimals === "fluid" || _opts.decimals === "minmax" && decimalPart.slice(_opts.minDecimal).match(/^0*$/)) {
        decimalPart = decimalPart.slice(0, _opts.minDecimal) + decimalPart.slice(_opts.minDecimal).replace(/0*$/, "");
      }

      number = wholePart + (decimalPart === "" ? "" : _opts.decimalDelimiter) + decimalPart;
    }

    return (_opts.position === "before" ? _opts.currency : "") + (_opts.position === "before" && _opts.spaced && _opts.currency !== "" ? " " : "") + number + (_opts.position === "after" && _opts.spaced && _opts.currency !== "" ? " " : "") + (_opts.position === "after" ? _opts.currency : "");
  }

  if (number === undefined) {
    return prettify;
  }

  return prettify(number);
};

module.exports = prettyMoney;
//# sourceMappingURL=pretty-money.js.map
