const isEmpty = (obj) => {
  return (
    obj &&
    Object.keys(obj).length === 0 &&
    Object.getPrototypeOf(obj) === Object.prototype
  );
};

const formatter = Intl.NumberFormat("id-ID", { notation: "compact" });

export { isEmpty, formatter };
