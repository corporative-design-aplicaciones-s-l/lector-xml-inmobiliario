<?php
$title = "Legal Advice";
$subtitle = "Website ownership and legal terms of use.";

ob_start();
?>

<p>
    In compliance with Article 10 of Law 34/2002 of July 11 on Information Society Services and Electronic Commerce,
    the Owner, <strong>Robert & Haris SL</strong>, with NIF <strong>B-10739803</strong>, registered address at
    Sirocco Padel Club, Av. de Luxemburgo, 3, 03191, Pilar de la Horadada, Alicante (Point of sale),
    telephone <strong>606 509 389</strong> and email <strong>contact@lavrealestate.com</strong>,
    hereby provides the following registry information:
</p>

<h2>Intellectual and industrial property</h2>
<p>
    The design of this portal and its source codes, as well as the logos, trademarks and other distinctive signs
    appearing on it, belong to Robert & Haris SL and are protected by the corresponding intellectual
    and industrial property rights.
</p>

<h2>Responsibility for contents</h2>
<p>
    Robert & Haris SL is not responsible for the legality of third-party websites from which access to this portal may
    occur.
    Robert & Haris SL is also not responsible for the legality of third-party websites that may be linked or connected
    from this portal.
</p>

<p>
    Robert & Haris SL reserves the right to make changes to the website without prior notice,
    in order to keep its information updated, by adding, modifying, correcting or deleting
    published content or the portal design.
</p>

<p>
    Robert & Haris SL shall not be liable for the use that third parties may make of the information
    published on the portal, nor for any damages suffered or economic losses that, directly or indirectly,
    may cause economic, material or data damage resulting from the use of such information.
</p>

<h2>Content reproduction</h2>
<p>
    Total or partial reproduction of the contents published on the portal is prohibited,
    except for contents considered as open data in the Electronic Headquarters,
    published in accordance with Royal Decree 1495/2011 of October 24.
</p>

<h2>Applicable law</h2>
<p>
    The applicable law in case of dispute or conflict of interpretation of the terms
    that make up this legal notice, as well as any matter related to the services of this portal,
    shall be Spanish law.
</p>

<?php
$content = ob_get_clean();
require VIEW_PATH . '/legal/layout.php';
