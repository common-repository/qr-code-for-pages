try {
    /* Displays all notifications saved in cookies for display after page reload */
    (new MeQrReloadNotification()).showSavedNotifications();

    const saveSettings = new SaveSettings();
    saveSettings.hangSaveBtnTrigger();

    if (typeof SyncSettings === 'function') {
        const syncSettings = new SyncSettings();
        syncSettings.hangExportTrigger();
        syncSettings.hangImportTrigger();
    }

    if (typeof AccountLogout === 'function') {
        const syncSettings = new AccountLogout();
        syncSettings.hangLogoutTrigger();
    }
} catch (e) {
    console.error(e);
}
