<?php

/** @var $this yii\web\View */
/** @var $form Forms */

/** @var $properties array */

use common\models\Forms;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="x-apple-disable-message-reformatting"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style type="text/css">
        body,
        .maintable {
            height: 100% !important;
            width: 100% !important;
            margin: 0;
            padding: 0;
        }

        img,
        a img {
            border: 0;
            outline: none;
            text-decoration: none;
        }

        p {
            margin-top: 0;
            margin-right: 0;
            margin-left: 0;
            padding: 0;
        }

        .ReadMsgBody {
            width: 100%;
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

        img {
            -ms-interpolation-mode: bicubic;
        }

        body,
        table,
        td,
        p,
        a,
        li,
        blockquote {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
    </style>
    <style type="text/css">
        @media only screen and (max-width: 480px) {
            .rtable {
                width: 100% !important;
            }

            .rtable tr {
                height: auto !important;
                display: block;
            }

            .contenttd {
                max-width: 100% !important;
                display: block;
                width: auto !important;
            }

            .contenttd:after {
                content: "";
                display: table;
                clear: both;
            }

            .hiddentds {
                display: none;
            }

            .imgtable,
            .imgtable table {
                max-width: 100% !important;
                height: auto;
                float: none;
                margin: 0 auto;
            }

            .imgtable.btnset td {
                display: inline-block;
            }

            .imgtable img {
                width: 100%;
                height: auto !important;
                display: block;
            }

            table {
                float: none;
            }

            .mobileHide {
                display: none !important;
            }
        }

        @media only screen and (min-width: 481px) {
            .desktopHide {
                display: none !important;
            }
        }
    </style>
</head>
<body style="overflow: auto; padding:0; margin:0; font-size: 14px; font-family: arial, helvetica, sans-serif; cursor:auto; background-color:#e6e6e6">
<table cellspacing="0" cellpadding="0" width="100%" bgcolor="#e6e6e6">
    <tr>
        <td style="font-size: 0px; height: 0px; line-height: 0"></td>
    </tr>
    <tr>
        <td valign="top">
            <table class="rtable" style="width: 600px; margin: 0px auto" cellspacing="0" cellpadding="0" width="600"
                   align="center" border="0">
                <tr>
                    <th class="contenttd"
                        style="border-top: medium none; border-right: medium none; width: 600px; border-bottom: medium none; font-weight: normal; padding-bottom: 0px; text-align: left; padding-top: 0px; padding-left: 0px; border-left: medium none; padding-right: 0px; background-color: #feffff">
                        <table style="WIDTH: 100%" cellspacing="0" cellpadding="0" align="left"
                               data-hidewhenresp="0">
                            <tr style="HEIGHT: 106px" height="106">
                                <th class="contenttd"
                                    style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 98px; VERTICAL-ALIGN: middle; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 7px; TEXT-ALIGN: left; PADDING-TOP: 7px; PADDING-LEFT: 15px; BORDER-LEFT: medium none; PADDING-RIGHT: 15px; BACKGROUND-COLOR: transparent">
                                    <!--[if gte mso 12]>
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td align="center">
                                    <![endif]-->
                                    <table class="imgtable" style="MARGIN: 0px auto" cellspacing="0" cellpadding="0"
                                           align="center" border="0">
                                        <tr>
                                            <td style="PADDING-BOTTOM: 2px; PADDING-TOP: 2px; PADDING-LEFT: 2px; PADDING-RIGHT: 2px"
                                                align="center">
                                                <table cellspacing="0" cellpadding="0" border="0">
                                                    <tr>
                                                        <td
                                                                style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent">
                                                            <img title="logo"
                                                                 style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; DISPLAY: block"
                                                                 alt="logo"
                                                                 src="http://schala-ringeliste.domains.involve.no/img/email-logo.png"
                                                                 width="88" hspace="0"
                                                                 vspace="0"/></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--[if gte mso 12]>
                                    </td></tr></table>
                                    <![endif]-->
                                </th>
                                <th class="contenttd"
                                    style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 442px; VERTICAL-ALIGN: middle; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 7px; TEXT-ALIGN: left; PADDING-TOP: 7px; PADDING-LEFT: 15px; BORDER-LEFT: medium none; PADDING-RIGHT: 15px; BACKGROUND-COLOR: transparent">
                                    <p style="FONT-SIZE: 30px; MARGIN-BOTTOM: 0px; FONT-FAMILY: trebuchet ms, helvetica, sans-serif; MARGIN-TOP: 0px; COLOR: #2d2d2d; TEXT-ALIGN: center; LINE-HEIGHT: 46px; BACKGROUND-COLOR: transparent; mso-line-height-rule: exactly"
                                       align="center"><strong>PARTNERS EIENDOMSMEGLING</strong></p>
                                </th>
                            </tr>
                        </table>
                    </th>
                </tr>
                <tr>
                    <th class="contenttd"
                        style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: #feffff">
                        <table style="WIDTH: 100%" cellspacing="0" cellpadding="0" align="left"
                               data-hidewhenresp="0">
                            <tr style="HEIGHT: 26px" height="26">
                                <th class="contenttd"
                                    style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; VERTICAL-ALIGN: top; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: transparent">
                                    <!--[if gte mso 12]>
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td align="center">
                                    <![endif]-->
                                    <table class="imgtable" style="MARGIN: 0px auto" cellspacing="0" cellpadding="0"
                                           align="center" border="0">
                                        <tr>
                                            <td style="PADDING-BOTTOM: 0px; PADDING-TOP: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px"
                                                align="center">
                                                <table cellspacing="0" cellpadding="0" border="0">
                                                    <tr>
                                                        <td
                                                                style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent">
                                                            <img title="lin"
                                                                 style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; DISPLAY: block"
                                                                 alt="lin"
                                                                 src="http://schala-ringeliste.domains.involve.no/img/email-line-top.png"
                                                                 width="495" hspace="0"
                                                                 vspace="0"/></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--[if gte mso 12]>
                                    </td></tr></table>
                                    <![endif]-->
                                </th>
                            </tr>
                        </table>
                    </th>
                </tr>
                <tr>
                    <th class="contenttd"
                        style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: #feffff">
                        <table style="WIDTH: 100%" cellspacing="0" cellpadding="0" align="left"
                               data-hidewhenresp="0">
                            <tr style="HEIGHT: 237px" height="237">
                                <th class="contenttd"
                                    style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; VERTICAL-ALIGN: top; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: transparent">
                                    <!--[if gte mso 12]>
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td align="center">
                                    <![endif]-->
                                    <table class="imgtable" style="MARGIN: 0px auto" cellspacing="0" cellpadding="0"
                                           align="center" border="0">
                                        <tr>
                                            <td style="PADDING-BOTTOM: 0px; PADDING-TOP: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px"
                                                align="center">
                                                <table cellspacing="0" cellpadding="0" border="0">
                                                    <tr>
                                                        <td
                                                                style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent">
                                                            <img title="Boligvarsling"
                                                                 style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; DISPLAY: block"
                                                                 alt="Boligvarsling"
                                                                 src="http://schala-ringeliste.domains.involve.no/img/email-header.jpg"
                                                                 width="600" hspace="0"
                                                                 vspace="0"/></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--[if gte mso 12]>
                                    </td></tr></table>
                                    <![endif]-->
                                </th>
                            </tr>
                        </table>
                    </th>
                </tr>
                <tr>
                    <th class="contenttd"
                        style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: #feffff">
                        <table style="WIDTH: 100%" cellspacing="0" cellpadding="0" align="left"
                               data-hidewhenresp="0">
                            <tr style="HEIGHT: 26px" height="26">
                                <th class="contenttd"
                                    style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; VERTICAL-ALIGN: top; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: transparent">
                                    <!--[if gte mso 12]>
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td align="center">
                                    <![endif]-->
                                    <table class="imgtable" style="MARGIN: 0px auto" cellspacing="0" cellpadding="0"
                                           align="center" border="0">
                                        <tr>
                                            <td style="PADDING-BOTTOM: 0px; PADDING-TOP: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px"
                                                align="center">
                                                <table cellspacing="0" cellpadding="0" border="0">
                                                    <tr>
                                                        <td
                                                                style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent">
                                                            <img title="lin"
                                                                 style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; DISPLAY: block"
                                                                 alt="lin"
                                                                 src="http://schala-ringeliste.domains.involve.no/img/email-line-bottom.png"
                                                                 width="495"
                                                                 hspace="0" vspace="0"/></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--[if gte mso 12]>
                                    </td></tr></table>
                                    <![endif]-->
                                </th>
                            </tr>
                        </table>
                    </th>
                </tr>
                <tr>
                    <th class="contenttd"
                        style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: #feffff">
                        <table style="WIDTH: 100%" cellspacing="0" cellpadding="0" align="left"
                               data-hidewhenresp="0">
                            <tr style="HEIGHT: 158px" height="158">
                                <th class="contenttd"
                                    style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 570px; VERTICAL-ALIGN: top; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 15px; TEXT-ALIGN: left; PADDING-TOP: 15px; PADDING-LEFT: 15px; BORDER-LEFT: medium none; PADDING-RIGHT: 15px; BACKGROUND-COLOR: transparent">
                                    <p style="FONT-SIZE: 24px; MARGIN-BOTTOM: 1em; FONT-FAMILY: trebuchet ms, helvetica, sans-serif; MARGIN-TOP: 0px; COLOR: #2d2d2d; TEXT-ALIGN: center; LINE-HEIGHT: 32px; BACKGROUND-COLOR: transparent; mso-line-height-rule: exactly"
                                       align="center">
                                        <strong>Hei, <?= $form->name ?></strong></p>
                                    <p style="FONT-SIZE: 18px; MARGIN-BOTTOM: 0px; FONT-FAMILY: trebuchet ms, helvetica, sans-serif; MARGIN-TOP: 0px; COLOR: #2d2d2d; TEXT-ALIGN: left; LINE-HEIGHT: 24px; BACKGROUND-COLOR: transparent; mso-line-height-rule: exactly"
                                       align="left">
                                        Her har du <strong><?= count($properties['for_sale']) ?></strong> aktuelle
                                        eiendommer tilpasset dine søk:<br/>
                                        Pris: <?php if ($form->cost_to): ?><?= $form->cost_from ?>-<?= $form->cost_to ?><?php else: ?>ALLE<?php endif ?> NOK, Prom:
                                        <?php if ($form->area_to): ?><?= $form->area_from ?>-<?= $form->area_to ?><?php else: ?>ALLE<?php endif ?>m<sup>2</sup>.</p>
                                </th>
                            </tr>
                        </table>
                    </th>
                </tr>
                <tr>
                    <th class="contenttd"
                        style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: #feffff">
                        <table style="WIDTH: 100%" cellspacing="0" cellpadding="0" align="left"
                               data-hidewhenresp="0">
                            <tr style="HEIGHT: 26px" height="26">
                                <th class="contenttd"
                                    style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; VERTICAL-ALIGN: top; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: transparent">
                                    <!--[if gte mso 12]>
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td align="center">
                                    <![endif]-->
                                    <table class="imgtable" style="MARGIN: 0px auto" cellspacing="0" cellpadding="0"
                                           align="center" border="0">
                                        <tr>
                                            <td style="PADDING-BOTTOM: 0px; PADDING-TOP: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px"
                                                align="center">
                                                <table cellspacing="0" cellpadding="0" border="0">
                                                    <tr>
                                                        <td
                                                                style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent">
                                                            <img title="lin"
                                                                 style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; DISPLAY: block"
                                                                 alt="lin" src="http://schala-ringeliste.domains.involve.no/img/email-line-bottom.png" width="495"
                                                                 hspace="0" vspace="0"/></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--[if gte mso 12]>
                                    </td></tr></table>
                                    <![endif]-->
                                </th>
                            </tr>
                        </table>
                    </th>
                </tr>
                <?php if (isset($properties['for_sale']) && count($properties['for_sale']) > 0): ?>
                    <tr>
                        <td class="contenttd"
                            style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: #feffff">
                            <table style="WIDTH: 100%" cellspacing="0" cellpadding="0" align="left"
                                   data-hidewhenresp="0">
                                <?php foreach ($properties['for_sale'] as $key => $property): ?>
                                    <?php if ($key % 2 === 0): ?>
                                        <tr style="HEIGHT: 305px" height="305">
                                    <?php endif ?>
                                        <td class="contenttd"
                                            style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 270px; VERTICAL-ALIGN: top; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 20px; TEXT-ALIGN: left; PADDING-TOP: 20px; PADDING-LEFT: 15px; BORDER-LEFT: medium none; PADDING-RIGHT: 15px; BACKGROUND-COLOR: transparent">
                                            <p style="FONT-SIZE: 18px; MARGIN-BOTTOM: 0px; FONT-FAMILY: trebuchet ms, helvetica, sans-serif; MARGIN-TOP: 0px; COLOR: #2d2d2d; LINE-HEIGHT: 28px; BACKGROUND-COLOR: transparent; mso-line-height-rule: exactly">
                                                <a href="https://partners.no/annonse/<?= $property->id ?>" style="color: #2d2d2d"><strong style="color: #2d2d2d"><?= $property->kommunenavn ?> <?= $property->area ?></strong></a>
                                            </p>
                                            <!--[if gte mso 12]>
                                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                <tr>
                                                    <td align="center">
                                            <![endif]-->
                                            <table class="imgtable" style="MARGIN: 0px auto" cellspacing="0"
                                                   cellpadding="0"
                                                   align="center" border="0">
                                                <tr>
                                                    <td style="PADDING-BOTTOM: 7px; PADDING-TOP: 7px; PADDING-LEFT: 2px; PADDING-RIGHT: 2px"
                                                        align="center">
                                                        <table cellspacing="0" cellpadding="0" border="0">
                                                            <tr>
                                                                <td
                                                                        style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent">
                                                                    <a href="https://partners.no/annonse/<?= $property->id ?>">
                                                                        <img title="<?= $property->kommunenavn ?>, <?= $property->adresse ?>"
                                                                             style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; DISPLAY: block"
                                                                             alt="<?= $property->kommunenavn ?>, <?= $property->adresse ?>"
                                                                             src="<?= $property->propertyImage->urlstorthumbnail ?>"
                                                                             width="264" hspace="0"
                                                                             vspace="0"/></a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!--[if gte mso 12]>
                                            </td></tr></table>
                                            <![endif]-->
                                            <p style="FONT-SIZE: 16px; MARGIN-BOTTOM: 0px; FONT-FAMILY: trebuchet ms, helvetica, sans-serif; text-align: left; MARGIN-TOP: 0px; COLOR: #2d2d2d; LINE-HEIGHT: 22px; BACKGROUND-COLOR: transparent; mso-line-height-rule: exactly"
                                               align="center">
                                                <?= $property->adresse ?><br/>
                                                <?= $property->prom ?> m&sup2; / <?= $property->finn_eiendomstype ?>
                                                <br/>
                                                <strong><?= number_format($property->totalkostnadsomtall, 0, ' ', ' '); ?></strong>
                                            </p>
                                        </td>
                                    <?php if ($key % 2 === 1): ?>
                                        </tr>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th class="contenttd"
                            style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: #feffff">
                            <table style="WIDTH: 100%" cellspacing="0" cellpadding="0" align="left"
                                   data-hidewhenresp="0">
                                <tr style="HEIGHT: 26px" height="26">
                                    <th class="contenttd"
                                        style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; VERTICAL-ALIGN: top; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: transparent">
                                        <!--[if gte mso 12]>
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td align="center">
                                        <![endif]-->
                                        <table class="imgtable" style="MARGIN: 0px auto" cellspacing="0" cellpadding="0"
                                               align="center" border="0">
                                            <tr>
                                                <td style="PADDING-BOTTOM: 0px; PADDING-TOP: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px"
                                                    align="center">
                                                    <table cellspacing="0" cellpadding="0" border="0">
                                                        <tr>
                                                            <td
                                                                    style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent">
                                                                <img title="lin"
                                                                     style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; DISPLAY: block"
                                                                     alt="lin"
                                                                     src="http://schala-ringeliste.domains.involve.no/img/email-line-top.png"
                                                                     width="495" hspace="0" vspace="0"/></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <!--[if gte mso 12]>
                                        </td></tr></table>
                                        <![endif]-->
                                    </th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                <?php endif ?>
                <tr>
                    <th class="contenttd"
                        style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: #feffff">
                        <table style="WIDTH: 100%" cellspacing="0" cellpadding="0" align="left"
                               data-hidewhenresp="0">
                            <tr style="HEIGHT: 54px" height="54">
                                <th class="contenttd"
                                    style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 570px; VERTICAL-ALIGN: top; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 15px; TEXT-ALIGN: left; PADDING-TOP: 15px; PADDING-LEFT: 15px; BORDER-LEFT: medium none; PADDING-RIGHT: 15px; BACKGROUND-COLOR: transparent">
                                    <p style="FONT-SIZE: 18px; MARGIN-BOTTOM: 0px; FONT-FAMILY: trebuchet ms, helvetica, sans-serif; MARGIN-TOP: 0px; COLOR: #2d2d2d; TEXT-ALIGN: center; LINE-HEIGHT: 24px; BACKGROUND-COLOR: transparent; mso-line-height-rule: exactly"
                                       align="center"><strong>Vil du ha mer?</strong></p>
                                </th>
                            </tr>
                        </table>
                    </th>
                </tr>
                <tr>
                    <th class="contenttd"
                        style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: #feffff">
                        <table style="WIDTH: 100%" cellspacing="0" cellpadding="0" align="left"
                               data-hidewhenresp="0">
                            <tr style="HEIGHT: 62px" height="62">
                                <th class="contenttd"
                                    style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; VERTICAL-ALIGN: top; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: transparent">
                                    <!--[if gte mso 12]>
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td align="center">
                                    <![endif]-->
                                    <table class="imgtable" style="MARGIN: 0px auto" cellspacing="0" cellpadding="0"
                                           align="center" border="0">
                                        <tr>
                                            <td style="PADDING-BOTTOM: 10px; PADDING-TOP: 10px; PADDING-LEFT: 10px; PADDING-RIGHT: 10px"
                                                align="center">
                                                <table cellspacing="0" cellpadding="0" border="0">
                                                    <tr>
                                                        <td
                                                                style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent">
                                                            <a href="https://partners.no/eiendommer/"
                                                               target="_blank"><img
                                                                        title="Se mer boliger på nettside"
                                                                        style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; DISPLAY: block"
                                                                        alt="Se mer boliger på nettside"
                                                                        src="http://schala-ringeliste.domains.involve.no/img/email-se-mer.png"
                                                                        width="201" hspace="0" vspace="0"/></a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--[if gte mso 12]>
                                    </td></tr></table>
                                    <![endif]-->
                                </th>
                            </tr>
                        </table>
                    </th>
                </tr>
                <?php if (isset($properties['sales']) && count($properties['sales']) > 0): ?>
                    <tr>
                        <th class="contenttd"
                            style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: #feffff">
                            <table style="WIDTH: 100%" cellspacing="0" cellpadding="0" align="left"
                                   data-hidewhenresp="0">
                                <tr style="HEIGHT: 54px" height="54">
                                    <th class="contenttd"
                                        style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 570px; VERTICAL-ALIGN: top; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 15px; TEXT-ALIGN: left; PADDING-TOP: 15px; PADDING-LEFT: 15px; BORDER-LEFT: medium none; PADDING-RIGHT: 15px; BACKGROUND-COLOR: transparent">
                                        <p style="FONT-SIZE: 18px; MARGIN-BOTTOM: 0px; FONT-FAMILY: trebuchet ms, helvetica, sans-serif; MARGIN-TOP: 0px; COLOR: #2d2d2d; TEXT-ALIGN: center; LINE-HEIGHT: 24px; BACKGROUND-COLOR: transparent; mso-line-height-rule: exactly"
                                           align="center"><strong>Vare solgt <?= count($properties['sales']) ?>
                                                eiendommer:</strong></p>
                                    </th>
                                </tr>
                            </table>
                        </th>
                    </tr>
                    <tr>
                        <td class="contenttd"
                            style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: #feffff">
                                <table style="WIDTH: 100%" cellspacing="0" cellpadding="0" align="left"
                                       data-hidewhenresp="0">
                                    <?php foreach (array_slice($properties['sales'], 0, 10) as $key => $property): ?>
                                        <?php if ($key % 2 === 0): ?>
                                            <tr style="HEIGHT: 305px" height="305">
                                        <?php endif ?>
                                        <td class="contenttd"
                                            style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 270px; VERTICAL-ALIGN: top; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 20px; TEXT-ALIGN: left; PADDING-TOP: 20px; PADDING-LEFT: 15px; BORDER-LEFT: medium none; PADDING-RIGHT: 15px; BACKGROUND-COLOR: transparent">
                                            <p style="FONT-SIZE: 18px; MARGIN-BOTTOM: 0px; FONT-FAMILY: trebuchet ms, helvetica, sans-serif; MARGIN-TOP: 0px; COLOR: #2d2d2d; LINE-HEIGHT: 28px; BACKGROUND-COLOR: transparent; mso-line-height-rule: exactly">
                                                <a href="https://partners.no/annonse/<?= $property->id ?>" style="color: #2d2d2d"><strong style="color: #2d2d2d"><?= $property->kommunenavn ?> <?= $property->area ?></strong></a>
                                            </p>
                                            <!--[if gte mso 12]>
                                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                <tr>
                                                    <td align="center">
                                            <![endif]-->
                                            <table class="imgtable" style="MARGIN: 0px auto" cellspacing="0"
                                                   cellpadding="0"
                                                   align="center" border="0">
                                                <tr>
                                                    <td style="PADDING-BOTTOM: 7px; PADDING-TOP: 7px; PADDING-LEFT: 2px; PADDING-RIGHT: 2px"
                                                        align="center">
                                                        <table cellspacing="0" cellpadding="0" border="0">
                                                            <tr>
                                                                <td
                                                                        style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent">
                                                                    <a href="https://partners.no/annonse/<?= $property->id ?>">
                                                                        <img title="<?= $property->kommunenavn ?>, <?= $property->adresse ?>"
                                                                             style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; DISPLAY: block"
                                                                             alt="<?= $property->kommunenavn ?>, <?= $property->adresse ?>"
                                                                             src="<?= $property->propertyImage->urlstorthumbnail ?>"
                                                                             width="264" hspace="0"
                                                                             vspace="0"/></a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!--[if gte mso 12]>
                                            </td></tr></table>
                                            <![endif]-->
                                            <p style="FONT-SIZE: 16px; MARGIN-BOTTOM: 0px; FONT-FAMILY: trebuchet ms, helvetica, sans-serif; text-align: left; MARGIN-TOP: 0px; COLOR: #2d2d2d; LINE-HEIGHT: 22px; BACKGROUND-COLOR: transparent; mso-line-height-rule: exactly"
                                               align="center">
                                                <?= $property->adresse ?><br/>
                                                <?= $property->prom ?> m&sup2; / <?= $property->finn_eiendomstype ?>
                                                <br/>
                                                <strong><?= number_format($property->totalkostnadsomtall, 0, ' ', ' '); ?></strong>
                                            </p>
                                        </td>
                                        <?php if ($key % 2 === 1): ?>
                                            </tr>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </table>
                        </td>
                    </tr>
                <?php endif ?>
                <tr>
                    <th class="contenttd"
                        style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: #feffff">
                        <table style="WIDTH: 100%" cellspacing="0" cellpadding="0" align="left"
                               data-hidewhenresp="0">
                            <tr style="HEIGHT: 26px" height="26">
                                <th class="contenttd"
                                    style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; VERTICAL-ALIGN: top; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: transparent">
                                    <!--[if gte mso 12]>
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td align="center">
                                    <![endif]-->
                                    <table class="imgtable" style="MARGIN: 0px auto" cellspacing="0" cellpadding="0"
                                           align="center" border="0">
                                        <tr>
                                            <td style="PADDING-BOTTOM: 0px; PADDING-TOP: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px"
                                                align="center">
                                                <table cellspacing="0" cellpadding="0" border="0">
                                                    <tr>
                                                        <td
                                                                style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BACKGROUND-COLOR: transparent">
                                                            <img title="lin"
                                                                 style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; DISPLAY: block"
                                                                 alt="lin"
                                                                 src="http://schala-ringeliste.domains.involve.no/img/email-line-top.png"
                                                                 width="495" hspace="0" vspace="0"/></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--[if gte mso 12]>
                                    </td></tr></table>
                                    <![endif]-->
                                </th>
                            </tr>
                        </table>
                    </th>
                </tr>
                <tr>
                    <th class="contenttd"
                        style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: #feffff">
                        <table style="WIDTH: 100%" cellspacing="0" cellpadding="0" align="left"
                               data-hidewhenresp="0">
                            <tr style="HEIGHT: 66px" height="66">
                                <th class="contenttd"
                                    style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 214px; VERTICAL-ALIGN: middle; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 7px; TEXT-ALIGN: left; PADDING-TOP: 7px; PADDING-LEFT: 15px; BORDER-LEFT: medium none; PADDING-RIGHT: 15px; BACKGROUND-COLOR: transparent">
                                    <p style="FONT-SIZE: 16px; MARGIN-BOTTOM: 0px; FONT-FAMILY: trebuchet ms, helvetica, sans-serif; MARGIN-TOP: 0px; COLOR: #2d2d2d; TEXT-ALIGN: left; LINE-HEIGHT: 22px; BACKGROUND-COLOR: transparent; mso-line-height-rule: exactly"
                                       align="left"><em><a href="https://partners.no" target="_blank">partners.no</a></em>
                                    </p>
                                </th>
                            </tr>
                        </table>
                    </th>
                </tr>
                <tr>
                    <th class="contenttd"
                        style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 600px; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 0px; TEXT-ALIGN: left; PADDING-TOP: 0px; PADDING-LEFT: 0px; BORDER-LEFT: medium none; PADDING-RIGHT: 0px; BACKGROUND-COLOR: transparent">
                        <table style="WIDTH: 100%" cellspacing="0" cellpadding="0" align="left"
                               data-hidewhenresp="0">
                            <tr style="HEIGHT: 37px" height="37">
                                <th class="contenttd"
                                    style="BORDER-TOP: medium none; BORDER-RIGHT: medium none; WIDTH: 570px; VERTICAL-ALIGN: middle; BORDER-BOTTOM: medium none; FONT-WEIGHT: normal; PADDING-BOTTOM: 12px; TEXT-ALIGN: left; PADDING-TOP: 12px; PADDING-LEFT: 15px; BORDER-LEFT: medium none; PADDING-RIGHT: 15px; BACKGROUND-COLOR: transparent"
                                    colspan="2">
                                    <div>
                                        <p style="FONT-SIZE: 10px; MARGIN-BOTTOM: 0px; FONT-FAMILY: arial, helvetica, sans-serif; MARGIN-TOP: 0px; COLOR: #575757; TEXT-ALIGN: center; LINE-HEIGHT: 14px; BACKGROUND-COLOR: transparent; mso-line-height-rule: exactly"
                                           align="center"><a
                                                    href="https://partners.no/unsubscribe/<?= $form->id ?>/<?= md5($form->id . $form->email) ?>"
                                                    style="color: black; font-size: 16px;"
                                            >
                                                Avslutt abonnementet
                                            </a>
                                        </p>
                                    </div>
                                </th>
                            </tr>
                        </table>
                    </th>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="FONT-SIZE: 0px; HEIGHT: 8px; LINE-HEIGHT: 0">&nbsp;</td>
    </tr>
</table>
</body>
</html>