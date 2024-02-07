import { BASE_URL } from "./../config";

const url = (path) => {
  const baseUrl = BASE_URL;
  return `${baseUrl}${path}`;
};

const serialize = (obj) => {
  var str = [];
  for (var p in obj)
    if (obj.hasOwnProperty(p)) {
      str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
    }
  return str.join("&");
};

export { url, serialize };
