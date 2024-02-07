const intToMonth = (monthNumber) => {
  if (!isNaN(monthNumber)) {
    const date = new Date();
    date.setMonth(monthNumber - 1);

    return date.toLocaleString("en-ID", {
      month: "short",
    });
  }
};

export { intToMonth };
