class AccountLogout {
    constructor(configs, sysConfigs) {
        this._configs = {
            logoutBtnSelector: '.me-qr-logout-btn',

            ...configs
        };

        this._sysConfigs = {
            logoutLoadingModule: new LoadingModule({
                loadingModuleSelector: '#me_qr_logout_loader',
                dependentElement: this._configs.logoutBtnSelector,
            }),

            ...sysConfigs
        };
    }

    hangLogoutTrigger() {
        const self = this;

        $(document.body).on('click', this._configs.logoutBtnSelector, function () {
            const clickedBtn = $(this);

            new MeQrWindowModal({
                header: wp.i18n.__('Confirm logout', 'me-qr'),
                message: `
                    <span>
                        ${ wp.i18n.__(
                            'Do you really want to log out of your current account?', 'me-qr'
                        ) }
                    </span>
                `,
                confirmCallback: self._completeLogout.bind(self, clickedBtn),
            });
        });
    }

    _completeLogout(clickedBtn) {
        this._sysConfigs.logoutLoadingModule.show();
        clickedBtn.addClass(meQrDisplayNoneClass);
        this._sendLogoutRequest(clickedBtn);
    }

    _sendLogoutRequest(clickedBtn) {
        const self = this;

        $.ajax({
            url: document.location.origin + "?rest_route=/me-qr/api/account/logout",
            async: true,
            method: 'POST',
            headers: {
                'content-type': 'application/json',
                'X-WP-Nonce': meQrGetVar('nonce-key', true),
            },
            success: function () {
                location.reload();
            },
            error: function (response) {
                const errorMessage = response.responseJSON &&
                    response.responseJSON.message ?
                    response.responseJSON.message :
                    meQrGetVar('unknown-message')
                ;
                const pageNotification = new MeQrPageNotification({
                    message: wp.i18n.__('Error logout:', 'me-qr') + ' ' + wp.i18n.__(errorMessage, 'me-qr'),
                    type: MeQrPageNotification.ERROR_TYPE,
                    autoRemoveTime: 8000,
                });
                pageNotification.show();
            },
            complete: function () {
                self._sysConfigs.logoutLoadingModule.hide();
            },
        });
    }
}