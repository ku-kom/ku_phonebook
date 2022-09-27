/**
 * Handle KU phonebook events
 */
document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    const form = document.getElementById('ku-phonebook');
    const input = document.getElementById('kuPhonebook');
    const reset = document.getElementById('reset');

    reset.addEventListener('click', () => {
        input.value = '';
    });

});