class MeQrShortcodeInput {
    _errors = {
        shortcodeBox: 'Shortcode box not found in DOM structure.',
        shortcodeInput: 'Shortcode input not found.',
        shortcodeBtn: 'Shortcode copy btn not found.',
        defaultText: 'Default copy btn text not found',
        successCopyText: 'Success copy btn text not found',
        failedCopyText: 'Failed copy btn text not found',
    };

    constructor(configs) {
        this._configs = {
            shortcodeBoxSelector: '.me-qr-wc-shortcode-box',
            shortcodeInputSelector: '.me-qr-wc-shortcode-input',
            shortcodeCopyBtnSelector: '.me-qr-wc-shortcode-copy-btn',
            defaultTextAttr: 'data-default-text',
            successCopyTextAttr: 'data-success-text',
            failedCopyTextAttr: 'data-failed-text',
          ...configs
        };
    }

    getShortcode(format) {
        let postIdParam = ' post_id ="' + postId + '"' ?? '';

        return `[me_qr_block ${postIdParam} format="${format}"]`;
    }

    replaceShortcode(format = 'png') {
        const shortcodeInput = $(this._configs.shortcodeInputSelector);
        if (shortcodeInput.length === 0) {
            throw new Error(this._errors.shortcodeInput);
        }

        shortcodeInput.val(this.getShortcode(format));
    }

    hangShortcodeCopyBtnTrigger() {
        const self = this,
            shortcodeBtn = $(this._configs.shortcodeCopyBtnSelector)
        ;
        if (shortcodeBtn.length === 0) {
            throw new Error(this._errors.shortcodeBtn);
        }
        const shortcodeBox = shortcodeBtn.parents(this._configs.shortcodeBoxSelector);
        if (shortcodeBox.length === 0) {
            throw new Error(this._errors.shortcodeBox);
        }
        const shortcodeInput = $(this._configs.shortcodeInputSelector);
        if (shortcodeBox.length === 0) {
            throw new Error(this._errors.shortcodeInput);
        }

        shortcodeBtn.on('click', function () {
            if (shortcodeBox.hasClass('active')) {
                return;
            }

            navigator.clipboard.writeText(shortcodeInput.val())
                .then(function () {
                    shortcodeBox.addClass('active');
                    self._changeCopyBtnText('success');

                    setTimeout(function() {
                        shortcodeBox.removeClass('active');
                        self._changeCopyBtnText();
                    }, 2000);
                })
                .catch(function () {
                    shortcodeBox.addClass('fail');
                    self._changeCopyBtnText('fail');

                    setTimeout(function() {
                        shortcodeBox.removeClass('fail');
                        self._changeCopyBtnText();
                    }, 2000);
                })
            ;
        });
    }

    _changeCopyBtnText(type = 'default') {
        const shortcodeBtn = $(this._configs.shortcodeCopyBtnSelector),
            defaultText = shortcodeBtn.attr(this._configs.defaultTextAttr),
            successText = shortcodeBtn.attr(this._configs.successCopyTextAttr),
            failedText = shortcodeBtn.attr(this._configs.failedCopyTextAttr)
        ;
        if (!defaultText) {
            console.error(this._errors.defaultText);
            return;
        }
        if (!successText) {
            console.error(this._errors.successCopyText);
            return;
        }
        if (!failedText) {
            console.error(this._errors.failedCopyText);
            return;
        }

        if (type === 'success') {
            shortcodeBtn.text(successText);
        } else if (type === 'fail') {
            shortcodeBtn.text(failedText);
        } else {
            shortcodeBtn.text(defaultText);
        }
    }
}
