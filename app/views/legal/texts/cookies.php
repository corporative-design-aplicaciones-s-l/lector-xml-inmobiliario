<?php
$title = "Cookie Policy";
$subtitle = "Information about the use of cookies on this website.";

ob_start();
?>

<h2>Cookie notice</h2>

<p>
This website uses its own technical cookies strictly necessary for the correct functioning
of the site and to enable user navigation.
No analytical, advertising or tracking cookies are used.
</p>

<h2>What are cookies?</h2>

<p>
A cookie is a file that is downloaded to your device when accessing certain web pages.
Cookies allow a website, among other things, to store and retrieve information about
a user’s browsing habits or device and, depending on the information they contain and
the way the device is used, they may be used to recognize the user.
</p>

<p>
The user’s browser stores cookies on the hard drive only during the current session,
occupying minimal memory space and not harming the device.
Cookies do not contain any specific personal information, and most are deleted
from the hard drive at the end of the browsing session (so-called session cookies).
</p>

<p>
Most browsers accept cookies as standard and, independently of them, allow or prevent
temporary or stored cookies through security settings.
Without your explicit consent (by enabling cookies in your browser),
cookies will not link stored data with personal data provided during registration or purchase.
</p>

<h2>Type of cookies used on this website</h2>

<p>
This website only uses the following category of cookies:
</p>

<ul>
    <li>
        <strong>Technical session cookies:</strong>
        These are strictly necessary to allow navigation through the website,
        maintain the user session, and ensure the proper functioning and security
        of the service provided.
    </li>
</ul>

<p>
These cookies:
</p>

<ul>
    <li>Do not collect personal data for advertising purposes.</li>
    <li>Do not perform user tracking or behavioral analysis.</li>
    <li>Do not require prior consent under applicable regulations.</li>
</ul>

<h2>Third-party links</h2>

<p>
This website may provide access to third-party websites that may be of interest.
However, such websites do not belong to Robert & Haris SL,
and their content is not reviewed.
Therefore, Robert & Haris SL cannot be held responsible for their legality,
operation, or any damages resulting from access or use.
</p>

<p>
Those websites must provide their own Privacy Policy and Cookie Policy.
</p>

<h2>How to manage or disable cookies</h2>

<p>
You can allow, block, or delete cookies installed on your device by configuring
the options of the browser installed on your computer.
Please refer to the official support pages of each browser:
</p>

<ul>
    <li>Google Chrome</li>
    <li>Apple Safari</li>
    <li>Microsoft Edge / Internet Explorer</li>
    <li>Mozilla Firefox</li>
</ul>

<p>
Disabling technical cookies may affect the proper functioning of certain features
of the website.
</p>

<h2>Updates to the Cookie Policy</h2>

<p>
Robert & Haris SL may update this Cookie Policy to reflect legal or technical changes.
Users are advised to review it periodically.
</p>

<?php
$content = ob_get_clean();
require VIEW_PATH . '/legal/layout.php';
