class ErrorModule {
    _error = {
        errorModule: 'Me Qr-Code Error module not found.',
    }

    constructor(configs) {
        this._configs = {
            errorBoxSelector: '.me-qr-error-box',
            ...configs
        };
    }

    show() {
        this._get().removeClass(meQrDisplayNoneClass);
    }

    hide() {
        this._get().addClass(meQrDisplayNoneClass);
    }

    remove() {
        this._get().remove();
    }

    _get() {
        const loadingModule = $(this._configs.errorBoxSelector);
        if (!loadingModule) {
            throw new Error(this._error.errorModule);
        }

        return loadingModule;
    }
}
