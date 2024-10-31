class MeQrReloadNotification {
    constructor(configs) {
        this._configs = {
            autoDeleteWithCookie: true,
            ...configs
        };

        this._systemSettings = {
            cookieName: 'me-qr-reload-notifications',
        };
    }

    /** @param { object } notificationConfig */
    save(notificationConfig) {
        let savedMessages = this._getSavedNotifications();
        if (!savedMessages.length) {
            savedMessages = [];
        }

        savedMessages.push(notificationConfig);
        try {
            let jsonNotifications = JSON.stringify(savedMessages);

            window.wpCookies.set(
                this._systemSettings.cookieName,
                jsonNotifications
            );
        } catch (e) {
            console.error('Me-Qr-Plugin| It was not possible to save the notification in cookies');
        }
    }

    showSavedNotifications() {
        let savedMessages = this._getSavedNotifications();
        if (!savedMessages.length) {
            return;
        }

        savedMessages.forEach(function (objectMessage) {
            (new MeQrPageNotification(objectMessage)).show();
        });

        if (this._configs.autoDeleteWithCookie) {
            this.removeAll();
        }
    }

    removeAll() {
        window.wpCookies.remove(this._systemSettings.cookieName);
    }

    /** @return { array } */
    _getSavedNotifications() {
        try {
            const cookieString = window.wpCookies.get(this._systemSettings.cookieName);
            if (!cookieString) {
                return [];
            }

            return JSON.parse(cookieString);
        } catch (e) {
            console.log(e);
            console.error('Me-Qr-Plugin| It was not possible to get a notification from cookies');
            return [];
        }
    }
}