const requestUrl = `/graph/analytic`;

const analyticRequests = {
  getFinancialAnalytic: `${requestUrl}/financial`,
  getOperationalAnalytic: `${requestUrl}/operational`,
};

export { analyticRequests };
