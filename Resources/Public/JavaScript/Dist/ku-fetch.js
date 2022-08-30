/**
 * Fetch querystring and send it to the controller 
 * to query the remote webservice.
 */

document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    const url = 'https://www2.adm.ku.dk/selv/pls/!app_tlfbog_v2.soeg';
    const btn = document.getElementById('query_kuPhonebook');


    let query = document.getElementById('kuPhonebook').value;
    const controllerPath = document.getElementById('uri_hidden').value;

    const data = {
        format: 'json',
        startrecord: '0',
        recordsperpage: '100',
        searchstring: query
    };




    btn.addEventListener('click', () => {

    })
});