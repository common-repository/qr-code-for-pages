class MeQrPageNotification {
    static INFO_TYPE = 'info';
    static SUCCESS_TYPE = 'success';
    static ERROR_TYPE = 'error';

    _errorMessage = {
        container: 'Notifications container not found',
        prototype: 'Notification prototype not found',
        messageAttrDOM: 'Message-attr not found in notification DOM',
    }

    constructor(configs) {
        this._configs = {
            message: null,
            messages: [],
            type: MeQrPageNotification.INFO_TYPE,
            animationRemovalTime: 400,
            autoRemove: true,
            autoRemoveTime: 5000,
            isEnableTranslation: false,
            isDisableMessageLimit: false,
            isOnlySaveNotify: false,
            ...configs
        };

        this.systemSettings = {
            messagesLimit: 3,
            containerSelector: '.me-qr-notifications-container',
            notificationPrototypeClass: 'me-qr-js-notification-prototype',
            notificationClass: 'me-qr-notification',
            contentClass: 'me-qr-content',
            closeBtnClass: 'me-qr-close-btn',
            successClass: 'me-qr-success',
            errorClass: 'me-qr-error',
            isAlreadyInitializedAttr: 'data-already-initialized',
        };
    }

    show() {
        const self = this;

        if (this._configs.message !== null) {
            this._hangNotification(this._configs.message);
        }

        if (this._configs.messages.length > 0) {
            this._configs.messages.forEach(function (message) {
                self._hangNotification(message);
            });
        }

        this._hangAdaptationTrigger();
    }

    showAfterReloadPage() {
        (new MeQrReloadNotification()).save(this._configs);
    }

    _hangNotification(message) {
        let prototype = this._createPrototype(),
            container = this._getNotifyContainer()
        ;

        if (this._configs.type === MeQrPageNotification.SUCCESS_TYPE) {
            prototype.addClass(this.systemSettings.successClass);
        }
        if (this._configs.type === MeQrPageNotification.ERROR_TYPE) {
            prototype.addClass(this.systemSettings.errorClass);
        }

        if (!this._configs.disableMessageLimit) {
            const existMessages = container.children('.' + this.systemSettings.notificationClass);
            if (existMessages.length >= this.systemSettings.messagesLimit) {
                existMessages[1].remove();
            }
        }

        if (this._configs.isEnableTranslation) {
            message = wp.i18n.__(message, 'me-qr');
        }

        prototype = this._setMessage(prototype, message);
        container.append(prototype);
    }

    _setMessage(prototype, message) {
        $(prototype.find(`.${this.systemSettings.contentClass}`)).text(message);

        return prototype;
    }

    _getNotifyContainer() {
        const container = $(this.systemSettings.containerSelector);
        if (container.length <= 0) {
            throw Error(this._errorMessage.container);
        }

        container.removeClass(meQrDisplayNoneClass);

        return container;
    }

    _createPrototype() {
        const prototypeDOM = $(`.${this.systemSettings.notificationPrototypeClass}`);
        if (prototypeDOM.length <= 0) {
            throw Error(this._errorMessage.prototype);
        }
        const prototype = prototypeDOM.clone();

        prototype.removeClass(this.systemSettings.notificationPrototypeClass);
        prototype.removeClass(meQrDisplayNoneClass);
        prototype.addClass(this.systemSettings.notificationClass);
        this._hangCloseTrigger(prototype);

        return prototype;
    }

    _hangCloseTrigger(prototype) {
        const self = this,
            closeBtn = $(prototype.find(`.${this.systemSettings.closeBtnClass}`))
        ;

        closeBtn.on('click', function () {
            self._removeNotify(prototype);
        });

        if (self._configs.autoRemove === true) {
            let timeout = setErrorsBoxTimeout();
            prototype.hover(function () {
                clearTimeout(timeout);
            }, function () {
                timeout = setErrorsBoxTimeout();
            });

            function setErrorsBoxTimeout() {
                return setTimeout(function () {
                    self._removeNotify(prototype);
                }, self._configs.autoRemoveTime);
            }
        }
    }

    _removeNotify(notifyDOM) {
        const self = this;

        if (notifyDOM.length <= 0) return;

        notifyDOM.animate({
            opacity: "-=1"
        }, self._configs.animationRemovalTime, function() {
            notifyDOM.remove();
        });
    }

    _hangAdaptationTrigger() {
        const container = $(this.systemSettings.containerSelector);
        if (container.attr(this.systemSettings.isAlreadyInitializedAttr)) {
            return;
        }

        this._adaptationNotify();
        $(document).unbind('wp-menu-state-set wp-collapse-menu', this._adaptationNotify);
        $(document).on('wp-menu-state-set wp-collapse-menu', this._adaptationNotify.bind(this));
        $(document).unbind('click', this._adaptationNotify);
        $(document).on('click', '.ab-icon', this._adaptationNotify.bind(this));
        container.attr(this.systemSettings.isAlreadyInitializedAttr, true);
    }

    _adaptationNotify() {
        const wpSidebarWidth = $('#adminmenuback').width();
        const container = $(this.systemSettings.containerSelector);
        if (wpSidebarWidth === parseInt(container.css('margin-left'))) {
            return;
        }

        if ($(window).width() <= 782) {
            if ($('#wpwrap').hasClass('wp-responsive-open')) {
                container.css('margin-left', wpSidebarWidth);
            } else {
                container.css('margin-left', 0);
            }
        } else {
            container.css('margin-left', wpSidebarWidth);
        }
    }
}