=== QR Code for Pages ===
Contributors: me-team
Tags: qr, code, pages, shortcode, generator
Requires at least: 5.8
Tested up to: 6.6.1
Stable tag: 2.2
Requires PHP: 7.4
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Is a plugin for generating QR codes for your WordPress pages or posts made by ME-Team.

== Description ==

QR Code for Pages is a plugin for generating QR codes for your WordPress pages or posts made by ME-Team.

Using this plugin on a particular WordPress page or post, you get a unique QR code in .JPG and .SVG formats and a
shortcode for that page (post). The .SVG format allows you to scale the resulting QR code without losing quality
for any size.

The generated QR codes are available for placing anywhere - both digitally and in printed form.
They can be scanned using a mobile phone to use immediately or saved for future use. While scanning, these codes lead
to the page or post for which they were created.

QR codes created by our plugin are dynamic. Accordingly, if the content of the page changes, you will not need to
change the appearance of the code.

The codes come in default appearance (black and white squares). Closer integration with our ME-QR QR code creation
service with the ability to design each created QR code (change the color, form of the elements, add a logo) and
collect detailed analytics on code scanning will be added in the near future. Stay tuned for more updates.

### KEY FEATURES:
* Easy to install;
* Easy to configure;
* Dynamic QR codes;
* Vector-formatted QR codes;
* Shortcode creation;
* Expansion of functionality in the near future;

Any suggestions or feedback are welcome, thanks for using our plugin. Please take the time to let us know about your
experience and rate this plugin.

== Terms & Conditions ==
This policy represents the ME-QR plugin for WordPress in its entirety and supersedes any other written or oral policy.
This policy defines the terms of service all WordPress customers agree to when they install the current
plugin (“Plugin”).

1. The following interpretations are used in the agreement below:

“User” - the person, the owner of the WordPress software, who installs/installed the Plugin.
“Developer” - the person (organization) who developed the Plugin.

2. By installing this plugin, the User consents to the use and processing by the Developer of the user's application
data for the performance of the plugin.

    2.1. The list of data the Developer uses:
        - Data of the software administrator who installed the Plugin (id, email, registration date);

3. By installing this plugin, the User gives his consent to the collection, sending, and subsequent processing of
the Plugin’s working logs by the Developer.

    3.1. By installing the Plugin, the User consents to his software domain name presence in the content of the logs.
    3.2. The Developer does not use the User's software file structures in the data logs.
    3.3. The User can freely disable the collection and sending of logs to the Developer.

4. The Developer makes no express or implied warranties (including but not limited to warranties of non-infringement,
merchantability, or fitness for a particular use) with respect to the services it provides. Neither the Developer nor
anyone else involved in the provision of Service is liable to you or any third party for direct or indirect damages
resulting from the use, or non-use of services provided herein, whether or not such damages resulted from the
negligence of the Developer, even if the Developer has been advised to the possibility of such damages.

5. In no event shall the Developer be liable for any indirect, incidental, punitive, or other consequential damages
arising out of or in relation to this agreement or your use or inability to use the Plugin regardless of the form of
action, whether in contract, tort (including negligence), or otherwise, even if the Developer has been advised of the
possibility of such damages.

6. The Developer reserves the exclusive right to change, amend or revise any portion of this policy at any time,
with or without written notice to our customers.

== Frequently Asked Questions ==

= Do I need to do additional configuration steps after installation?  =
No. The plugin will work immediately after installation. You will only need to use qr codes.

= I can customize the qr code as I want?  =
So far, there is no such possibility. Similar functionality will appear in future versions.

= How to customize the style of the displayed qr-code block on the front of the site?  =
You can add your custom classes to the shortcode.

To do this, add parameters to the shortcode [me_qr_block your_param="param_value"]:

* `qr_block_class="your_css_class"`
> Boxing style containing the qr code itself.
> The default class that is used is - "me-qr-code-box"

* `qr_img_clas="your_css_class"`
> Style for qr code image.
> The default class that is used is - "me-qr-code-box" - "me-qr-img"

= What should I do if the QR code is not loading?  =
Try reloading the page, or deactivating/activating the plugin on the WordPress plugins page.
Or, if all else fails, contact us for help by chatting on the [link](https://me-qr.com/support-chat),
or by email: **support@me-team.com**.
Or if all else fails, contact us for help by writing to the mail: **support@me-team.com**

= Can I disable logging or sending logs to the developer? =
Yes. Open the file wordpress_application_directory/wp-content/plugins/me-qr/backend/configs/me-qr-configs.php.
Here you can configure all available types of logging.

== Screenshots ==
1. What Qr-Code looks on the pages of your site
2. What Qr-Code generation looks like in the Gutenberg editor
3. What Qr-Code Generation Looks Like in Woocommerce Product Editor

== Changelog ==

= 2.2 =
* Improved user authorization and registration on me-qr
* Improved accuracy of QR code generation and regeneration, added id for QR codes
* Improved redirects to me-qr on the plugin settings page
* Improved logic for updating qr code style in qr code generation blocks, with an authorized user
* Improved plugin stability and improved code
* Removed the logic for deleting a temporary user to prevent loss of plugin user data during reinstallation
* Removed unused files to reduce plugin weight
