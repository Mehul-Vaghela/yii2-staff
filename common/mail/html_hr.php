<?php
use yii\helpers\Html;
use common\models\System;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<header>
    <div style="width: 623px; overflow: hidden; background-color: #ffffff;">
        <img src="<?=Html::encode(System::getDomainAsLink()."/images/email/email-header.png")?>" alt="<?=Html::encode(System::getDomain())?> logo"/>
    </div>
</header>
<div style="width: 623px; padding-top: 15px; padding-bottom: 30px; text-align: justify; color: #666666;">
    <?= $content ?>
</div>
<div style="width: 623px; overflow: hidden; background-color: #ffffff;">
    <p>
        <strong>HR BioGiene</strong><br/>
        <strong>BioGiene Pty Ltd</strong> | Tailored Hygiene Services & Systems<br/>
        <strong>QLD</strong> Tel: +61  (7) 3217 3108 | Fax: +61 (7) 3392 0911<br/> 
        Email: <a href="mailto:hr@biogiene.com.au">hr@biogiene.com.au</a> | Web: <a href="http://www.biogiene.com.au">www.biogiene.com.au</a>
    </p>
    <img src="<?=Html::encode(System::getDomainAsLink()."/images/email/email-footer.jpg")?>"/>
    <p>
        <small>
            The information contained in this email message & attachments are confidential and may be legally privileged. If you are not the intended recipient, please note that any use, dissemination, distribution, or reproduction of this message in any form whatsoever, is prohibited. If you received this email in error, please call us on +61 2 9087 8210 or notify by return email, delete your copy, and accept my apologies for any inconvenience caused. Please note that your receipt of this email from BioGiene email address does not constitute BioGiene consent for you to send any other electronic information on behalf of BioGiene, unless specifically stated otherwise. Thank you.
        </small>
    </p>
</div>