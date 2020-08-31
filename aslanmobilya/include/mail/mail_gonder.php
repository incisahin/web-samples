<?php

function MailGonder_Ikincil($GonderilecekAdres, $GonderenMail, $GonderenAdi, $Mesaj ){

	Global $db;
	include 'class.phpmailer.php';

	$m = $db->query("SELECT * FROM site_mailserver WHERE Varsayilan = '1' LIMIT 1")->fetch(PDO::FETCH_OBJ);
	if($m){
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->Host = $m->Host;
		$mail->Port = 587;
		$mail->Username = $m->Username;
		$mail->Password = $m->Password;
		$mail->SetFrom(	$m->Username, $m->SetFromName );
		$mail->AddAddress( $m->Username, $m->SetFromName );
		$mail->AddAddress( $GonderilecekAdres, $m->SetFromName );
		$mail->CharSet = 'UTF-8';
		$mail->Subject = 'Web Site İletişim Mesajı';
		$mail->MsgHTML( hmtl( $GonderenMail, $GonderenAdi, $Mesaj, $m->SetFromName ) );
		if($mail->Send()) { return 'ok'; }
		else { return 'Mesaj gönderirken bir hata oluştu ve girmiş olduğunuz bilgiler alınamadı.' . $mail->ErrorInfo;}
	}else{
		return "Veritabanı mail server hatası.";
	}
}

function MailGonder($GonderenMail, $GonderenAdi, $Mesaj ){

	Global $db;
	include 'class.phpmailer.php';

	$m = $db->query("SELECT * FROM site_mailserver WHERE Varsayilan = '1' LIMIT 1")->fetch(PDO::FETCH_OBJ);
	if($m){
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->Host = $m->Host;
		$mail->Port = 587;;
		$mail->Username = $m->Username;
		$mail->Password = $m->Password;
		$mail->SetFrom( $mail->Username, $m->SetFromName );
		$mail->AddAddress( $m->Username, $m->SetFromName );
		if( !empty($m->Username_2) ){
			$mail->AddAddress( $m->Username_2, $m->SetFromName );
		}
		$mail->CharSet = 'UTF-8';
		$mail->Subject = 'Web Site İletişim Mesajı';
		$mail->MsgHTML( hmtl( $GonderenMail, $GonderenAdi, $Mesaj, $m->SetFromName ) );
		if($mail->Send()) { return 'ok'; }
		else { return 'Mesaj gönderirken bir hata oluştu ve girmiş olduğunuz bilgiler alınamadı.' . $mail->ErrorInfo;}
	}else{
		return "Veritabanı mail server hatası.";
	}
}


function hmtl($GonderenMail, $GonderenAdi, $Mesaj, $HtmlBaslik ){

	$x = '<!DOCTYPE html>
<html>

<head>
  <title>'.$HtmlBaslik.'</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <style type="text/css">
    body,
    table,
    td,
    a {
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }

    table,
    td {
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
    }

    img {
      -ms-interpolation-mode: bicubic;
    }

    img {
      border: 0;
      height: auto;
      line-height: 100%;
      outline: none;
      text-decoration: none;
    }

    table {
      border-collapse: collapse !important;
    }

    body {
      height: 100% !important;
      margin: 0 !important;
      padding: 0 !important;
      width: 100% !important;
    }

    a[x-apple-data-detectors] {
      color: inherit !important;
      text-decoration: none !important;
      font-size: inherit !important;
      font-family: inherit !important;
      font-weight: inherit !important;
      line-height: inherit !important;
    }

    @media screen and (max-width: 480px) {
      .mobile-hide {
        display: none !important;
      }

      .mobile-center {
        text-align: center !important;
      }
    }

    /* ANDROID CENTER FIX */
    div[style*="margin: 16px 0;"] {
      margin: 0 !important;
    }
  </style>

  <body style="margin: 0 !important; padding: 0 !important; background-color: #eeeeee;" bgcolor="#eeeeee">
    <!-- HIDDEN PREHEADER TEXT -->
    <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Open Sans, Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">'.$HtmlBaslik.'
    </div>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td align="center" style="background-color: #eeeeee;" bgcolor="#eeeeee">
          <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
            <tr>
              <td align="center" valign="top" style="font-size:0; padding: 35px;" bgcolor="#ff7361">

                <h1 style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 30px; font-weight: 800; line-height: 42px; margin: 0; color: #ffffff;">İletişim Sayfası Mesajı</h1>

              </td>
            </tr>
            <tr>
              <td align="center" style="padding: 35px; background-color: #ffffff;" bgcolor="#ffffff">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                  <tr>
                    <td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px; border-bottom: 3px solid #eeeeee;">
                      <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;"> <small>Gönderen Adı:</small> <b>'.$GonderenAdi.'</b> </p>
                      <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;"> <small>Gönderen Mail:</small> <b>'.$GonderenMail.'</b> </p>
                      <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;"> <small>Gönderen Mesajı:</small> </p>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" style="padding: 25px 0;">
                      <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-bottom: 15px; border-bottom: 3px solid #eeeeee;">'.$Mesaj.'</td>
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
  </body>

  </html>
';

return $x;
}



function htmlkodu($GonderenMail, $GonderenAdi, $Mesaj, $HtmlBaslik ){

	$x = '<!doctype html>
	<html>
	<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>'.$HtmlBaslik.'</title>
	<style>
	/* -------------------------------------
	GLOBAL RESETS
	------------------------------------- */

	/*All the styling goes here*/

	img {
		border: none;
		-ms-interpolation-mode: bicubic;
		max-width: 100%;
	}
	body {
		background-color: #f6f6f6;
		font-family: sans-serif;
		-webkit-font-smoothing: antialiased;
		font-size: 14px;
		line-height: 1.4;
		margin: 0;
		padding: 0;
		-ms-text-size-adjust: 100%;
		-webkit-text-size-adjust: 100%;
	}
	table {
		border-collapse: separate;
		mso-table-lspace: 0pt;
		mso-table-rspace: 0pt;
		width: 100%; }
		table td {
			font-family: sans-serif;
			font-size: 14px;
			vertical-align: top;
		}
		/* -------------------------------------
		BODY & CONTAINER
		------------------------------------- */
		.body {
			background-color: #f6f6f6;
			width: 100%;
		}
		/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
		.container {
			display: block;
			margin: 0 auto !important;
			/* makes it centered */
			max-width: 580px;
			padding: 10px;
			width: 580px;
		}
		/* This should also be a block element, so that it will fill 100% of the .container */
		.content {
			box-sizing: border-box;
			display: block;
			margin: 0 auto;
			max-width: 580px;
			padding: 10px;
		}
		/* -------------------------------------
		HEADER, FOOTER, MAIN
		------------------------------------- */
		.main {
			background: #ffffff;
			border-radius: 3px;
			width: 100%;
		}
		.wrapper {
			box-sizing: border-box;
			padding: 20px;
		}
		.content-block {
			padding-bottom: 10px;
			padding-top: 10px;
		}
		.footer {
			clear: both;
			margin-top: 10px;
			text-align: center;
			width: 100%;
		}
		.footer td,
		.footer p,
		.footer span,
		.footer a {
			color: #999999;
			font-size: 12px;
			text-align: center;
		}
		/* -------------------------------------
		TYPOGRAPHY
		------------------------------------- */
		h1,
		h2,
		h3,
		h4 {
			color: #000000;
			font-family: sans-serif;
			font-weight: 400;
			line-height: 1.4;
			margin: 0;
			margin-bottom: 30px;
		}
		h1 {
			font-size: 35px;
			font-weight: 300;
			text-align: center;
			text-transform: capitalize;
		}
		p,
		ul,
		ol {
			font-family: sans-serif;
			font-size: 14px;
			font-weight: normal;
			margin: 0;
			margin-bottom: 15px;
		}
		p li,
		ul li,
		ol li {
			list-style-position: inside;
			margin-left: 5px;
		}
		a {
			color: #3498db;
			text-decoration: underline;
		}
		/* -------------------------------------
		BUTTONS
		------------------------------------- */
		.btn {
			box-sizing: border-box;
			width: 100%; }
			.btn > tbody > tr > td {
				padding-bottom: 15px; }
				.btn table {
					width: auto;
				}
				.btn table td {
					background-color: #ffffff;
					border-radius: 5px;
					text-align: center;
				}
				.btn a {
					background-color: #ffffff;
					border: solid 1px #3498db;
					border-radius: 5px;
					box-sizing: border-box;
					color: #3498db;
					cursor: pointer;
					display: inline-block;
					font-size: 14px;
					font-weight: bold;
					margin: 0;
					padding: 12px 25px;
					text-decoration: none;
					text-transform: capitalize;
				}
				.btn-primary table td {
					background-color: #3498db;
				}
				.btn-primary a {
					background-color: #3498db;
					border-color: #3498db;
					color: #ffffff;
				}
				/* -------------------------------------
				OTHER STYLES THAT MIGHT BE USEFUL
				------------------------------------- */
				.last {
					margin-bottom: 0;
				}
				.first {
					margin-top: 0;
				}
				.align-center {
					text-align: center;
				}
				.align-right {
					text-align: right;
				}
				.align-left {
					text-align: left;
				}
				.clear {
					clear: both;
				}
				.mt0 {
					margin-top: 0;
				}
				.mb0 {
					margin-bottom: 0;
				}
				.preheader {
					color: transparent;
					display: none;
					height: 0;
					max-height: 0;
					max-width: 0;
					opacity: 0;
					overflow: hidden;
					mso-hide: all;
					visibility: hidden;
					width: 0;
				}
				.powered-by a {
					text-decoration: none;
				}
				hr {
					border: 0;
					border-bottom: 1px solid #f6f6f6;
					margin: 20px 0;
				}
				/* -------------------------------------
				RESPONSIVE AND MOBILE FRIENDLY STYLES
				------------------------------------- */
				@media only screen and (max-width: 620px) {
					table[class=body] h1 {
						font-size: 28px !important;
						margin-bottom: 10px !important;
					}
					table[class=body] p,
					table[class=body] ul,
					table[class=body] ol,
					table[class=body] td,
					table[class=body] span,
					table[class=body] a {
						font-size: 16px !important;
					}
					table[class=body] .wrapper,
					table[class=body] .article {
						padding: 10px !important;
					}
					table[class=body] .content {
						padding: 0 !important;
					}
					table[class=body] .container {
						padding: 0 !important;
						width: 100% !important;
					}
					table[class=body] .main {
						border-left-width: 0 !important;
						border-radius: 0 !important;
						border-right-width: 0 !important;
					}
					table[class=body] .btn table {
						width: 100% !important;
					}
					table[class=body] .btn a {
						width: 100% !important;
					}
					table[class=body] .img-responsive {
						height: auto !important;
						max-width: 100% !important;
						width: auto !important;
					}
				}
				/* -------------------------------------
				PRESERVE THESE STYLES IN THE HEAD
				------------------------------------- */
				@media all {
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
					.apple-link a {
						color: inherit !important;
						font-family: inherit !important;
						font-size: inherit !important;
						font-weight: inherit !important;
						line-height: inherit !important;
						text-decoration: none !important;
					}
        #MessageViewBody a {
					color: inherit;
					text-decoration: none;
					font-size: inherit;
					font-family: inherit;
					font-weight: inherit;
					line-height: inherit;
				}
				.btn-primary table td:hover {
					background-color: #34495e !important;
				}
				.btn-primary a:hover {
					background-color: #34495e !important;
					border-color: #34495e !important;
				}
			}
			</style>
			</head>
			<body class="">
			<span class="preheader">'.$GonderenAdi.' kişisinden e-posta aldınız.</span>
			<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
			<tr>
			<td>&nbsp;</td>
			<td class="container">
			<div class="content">

			<!-- START CENTERED WHITE CONTAINER -->
			<table role="presentation" class="main">

			<!-- START MAIN CONTENT AREA -->
			<tr>
			<td class="wrapper">
			<table role="presentation" border="0" cellpadding="0" cellspacing="0">
			<tr>
			<td>
			Mesaj Gönderen Adı : '.$GonderenAdi.'
			</td>
			<td>
			Mesaj Gönderen Epostası : '.$GonderenMail.'
			</td>
			</tr>
			<tr>
			<td colspan="2">
			<p>'.$Mesaj.'</p>
			</td>
			</tr>
			</table>
			</td>
			</tr>

			<!-- END MAIN CONTENT AREA -->
			</table>
			<!-- END CENTERED WHITE CONTAINER -->

			</div>
			</td>
			<td>&nbsp;</td>
			</tr>
			</table>
			</body>
			</html>';

			return $x;
		}

		?>
