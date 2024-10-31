class LoggingSettings {
    _options = {
        fileLoggingValue: true,
        tgLoggingValue: true,
    };

    _systemConfigs = {
        fileCheckboxSelector: '#me_qr_file_logging_value_checkbox',
        tgCheckboxSelector: '#me_qr_tg_logging_value_checkbox',
    };

    getOptions() {
        this._setFileLoggingValue();
        this._setTgLoggingValue();

        return this._options;
    }

    _setFileLoggingValue() {
        const element = $(this._systemConfigs.fileCheckboxSelector);
        if (!element.length) {
            console.error('File logging value checkbox not found');
            return;
        }

        this._options.fileLoggingValue = element.prop('checked');
    }

    _setTgLoggingValue() {
        const element = $(this._systemConfigs.tgCheckboxSelector);
        if (!element.length) {
            console.error('Telegram logging value checkbox not found');
            return;
        }

        this._options.tgLoggingValue = element.prop('checked');
    }
}