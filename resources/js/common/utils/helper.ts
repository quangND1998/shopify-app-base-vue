
export function getParameterQuery() {
    let parameter = {};
    const params = new URLSearchParams(window.location.search);
    for (const param of Array.from(params)) {
      parameter[param[0]] = param[1];
    }
    return parameter;
  }