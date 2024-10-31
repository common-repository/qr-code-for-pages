const meQrDisplayNoneClass = 'me-qr-d-none';
const meQrVarsSelector = '#me_qr_vars';

const $ = jQuery.noConflict();

function meQrGetVar(key, isThrowError = false) {
    const varsBox = $(meQrVarsSelector),
        varsBoxError = 'Vars box not found'
    ;

    if (!varsBox && isThrowError) {
        throw new Error(varsBoxError);
    }
    if (!varsBox && !isThrowError) {
        return null;
    }

    const value = varsBox.attr('data-' + key);
    if (!value && isThrowError) {
        throw new Error(`External variable by key '${key}' not found`);
    }
    if (!value && !isThrowError) {
        return null;
    }

    return value;
}
