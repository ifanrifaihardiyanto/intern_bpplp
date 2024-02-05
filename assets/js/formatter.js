const formatter = {
  decimal: function (value) {
    if (value === null || value === undefined) {
      return "0.00";
    }

    return (Math.round(value * 100) / 100).toFixed(2);
  },
  percentile: function (value) {
    return `${formatter.decimal(value)}%`;
  },
  million: function (value) {
    return formatter.number(value);
  },
  currency: function (value) {
    return "Rp" + formatter.million(value);
  },
  number: function (value) {
    if (value === null || value === undefined) {
      return "0.00";
    }

    return Math.floor(value)
      .toString()
      .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
  },
  to: function (stringFunc, value) {
    return formatter[stringFunc](value);
  },
};
