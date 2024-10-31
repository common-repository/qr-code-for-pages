class MeQrWindowModal {
    _currentModalContainer = null;

    constructor(configs) {
        this._configs = {
            header: null,
            message: null,

            confirmCallback: null,
            cancelCallback: null,

            includeConfirmBtn: true,
            includeCancelBtn: true,
            confirmBtnText: wp.i18n.__('Confirm', 'me-qr'),
            cancelBtnText: wp.i18n.__('Cancel', 'me-qr'),
            ...configs
        };

        this._systemSettings = {
            containerClass: 'me-qr-modal-container',
            modalClass: 'me-qr-modal',
            modalOverlayClass: 'me-qr-modal-overlay',
            closeModalBtnClass: 'me-qr-modal-close-btn-box',
            confirmBtnClass: 'me-qr-modal-confirm-btn',
            cancelBtnClass: 'me-qr-modal-cancel-btn',
        };

        this._showModal();
    }

    _showModal() {
        const self = this;
        const prototype = $(this._createPrototype());

        $('#wpcontent').prepend(prototype.hide().fadeIn(200));
        this._currentModalContainer = prototype;

        $('.' + this._systemSettings.confirmBtnClass).on('click', function () {
            self._deleteModal();
            if (self._configs.confirmCallback) {
                self._configs.confirmCallback();
            }
        });

        $('.' + this._systemSettings.cancelBtnClass).on('click', function () {
            self._deleteModal();
            if (self._configs.cancelCallback) {
                self._configs.cancelCallback();
            }
        });

        $('.' + this._systemSettings.closeModalBtnClass).on('click', function () {
            self._deleteModal();
        });

        $('.' + this._systemSettings.modalOverlayClass).on('click', function () {
            self._deleteModal();
        });

        // Event closing the modal window by pressing the ESC button
        $(document).one('keydown', function(e) {
            if (e.which === 27) {
                self._deleteModal();
            }
        });
    }

    _deleteModal() {
        if (this._currentModalContainer instanceof jQuery) {
            this._currentModalContainer.fadeOut(200, function () {
                this.remove()
            });
        }
    }

    _createPrototype() {
        let footer = '';
        let confirmBtn = '';
        let cancelBtn = '';
        if (this._configs.includeConfirmBtn) {
            confirmBtn += `
                <button type="button" class="me-qr-btn ${ this._systemSettings.cancelBtnClass }">
                    ${ this._configs.cancelBtnText }
                </button>
            `;
        }
        if (this._configs.includeCancelBtn) {
            confirmBtn += `
                <button type="button" class="me-qr-btn ${ this._systemSettings.confirmBtnClass }">
                    ${ this._configs.confirmBtnText }
                </button>
            `;
        }
        if (this._configs.includeConfirmBtn || this._configs.includeCancelBtn) {
            footer += `<div class="me-qr-modal-footer">${cancelBtn + confirmBtn}</div>`;
        }

        return `
            <div class="${ this._systemSettings.containerClass }">
                <div class="${ this._systemSettings.modalOverlayClass }"></div>
            
                <div class="me-qr-modal">
                    <div class="me-qr-modal-header-box">
                        <div class="me-qr-modal-header">
                            ${ this._configs.header }
                        </div>
                        <div class="${ this._systemSettings.closeModalBtnClass }">
                            <div class="me-qr-modal-close-btn"></div>
                        </div>
                    </div>
                    
                    <div class="me-qr-modal-body">
                        ${ this._configs.message }
                    </div>
                    
                    ${ footer }
                </div>
            </div>
        `;
    }
}