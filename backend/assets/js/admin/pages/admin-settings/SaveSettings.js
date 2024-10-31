class SaveSettings {
    _saveBtn;
    _requestData = {};

    _errors = {
        saveBtn: 'Save btn not found in DOM body.',
    };

    constructor(configs, sysConfigs) {
        this._configs = {
            shortcodeSettings: new ShortcodeSettings(),
            loggingSettings: new LoggingSettings(),

            ...configs
        };

        this._sysConfigs = {
            saveBtnSelector: '.me-qr-js-save-btn',
            loadingModule: new LoadingModule({
                loadingModuleSelector: '#me_qr_js_save_settings_loading',
            }),

            ...sysConfigs
        };
    }

    hangSaveBtnTrigger() {
        const self = this;

        this._setSaveBtn();

        this._saveBtn.on('click', function () {
            self._saveBtn.addClass(meQrDisplayNoneClass);
            self._sysConfigs.loadingModule.show();

            self.addDataToRequestObject(self._configs.shortcodeSettings.getOptions());
            self.addDataToRequestObject(self._configs.loggingSettings.getOptions());

            self._sendSaveRequest();
        });
    }

    addDataToRequestObject(addedData) {
        Object.assign(this._requestData, addedData);
    }

    _setSaveBtn() {
        const element = $(this._sysConfigs.saveBtnSelector);
        if (!element.length) {
            throw new Error(this._errors.saveBtn);
        }

        this._saveBtn = element;
    }

    _sendSaveRequest() {
        const self = this;

        $.ajax({
            url: document.location.origin + "?rest_route=/me-qr/api/save/settings",
            async: true,
            method: 'POST',
            headers: {
                'content-type': 'application/json',
                'X-WP-Nonce': meQrGetVar('nonce-key', true),
            },
            data: JSON.stringify(self._requestData),
            success: function () {
                const pageNotification = new MeQrPageNotification({
                    message: meQrGetVar('save-success-message'),
                    type: MeQrPageNotification.SUCCESS_TYPE,
                    autoRemoveTime: 4000,
                });
                pageNotification.show();
            },
            error: function (response) {
                const errorMessage = response.responseJSON &&
                    response.responseJSON.message ?
                        response.responseJSON.message :
                        meQrGetVar('unknown-message')
                ;

                const pageNotification = new MeQrPageNotification({
                    message: meQrGetVar('save-error-message') + errorMessage,
                    type: MeQrPageNotification.ERROR_TYPE,
                    autoRemoveTime: 8000,
                });
                pageNotification.show();
            },
            complete: function () {
                self._sysConfigs.loadingModule.hide();
                self._saveBtn.removeClass(meQrDisplayNoneClass);
            },
        });
    }
}