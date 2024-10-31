class LoadingModule {
    _error = {
        loadingModule: 'QR for pages plugin error| Loading module not found.',
    }

    constructor(configs) {
        this._configs = {
            loadingModuleSelector: '.me-qr-loading-module',
            dependentElement: null,
            ...configs
        };
    }

    show() {
        this._get(true).removeClass(meQrDisplayNoneClass);
    }

    hide() {
        this._get().addClass(meQrDisplayNoneClass);
    }

    remove() {
        this._get().remove()
    }

    _get(changeSize = false) {
        const loadingModule = $(this._configs.loadingModuleSelector);
        if (!loadingModule) {
            throw new Error(this._error.loadingModule);
        }
        if (changeSize) {
            this._setDependentElementParam(loadingModule);
        }

        return loadingModule;
    }

    _setDependentElementParam(loadingModule) {
        if (this._configs.dependentElement === null) {
            return;
        }

        let element = this._configs.dependentElement;
        if (typeof this._configs.dependentElement !== 'object') {
            element = $(this._configs.dependentElement);
        }
        if (!element || element.length === 0) {
            return;
        }
        let isRemovedDisplayNoneClass = false;
        if (element.hasClass(meQrDisplayNoneClass)) {
            element.removeClass(meQrDisplayNoneClass);
            isRemovedDisplayNoneClass = true;
        }

        loadingModule.width(element.outerWidth(true));
        loadingModule.height(element.outerHeight(true));

        if (isRemovedDisplayNoneClass) {
            element.addClass(meQrDisplayNoneClass);
        }
    }
}
