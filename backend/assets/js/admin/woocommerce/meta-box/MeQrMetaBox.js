class MeQrMetaBox {
    static newQrsUrl = document.location.origin + "?rest_route=/me-qr/api/get/all-qr";
    static updateQrsUrl = document.location.origin + "?rest_route=/me-qr/api/update/all-qr";

    _errors = {
        postId: 'Post id not found.',
        qrImg: 'Qr image element not found in DOM structure.',
        downloadBtn: 'Download btn not found.',
        shortcodeBox: 'Shortcode box not found in DOM structure.',
        shortcodeInput: 'Shortcode input not found.',
        shortcodeBtn: 'Shortcode copy btn not found.',
        qrRequest: 'Request error for receiving Qr-codes.',
    };

    _qrCodes = {
        qrPng: '',
        qrSvg: '',
    }
    _activeFormat = 'png';

    constructor(configs) {
        this._configs = {
            renderBtnSelector: '.me-qr-wc-render-btn',
            renderBoxSelector: '.me-qr-wc-render-box',
            qrBodyBoxSelector: '.me-qr-wc-body',
            radioFormatBoxSelector: 'input[name="me_qr_wc_choice_qr_format"]',
            qrImgSelector: '.me-qr-wc-img',
            downloadBtnSelector: '.me-qr-wc-download-btn',
            reloadBtnSelector: '.me-qr-wc-js-reload-btn',
            errorModule: (new ErrorModule()),
            loadingModule: (new LoadingModule()),
            callbackSuccessQrRequest: null,
            callbackChangeFormat: null,
            ...configs
        };
    }

    handel() {
        const self = this;
        if (postId === undefined) {
            throw new Error(self._errors.postId);
        }

        $(document.body).on('click', this._configs.renderBtnSelector, function () {
            const renderBox = $(self._configs.renderBoxSelector);

            renderBox.addClass(meQrDisplayNoneClass);
            self._configs.loadingModule.show();
            self._sendRequestQrs(MeQrMetaBox.newQrsUrl);
        });

        $(document.body).on('click', this._configs.reloadBtnSelector, function () {
            self._configs.loadingModule.show();
            $(self._configs.qrBodyBoxSelector).addClass(meQrDisplayNoneClass);
            $(self._configs.renderBoxSelector).addClass(meQrDisplayNoneClass);

            self._sendRequestQrs(MeQrMetaBox.updateQrsUrl);
        });

        this._handelRadioBoxTrigger();
    }

    _sendRequestQrs(url) {
        const self = this;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                /* Post id is added globally when this js file is called by the wp_add_inline_script function */
                postId: postId,
            },
            success: function (response) {
                const qrPng = response.data.qr_png + '?v=' + Date.now();
                const qrSvg = response.data.qr_svg + '?v=' + Date.now();
                if (!qrPng || !qrSvg) {
                    throw new Error(self._errors.qrRequest);
                }
                self._qrCodes.qrPng = qrPng;
                self._qrCodes.qrSvg = qrSvg;

                const renderBox = $(self._configs.renderBoxSelector),
                    qrBodyBox = $(self._configs.qrBodyBoxSelector)
                ;
                renderBox.remove();
                self._configs.loadingModule.hide();
                self._replaceQrImg(self._getActiveQr());
                self._replaceQrForDownloadBtn(self._getActiveQr());
                qrBodyBox.removeClass(meQrDisplayNoneClass);

                if (self._configs.callbackSuccessQrRequest) {
                    self._configs.callbackSuccessQrRequest(self._qrCodes);
                }
                if (self._configs.callbackChangeFormat) {
                    self._configs.callbackChangeFormat(self._activeFormat);
                }
            },
            error: function (response) {
                console.error(response.responseJSON.message);

                self._configs.errorModule.show();
                self._configs.loadingModule.hide();
            },
        });
    }

    _handelRadioBoxTrigger() {
        const self = this;

        $(document.body).on('change', this._configs.radioFormatBoxSelector, function () {
            if ($(this).val() === 'svg') {
                self._activeFormat = 'svg';
                self._activeQr = self._qrCodes.qrSvg;
            } else {
                self._activeFormat = 'png';
                self._activeQr = self._qrCodes.qrPng;
            }

            self._replaceQrImg(self._activeQr);
            self._replaceQrForDownloadBtn(self._activeQr);
            if (self._configs.callbackChangeFormat) {
                self._configs.callbackChangeFormat(self._activeFormat);
            }
        });
    }

    _getActiveQr() {
        if (!this._activeFormat || this._activeFormat === 'png') {
            return this._qrCodes.qrPng;
        }

        return this._qrCodes.qrSvg;
    }

    _replaceQrImg(qrString) {
        const img = $(this._configs.qrImgSelector);
        if (!img.length) {
            throw new Error(this._errors.qrImg);
        }

        img.attr('src', qrString);
    }

    _replaceQrForDownloadBtn(qrString) {
        const downloadBtn = $(this._configs.downloadBtnSelector);
        if (downloadBtn.length === 0) {
            throw new Error(this._errors.downloadBtn);
        }

        downloadBtn.attr('href', qrString);
    }
}
