$(document).ready(function () {
   try {
      const
          meQrShortcodeInput = new MeQrShortcodeInput(),
          wcMetaBox = new MeQrMetaBox({
             callbackSuccessQrRequest: function (qrCodes) {
                meQrShortcodeInput.replaceShortcode();
             },
             callbackChangeFormat: function (format) {
                meQrShortcodeInput.replaceShortcode(format)
             },
      });

      wcMetaBox.handel();
      meQrShortcodeInput.hangShortcodeCopyBtnTrigger();
   } catch (e) {
      console.error(e.message);
   }
});
