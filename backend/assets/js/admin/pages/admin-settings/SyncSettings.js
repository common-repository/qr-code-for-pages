class SyncSettings {
    constructor(configs, sysConfigs) {
        this._configs = {
            exportBtnSelector: '.me-qr-js-export-btn',
            importBtnSelector: '.me-qr-js-import-btn',
            exportBtnBoxSelector: '.me-qr-export-date-box',
            noActiveBtnClass: 'me-qr-no-active-btn',

            ...configs
        };

        this._sysConfigs = {
            exportLoadingModule: new LoadingModule({
                loadingModuleSelector: '#me_qr_export_loader',
                dependentElement: this._configs.exportBtnSelector,
            }),
            importLoadingModule: new LoadingModule({
                loadingModuleSelector: '#me_qr_import_loader',
                dependentElement: this._configs.importBtnSelector,
            }),

            ...sysConfigs
        };
    }

    hangExportTrigger() {
        const self = this;

        $(this._configs.exportBtnSelector).on('click', function () {
            const clickedBtn = $(this);

            new MeQrWindowModal({
                header: wp.i18n.__('Confirm export', 'me-qr'),
                message: `
                    <span>
                        ${ wp.i18n.__(
                            'After confirming this, a request will be sent to the Me-QR server, ' + 
                            'and saving the current plugin settings, on cloud storage', 'me-qr'
                       ) }.
                    </span>
                    <span>
                        ${ wp.i18n.__(
                            'Everything will be done automatically and your participation will not be ' + 
                            'required', 'me-qr'
                        ) }.
                    </span>
                    <span>${ wp.i18n.__('The process will take a few seconds', 'me-qr') }.</span>
                    <span>${ wp.i18n.__('There will be no other changes', 'me-qr') }.</span>
                    <span><b></br>
                        ${ wp.i18n.__(
                            'Attention! By this action, you will irrevocably lose the data of the previous export, ' + 
                            'if there is one', 'me-qr'
                        ) }.
                    </b></span>
                `,
                confirmCallback: self._completeExport.bind(self, clickedBtn),
            });
        });
    }

    hangImportTrigger() {
        const self = this;

        $(this._configs.importBtnSelector).on('click', function () {
            const clickedBtn = $(this);

            new MeQrWindowModal({
                header: wp.i18n.__('Confirm import', 'me-qr'),
                message: `
                    <span>
                        ${ wp.i18n.__(
                            'After confirmation, a request will be sent to the Me-QR server to import your ' + 
                            'previously exported settings', 'me-qr'
                        ) }.
                    </span>
                    <span>${ wp.i18n.__('The process will take a few seconds', 'me-qr') }.</span>
                    <span><b></br>
                        ${ wp.i18n.__(
                            'Attention! By this action you will permanently lose your current plugin settings', 'me-qr'
                        ) }.
                    </b></span>
                `,
                confirmCallback: self._completeImport.bind(self, clickedBtn),
            });
        });
    }

    _completeExport(clickedBtn) {
        this._sysConfigs.exportLoadingModule.show();
        clickedBtn.addClass(meQrDisplayNoneClass);
        this._sendExportSettingsRequest(clickedBtn);
    }

    _completeImport(clickedBtn) {
        this._sysConfigs.importLoadingModule.show();
        clickedBtn.addClass(meQrDisplayNoneClass);
        this._sendImportSettingsRequest(clickedBtn);
    }

    _sendExportSettingsRequest(clickedBtn) {
        const self = this;

        $.ajax({
            url: document.location.origin + "?rest_route=/me-qr/api/export/settings",
            async: true,
            method: 'POST',
            headers: {
                'content-type': 'application/json',
                'X-WP-Nonce': meQrGetVar('nonce-key', true),
            },
            success: function (data) {
                const pageNotification = new MeQrPageNotification({
                    message: wp.i18n.__('Settings successfully exported', 'me-qr'),
                    type: MeQrPageNotification.SUCCESS_TYPE,
                    autoRemoveTime: 4000,
                });
                pageNotification.show();

                const exportDateBox = $(self._configs.exportBtnBoxSelector);
                const exportDate = data?.data?.exportDate;
                if (exportDateBox.length && exportDate) {
                    exportDateBox.text(exportDate);
                }

                const importBtn = $(self._configs.importBtnSelector);
                if (importBtn.length && importBtn.hasClass(self._configs.noActiveBtnClass)) {
                    importBtn.removeClass(self._configs.noActiveBtnClass);
                }
            },
            error: function (response) {
                const errorMessage = response.responseJSON &&
                    response.responseJSON.message ?
                    response.responseJSON.message :
                    meQrGetVar('unknown-message')
                ;
                const pageNotification = new MeQrPageNotification({
                    message: wp.i18n.__('Error exporting settings:', 'me-qr') + ' ' + wp.i18n.__(errorMessage, 'me-qr'),
                    type: MeQrPageNotification.ERROR_TYPE,
                    autoRemoveTime: 8000,
                });
                pageNotification.show();
            },
            complete: function () {
                self._sysConfigs.exportLoadingModule.hide();
                clickedBtn.removeClass(meQrDisplayNoneClass);
            },
        });
    }

    _sendImportSettingsRequest(clickedBtn) {
        const self = this;

        $.ajax({
            url: document.location.origin + "?rest_route=/me-qr/api/import/settings",
            async: true,
            method: 'POST',
            headers: {
                'content-type': 'application/json',
                'X-WP-Nonce': meQrGetVar('nonce-key', true),
            },
            success: function () {
                new MeQrWindowModal({
                    header: wp.i18n.__('Successful import', 'me-qr'),
                    message: wp.i18n.__(
                        'You have successfully imported the settings, but you need to reload the page to display them',
                        'me-qr'
                    ) + '.',
                    confirmBtnText: wp.i18n.__('Reboot', 'me-qr'),
                    cancelBtnText: wp.i18n.__('Reboot later', 'me-qr'),
                    confirmCallback: function () {
                        const pageNotification = new MeQrPageNotification({
                            message: wp.i18n.__('Settings have been imported successfully', 'me-qr'),
                            type: MeQrPageNotification.SUCCESS_TYPE,
                            autoRemoveTime: 4000,
                        });

                        pageNotification.showAfterReloadPage();
                        location.reload();
                    },
                });
            },
            error: function (response) {
                const errorMessage = response.responseJSON &&
                    response.responseJSON.message ?
                    response.responseJSON.message :
                    meQrGetVar('unknown-message')
                ;
                const pageNotification = new MeQrPageNotification({
                    message: wp.i18n.__('Error importing settings:', 'me-qr') + ' ' + wp.i18n.__(errorMessage, 'me-qr'),
                    type: MeQrPageNotification.ERROR_TYPE,
                    autoRemoveTime: 8000,
                });
                pageNotification.show();
            },
            complete: function () {
                self._sysConfigs.importLoadingModule.hide();
                clickedBtn.removeClass(meQrDisplayNoneClass);
            },
        });
    }
}