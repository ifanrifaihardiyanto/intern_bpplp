const requestUrl = `/graph/trend`;

const trendRequests = {
  getFinancialTrend: `${requestUrl}/financial`,
  getOperationalTrend: `${requestUrl}/operational`,
  getOperationalTrendFilter: `${requestUrl}/operational_category`,
};

export { trendRequests };
