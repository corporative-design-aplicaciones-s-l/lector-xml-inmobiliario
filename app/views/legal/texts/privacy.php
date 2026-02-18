<?php
$title = "Privacy Policy";
$subtitle = "Information about how we collect, use and protect your personal data.";

ob_start();
?>

<p>
Robert & Haris SL is committed to protecting your privacy. This Privacy Policy explains how we collect
and use your personal data and what rights and options you have in this regard.
Please also consult our Cookie Policy, which explains the use of cookies and other web tracking devices
through our website.
</p>

<h2>Who is responsible for processing your personal data?</h2>

<p>
Robert & Haris SL, with N.I.F. B-10739803, registered address at Sirocco Padel Club,
Av. de Luxemburgo, 3, 03191, Pilar de la Horadada, Alicante, telephone number 606 509 389
and email contact@lavrealestate.com, is responsible for processing your personal data.
</p>

<p>
We therefore guarantee the security and confidential treatment of your data,
in accordance with the provisions of the EUROPEAN GENERAL DATA PROTECTION REGULATION (EU) 679/2016,
as well as any other applicable regulations.
</p>

<h2>What types and categories of personal data do we process?</h2>

<p>The categories of data we may require from you are classified as follows:</p>

<ul>
    <li>Identification and contact data.</li>
    <li>Connection and browsing data.</li>
</ul>

<p>
Within each of these categories, the following types of data may be requested or provided
at some point during our relationship:
</p>

<p>
<strong>Identification and contact data:</strong>
Full name, postal address, delivery address, date of birth, telephone number and email address.
You may provide data relating to third parties with whom you have a relationship.
In that case, we will process the data on the understanding that you have informed those third parties
that you would provide their data and referred them to this Privacy Policy.
Nevertheless, when possible, we will inform them directly of this policy.
</p>

<p>
<strong>Connection and browsing data:</strong>
If we use this type of data, we may access your device’s IP address, device identifier
and related metadata.
</p>

<p>
For companies, we will process the company name and tax identification number,
the name and surname of the contact person, as well as address and telephone number.
We appreciate that the data provided is accurate and up to date.
If false, incomplete, inaccurate or outdated data is provided,
we reserve the right to terminate contracted services or any related agreement.
</p>

<h2>For what purposes do we use your personal data?</h2>

<p>
Robert & Haris SL uses your data only to the extent permitted by the GDPR
and applicable regulations. Processing will always be carried out for specific,
explicit and legitimate purposes and never in a manner incompatible with those purposes.
</p>

<p>Specifically, the following processing activities may be carried out:</p>

<ul>
    <li>Responding to your enquiries, requests or applications.</li>
    <li>Managing contractual relationships and providing requested services.</li>
    <li>Handling telephone communications.</li>
    <li>Issuing payment receipts for services rendered.</li>
    <li>Monitoring service provision where necessary.</li>
    <li>Performing administrative, tax and accounting procedures required by law.</li>
    <li>Compliance with legal obligations.</li>
    <li>Analyzing and improving our services and communications.</li>
    <li>Monitoring compliance with internal policies and regulations.</li>
    <li>Sending commercial information where explicit consent has been given.</li>
</ul>

<h2>What is the legal basis for processing your data?</h2>

<p>
All processing of personal data is carried out in compliance with Article 6 of the GDPR
and Article 8 of Spanish Organic Law 3/2018.
Where the legal basis for a specific purpose is not covered by these provisions,
the data subject’s consent will be requested.
</p>

<h2>How long do we retain your data?</h2>

<p>
Personal data will be retained for as long as necessary to provide the service
or until the data subject withdraws consent.
Afterwards, the data will be deleted in accordance with data protection regulations,
which implies blocking the data so that it is only available to judges, courts,
the Ombudsman, Public Prosecutor or competent public authorities during
the statutory limitation period, after which it will be permanently deleted.
</p>

<h2>With whom do we share your data?</h2>

<p>
Provided data may be communicated to service providers necessary for the requested processing.
Such providers are obliged to use the data solely for the execution of the requested service.
</p>

<p>
Personal data processed by Robert & Haris SL may also be communicated, where legally required, to:
</p>

<ul>
    <li>Public Administrations in legally established cases.</li>
    <li>State Security Forces and Bodies.</li>
    <li>Banks and financial institutions for payment processing.</li>
    <li>Public solvency registers and fraud prevention systems.</li>
</ul>

<h2>What are your rights?</h2>

<p>
Regardless of the purpose or legal basis for processing, you have the following rights:
</p>

<ul>
    <li><strong>Right of access:</strong> confirmation of whether your personal data is being processed.</li>
    <li><strong>Right of rectification:</strong> correction of inaccurate data.</li>
    <li><strong>Right of erasure:</strong> deletion when data is no longer necessary.</li>
    <li><strong>Right to restriction:</strong> limitation of processing for legal claims.</li>
    <li><strong>Right to portability:</strong> receipt of your data in structured format.</li>
    <li><strong>Right to withdraw consent:</strong> without affecting prior lawful processing.</li>
</ul>

<h2>How can you exercise your rights?</h2>

<p>
You may exercise your rights free of charge by emailing
<strong>contact@lavrealestate.com</strong>, indicating the reason and the right you wish to exercise.
A copy of your ID or NIE is legally required for identification.
</p>

<p>
You may also request official rights-exercise forms via email or in person,
and submit claims to the competent supervisory authority if unsatisfied.
</p>

<h2>Do you want a rights-exercise form?</h2>

<p>
Forms are available upon request by email, or you may use those provided
by the Spanish Data Protection Agency or third parties.
Forms must be electronically signed or accompanied by ID copy.
If represented by another person, their ID or electronic signature is also required.
Forms may be submitted in person, by post or by email to the controller’s address above.
</p>

<?php
$content = ob_get_clean();
require VIEW_PATH . '/legal/layout.php';
