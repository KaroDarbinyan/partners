<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var yii\web\View $this */
/* @var bool $isFromPartners */
/* @var string $name */
/* @var string $email */
/* @var array $data */

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html style="width:100%;font-family:arial, 'helvetica neue', helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta name="x-apple-disable-message-reformatting">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="telephone=no" name="format-detection">
  <title>Boligvarsel</title>
  <!--[if (mso 16)]>
  <style type="text/css">
    a {
      text-decoration: none;
    }
  </style>
  <![endif]-->
  <!--[if gte mso 9]>
  <style>sup {
    font-size: 100% !important;
  }</style><![endif]-->
  <style type="text/css">
      @media only screen and (max-width: 600px) {
          p, ul li, ol li, a {
              font-size: 14px !important;
              line-height: 150% !important
          }

          h1 {
              font-size: 28px !important;
              text-align: center;
              line-height: 120% !important
          }

          h2 {
              font-size: 20px !important;
              text-align: center;
              line-height: 120% !important
          }

          h3 {
              font-size: 18px !important;
              text-align: center;
              line-height: 120% !important
          }

          h1 a {
              font-size: 28px !important
          }

          h2 a {
              font-size: 20px !important
          }

          h3 a {
              font-size: 18px !important
          }

          .es-menu td a {
              font-size: 12px !important
          }

          .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a {
              font-size: 16px !important
          }

          .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a {
              font-size: 16px !important
          }

          .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a {
              font-size: 12px !important
          }

          *[class="gmail-fix"] {
              display: none !important
          }

          .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 {
              text-align: center !important
          }

          .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 {
              text-align: right !important
          }

          .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 {
              text-align: left !important
          }

          .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img {
              display: inline !important
          }

          .es-button-border {
              display: inline-block !important
          }

          a.es-button {
              font-size: 13px !important;
              display: inline-block !important
          }

          .es-btn-fw {
              border-width: 10px 0px !important;
              text-align: center !important
          }

          .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right {
              width: 100% !important
          }

          .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header {
              width: 100% !important;
              max-width: 600px !important
          }

          .es-adapt-td {
              display: block !important;
              width: 100% !important
          }

          .adapt-img {
              width: 100% !important;
              height: auto !important
          }

          .es-m-p0 {
              padding: 0px !important
          }

          .es-m-p0r {
              padding-right: 0px !important
          }

          .es-m-p0l {
              padding-left: 0px !important
          }

          .es-m-p0t {
              padding-top: 0px !important
          }

          .es-m-p0b {
              padding-bottom: 0 !important
          }

          .es-m-p20b {
              padding-bottom: 20px !important
          }

          .es-mobile-hidden, .es-hidden {
              display: none !important
          }

          .es-desk-hidden {
              display: table-row !important;
              width: auto !important;
              overflow: visible !important;
              float: none !important;
              max-height: inherit !important;
              line-height: inherit !important
          }

          .es-desk-menu-hidden {
              display: table-cell !important
          }

          table.es-table-not-adapt, .esd-block-html table {
              width: auto !important
          }

          table.es-social {
              display: inline-block !important
          }

          table.es-social td {
              display: inline-block !important
          }
      }

      #outlook a {
          padding: 0;
      }

      .ExternalClass {
          width: 100%;
      }

      .ExternalClass,
      .ExternalClass p,
      .ExternalClass span,
      .ExternalClass font,
      .ExternalClass td,
      .ExternalClass div {
          line-height: 100%;
      }

      .es-button {
          mso-style-priority: 100 !important;
          text-decoration: none !important;
      }

      a[x-apple-data-detectors] {
          color: inherit !important;
          text-decoration: none !important;
          font-size: inherit !important;
          font-family: inherit !important;
          font-weight: inherit !important;
          line-height: inherit !important;
      }

      .es-desk-hidden {
          display: none;
          float: left;
          overflow: hidden;
          width: 0;
          max-height: 0;
          line-height: 0;
          mso-hide: all;
      }

      .es-button-border:hover {
          border-color: transparent transparent transparent transparent !important;
          background: transparent !important;
          border-style: solid solid solid solid !important;
      }

      .es-button-border:hover a.es-button {
          background: #ffd300 !important;
          border-color: #ffd300 !important;
      }

      td .es-button-border:hover a.es-button-1 {
          background: #ffffff !important;
          border-color: #ffffff !important;
          color: #000000 !important;
      }

      td .es-button-border-2:hover {
          background: #ffffff !important;
      }
  </style>
</head>
<body style="width:100%;font-family:arial, 'helvetica neue', helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
<div class="es-wrapper-color" style="background-color:#FFFFFF;">
  <!--[if gte mso 9]>
  <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
    <v:fill type="tile" color="#ffffff"></v:fill>
  </v:background>
  <![endif]-->
  <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0"
         style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;">
    <tr style="border-collapse:collapse;">
      <td valign="top" style="padding:0;Margin:0;">
          <?php if (!$isFromPartners): ?>
            <table cellpadding="0" cellspacing="0" class="es-footer" align="center"
                   style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top;">
              <tr style="border-collapse:collapse;">
                <td align="center" bgcolor="#4c4f58" style="padding:0;Margin:0;background-color:#4C4F58;">
                  <table bgcolor="#000000" class="es-footer-body" align="center" cellpadding="0" cellspacing="0"
                         width="600"
                         style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#000000;">
                    <tr style="border-collapse:collapse;">
                      <td align="left"
                          style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px;background-color:#000000;"
                          bgcolor="#000000">
                        <table cellpadding="0" cellspacing="0" width="100%"
                               style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                          <tr style="border-collapse:collapse;">
                            <td width="560" align="center" valign="top" style="padding:0;Margin:0;">
                              <table cellpadding="0" cellspacing="0" width="100%" role="presentation"
                                     style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                <tr style="border-collapse:collapse;">
                                  <td align="center" style="padding:0;Margin:0;font-size:0px;">
                                    <a target="_blank" href="https://partners.no"
                                       style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#FFFFFF;">
                                      <img src="https://partners.no/img/email-logo-white.jpg" alt
                                           style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;"
                                           width="85">
                                    </a>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          <?php endif ?>
        <table cellpadding="0" cellspacing="0" class="es-content" align="center"
               style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
          <tr style="border-collapse:collapse;">
            <td align="center" bgcolor="#4c4f58" style="padding:0;Margin:0;background-color:#4C4F58;">
              <table bgcolor="#000000" class="es-content-body" align="center" cellpadding="0" cellspacing="0"
                     width="600"
                     style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#000000;">
                  <?php if ($isFromPartners): ?>
                    <tr style="border-collapse:collapse;">
                      <td align="left" style="padding:0;Margin:0;">
                        <table cellpadding="0" cellspacing="0" width="100%"
                               style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                          <tr style="border-collapse:collapse;">
                            <td width="600" align="center" valign="top" style="padding:0;Margin:0;">
                              <table cellpadding="0" cellspacing="0" width="100%" role="presentation"
                                     style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                <tr style="border-collapse:collapse;">
                                  <td align="center" style="padding:0;Margin:0;font-size:0px;"><img class="adapt-img"
                                                                                                    src="https://partners.no//img/email-vip.jpg"
                                                                                                    alt
                                                                                                    style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;"
                                                                                                    width="600"></td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  <?php else: ?>
                    <tr style="border-collapse:collapse;">
                      <td align="left"
                          style="Margin:0;padding-bottom:10px;padding-top:20px;padding-left:20px;padding-right:20px;background-color:#000000;"
                          bgcolor="#000000">
                        <table cellpadding="0" cellspacing="0" width="100%"
                               style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                          <tr style="border-collapse:collapse;">
                            <td width="560" align="center" valign="top" style="padding:0;Margin:0;">
                              <table cellpadding="0" cellspacing="0" width="100%" role="presentation"
                                     style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                <tr style="border-collapse:collapse;">
                                  <td align="center" style="padding:0;Margin:0;padding-bottom:5px;"><h1
                                            style="Margin:0;line-height:36px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:30px;font-style:normal;font-weight:bold;color:#FFFFFF;">
                                      Partners Eiendomsmegling</h1></td>
                                </tr>
                                <tr style="border-collapse:collapse;">
                                  <td align="center" style="padding:0;Margin:0;padding-bottom:20px;"><p
                                            style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:26px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:31px;color:#FFFFFF;">
                                      Boligvarsel</p></td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr style="border-collapse:collapse;">
                      <td align="left" style="padding:0;Margin:0;">
                        <table cellpadding="0" cellspacing="0" width="100%"
                               style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                          <tr style="border-collapse:collapse;">
                            <td width="600" align="center" valign="top" style="padding:0;Margin:0;">
                              <table cellpadding="0" cellspacing="0" width="100%" role="presentation"
                                     style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                <tr style="border-collapse:collapse;">
                                  <td align="center" style="padding:0;Margin:0;font-size:0px;"><img class="adapt-img"
                                                                                                    src="https://partners.no/img/email-boligvarsel.jpg"
                                                                                                    alt
                                                                                                    style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;"
                                                                                                    width="600"></td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  <?php endif ?>

                <tr style="border-collapse:collapse;">
                  <td align="left" bgcolor="#000000"
                      style="Margin:0;padding-left:20px;padding-right:20px;padding-top:40px;padding-bottom:40px;background-color:#000000;">
                    <table cellpadding="0" cellspacing="0" width="100%"
                           style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                      <tr style="border-collapse:collapse;">
                        <td width="560" align="center" valign="top" style="padding:0;Margin:0;">
                          <table cellpadding="0" cellspacing="0" width="100%" role="presentation"
                                 style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                            <tr style="border-collapse:collapse;">
                              <td align="center" bgcolor="#000000" style="padding:0;Margin:0;">
                                <h2 style="Margin:0;line-height:29px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:24px;font-style:normal;font-weight:bold;color:#FFFFFF;margin-bottom:10px;">Hei <?= Inflector::humanize($name, true) ?></h2>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>

                <?php foreach ($data as $val): ?>
                  <tr style="border-collapse:collapse;">
                    <td align="left" bgcolor="#000000"
                        style="Margin:0;padding-left:20px;padding-right:20px;padding-top:40px;padding-bottom:40px;background-color:#000000;">
                      <table cellpadding="0" cellspacing="0" width="100%"
                             style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                        <tr style="border-collapse:collapse;">
                          <td width="560" align="center" valign="top" style="padding:0;Margin:0;">
                            <table cellpadding="0" cellspacing="0" width="100%" role="presentation"
                                   style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                              <tr style="border-collapse:collapse;">
                                <td align="center" bgcolor="#000000" style="padding:0;Margin:0;">
                                  <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:24px;color:#FFFFFF;">
                                    Her har du <?= count($val['properties']) ?> aktuelle eiendommer tilpasser dine
                                    søk:</p></td>
                              </tr>
                              <tr style="border-collapse:collapse;">
                                <td align="center" style="padding:0;Margin:0;padding-top:20px;">
                                  <div style="border:2px solid #FFFFFF;width:300px;padding:15px;">
                                    <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:27px;color:#FFFFFF;">
                                      <span style="font-weight:bold;">Pris:</span> <?= $val['subscription']->getCostRangeHumanize() ?>
                                    </p>
                                    <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:27px;color:#FFFFFF;">
                                      <span style="font-weight:bold;">Kvm fra:</span> <?= $val['subscription']->getAreaRangeHumanize() ?>
                                    </p>
                                    <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:27px;color:#FFFFFF;">
                                      <span style="font-weight:bold;">Type hjem:</span> <?= $val['subscription']->getPropertyTypesHumanize() ?>
                                    </p>
                                    <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:27px;color:#FFFFFF;">
                                      <span style="font-weight:bold;">Område:</span> <?= $val['subscription']->getRegionsHumanize() ?>
                                    </p>
                                    <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:27px;color:#FFFFFF;">
                                      <span style="font-weight:bold;">Soverom:</span> <?= $val['subscription']->getRoomsHumanize() ?></p>
                                  </div>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr style="border-collapse:collapse;">
                    <td align="left" bgcolor="#000000" style="padding:20px;Margin:0;background-color:#000000;">
                        <?php foreach ($val['properties'] as $key => $property): ?>
                            <?php if ($key % 2 === 0): ?>
                            <!--[if mso]>
                            <table width="560" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="275" valign="top"><![endif]-->
                            <?php else: ?>
                            <!--[if mso]></td>
                            <td width="10"></td>
                            <td width="275" valign="top"><![endif]-->
                            <?php endif ?>
                          <table cellpadding="0" cellspacing="0" class="es-<?= ($key % 2 === 0) ? 'left' : 'right' ?>"
                                 align="<?= ($key % 2 === 0) ? 'left' : 'right' ?>"
                                 style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:<?= ($key % 2 === 0) ? 'left' : 'right' ?>;margin-bottom:10px;">
                            <tr style="border-collapse:collapse;">
                              <td class="es-m-p20b" width="275" align="left" style="padding:0;Margin:0;">
                                <table width="100%" cellspacing="0" cellpadding="0"
                                       style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#000000;"
                                       bgcolor="#000000" role="presentation">
                                  <tr style="border-collapse:collapse;">
                                    <td align="center" style="padding:0;Margin:0;font-size:0;">
                                      <a href="<?= $property->path() ?>" target="_blank"
                                         style="color:#FFFFFF;text-decoration:none;">
                                        <img class="adapt-img" src="<?= $property->posterPath('275x206', '4c4f58') ?>"
                                             alt="<?= $property->kommunenavn ?>, <?= $property->adresse ?>"
                                             style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:275px;height: 206px;"
                                             width="275" height="206">
                                      </a>
                                    </td>
                                  </tr>
                                  <tr style="border-collapse:collapse;">
                                    <td align="left" bgcolor="#000000"
                                        style="Margin:0;padding-top:5px;padding-bottom:10px;padding-left:15px;padding-right:15px;border:1px solid #FFFFFF;border-top:0px;">
                                      <h3 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;color:#FFFFFF;margin:5px 0px;">
                                        <a href="<?= $property->path() ?>" target="_blank"
                                           style="color:#FFFFFF;text-decoration:none;">
                                            <?= StringHelper::truncate("$property->kommunenavn $property->adresse", 25) ?>
                                        </a>
                                      </h3>
                                      <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:12px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#FFFFFF;">
                                        <span style="font-weight:bold;">Pris:</span> <?= money($property->totalkostnadsomtall) ?>
                                      </p>
                                      <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:12px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#FFFFFF;"><?= $property->finn_eiendomstype ?>
                                        , <?= $property->prom ?>
                                        m²<?php if ($property->soverom): ?>, <?= $property->soverom ?> soverom<?php endif ?></p>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                            <?php if ($key % 2 === 1): ?>
                            <!--[if mso]></td></tr></table><![endif]-->
                            <?php endif ?>
                        <?php endforeach ?>
                    </td>
                  </tr>
                <?php endforeach ?>
                <tr style="border-collapse:collapse;">
                  <td align="left" bgcolor="#000000"
                      style="Margin:0;padding-top:10px;padding-bottom:15px;padding-left:20px;padding-right:20px;background-color:#000000;">
                    <table cellpadding="0" cellspacing="0" width="100%"
                           style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                      <tr style="border-collapse:collapse;">
                        <td width="560" align="center" valign="top" style="padding:0;Margin:0;">
                          <table cellpadding="0" cellspacing="0" width="100%" role="presentation"
                                 style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                            <tr style="border-collapse:collapse;">
                              <td align="center" style="padding:0;Margin:0;padding-bottom:10px;"><p
                                        style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:18px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:27px;color:#FFFFFF;">
                                  Virket dette interessant?</p></td>
                            </tr>
                              <?php if ($isFromPartners): ?>
                                <tr style="border-collapse:collapse;">
                                  <td align="center"
                                      style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:15px;padding-right:15px;">
                                    <span class="es-button-border es-button-border-2"
                                          style="border-style:solid;border-color:transparent;background:#02746A;border-width:0px;display:inline-block;border-radius:15px;width:auto;"><a
                                              href="https://partners.no/eiendommer" class="es-button es-button-1"
                                              target="_blank"
                                              style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:16px;color:#FFFFFF;border-style:solid;border-color:#02746A;border-width:20px 35px;display:inline-block;background:#02746A;border-radius:15px;font-weight:bold;font-style:normal;line-height:19px;width:auto;text-align:center;">Se flere eiendommer her</a></span>
                                  </td>
                                </tr>
                              <?php else: ?>
                                <tr style="border-collapse:collapse;">
                                  <td align="center"
                                      style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:15px;padding-right:15px;">
                                    <span class="es-button-border es-button-border-2"
                                          style="border-style:solid;border-color:transparent;background:#000000;border-width:0px;display:inline-block;border-radius:0px;width:auto;border:2px solid #FFFFFF;"><a
                                              href="https://partners.no/eiendommer" class="es-button es-button-1"
                                              target="_blank"
                                              style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:16px;color:#FFFFFF;border-style:solid;border-color:#000000;border-width:15px 40px;display:inline-block;background:#000000;border-radius:0px;font-weight:bold;font-style:normal;line-height:19px;width:auto;text-align:center;">Se flere eiendommer her</a></span>
                                  </td>
                                </tr>
                              <?php endif ?>
                            <tr style="border-collapse:collapse;">
                              <td align="center" style="padding:0;Margin:0;padding-top:15px;"><a
                                        href="https://www.partners.no" target="_blank"
                                        style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:16px;text-decoration:none;color:<?= $isFromPartners ? '#35A399' : '#3D85C6' ?>;font-style:italic;">www.partners.no</a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr style="border-collapse:collapse;">
                  <td align="left" bgcolor="#000000"
                      style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;background-color:#000000;">
                    <table cellpadding="0" cellspacing="0" width="100%"
                           style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                      <tr style="border-collapse:collapse;">
                        <td width="560" align="center" valign="top" style="padding:0;Margin:0;">
                          <table cellpadding="0" cellspacing="0" width="100%" role="presentation"
                                 style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                            <tr style="border-collapse:collapse;">
                              <td align="center" style="padding:0; Margin:0; padding-top:30px; padding-bottom:30px;">
                                <a href="<?= Url::toRoute(['forms/subscriptions', 'hash' => Yii::$app->getSecurity()->hashData($email, 'boligvarsling')]) ?>"
                                   target="_blank">
                                  Behandle abonnementene dine
                                </a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>
</body>
</html>