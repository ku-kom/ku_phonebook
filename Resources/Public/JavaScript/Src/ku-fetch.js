/**
 * Fetch querystring and send it to the controller 
 * to query the remote webservice.
 */

document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    const url = 'https://www2.adm.ku.dk/selv/pls/!app_tlfbog_v2.soeg';
    const btn = document.getElementById('query_kuPhonebook');


    let query = document.getElementById('kuPhonebook').value;

    const data = {
        format: 'json',
        startrecord: '0',
        recordsperpage: '100',
        searchstring: query
    };

    async function postData(url = '', data = {}) {
        // Default options are marked with *
        const response = await fetch(url, {
            method: 'POST',
            mode: 'no-cors',
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json'
            },
            redirect: 'follow',
            referrerPolicy: 'no-referrer',
            body: JSON.stringify(data) // body data type must match "Content-Type" header
        });
        return response.json(); // parses JSON response into native JavaScript objects
    }


    btn.addEventListener('click', () => {
        postData(url, data)
            .then((data) => {
                if (!response.ok) {
                    throw new Error('Network response was not OK');
                }
                console.log(data); // JSON data parsed by `data.json()` call
            })
            .catch((error) => {
                console.error('Error:', error);
            })
    });
});