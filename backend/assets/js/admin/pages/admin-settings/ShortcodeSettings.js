class ShortcodeSettings {
    _options = {
        shtBlockClass: '',
        shtImgClass: '',
    };

    _systemConfigs = {
        qrBlockClassInputSelector: '#me_qr_sht_block_class_input',
        qrImgClassInputSelector: '#me_qr_sht_img_class_input',
    };

    getOptions() {
        this._setShtQrBlockClass();
        this._setShtQrImgClass();

        return this._options;
    }

    _setShtQrBlockClass() {
        const element = $(this._systemConfigs.qrBlockClassInputSelector);
        if (!element.length) {
            return;
        }
        const value = element.val();
        if (!value) {
            return;
        }

        this._options.shtBlockClass = value;
    }

    _setShtQrImgClass() {
        const element = $(this._systemConfigs.qrImgClassInputSelector);
        if (!element.length) {
            return;
        }
        const value = element.val();
        if (!value) {
            return;
        }

        this._options.shtImgClass = value;
    }
}