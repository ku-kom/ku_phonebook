/**
 * Fetch querystring and send it to the controller 
 * to query the remote webservice.
 */

const url = 'https://www2.adm.ku.dk/selv/pls/!app_tlfbog_v2.soeg';
let request = new AjaxRequest(url);

const qs = {
    foo: 'bar',
    env: 'om' //the parameter env="" is used to define the correct domain in the backend CORS policy.
};
request = request.withQueryArguments(qs);