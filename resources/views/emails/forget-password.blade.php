<html><head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Password Reset</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <link href="https://fonts.googleapis.com/css?family=Rajdhani:400,600,700&amp;display=swap" rel="stylesheet">
  
    <style type="text/css">
  
    /**
     * Avoid browser level font resizing.
     * 1. Windows Mobile
     * 2. iOS / OSX
     */
    body,
    table,
    td,
    a {
      -ms-text-size-adjust: 100%; /* 1 */
      -webkit-text-size-adjust: 100%; /* 2 */
    }
    /**
     * Remove extra space added to tables and cells in Outlook.
     */
    table,
    td {
      mso-table-rspace: 0pt;
      mso-table-lspace: 0pt;
    }
    /**
     * Better fluid images in Internet Explorer.
     */
    img {
      -ms-interpolation-mode: bicubic;
    }
    /**
     * Remove blue links for iOS devices.
     */
    a[x-apple-data-detectors] {
      font-family: inherit !important;
      font-size: inherit !important;
      font-weight: inherit !important;
      line-height: inherit !important;
      color: inherit !important;
      text-decoration: none !important;
    }
    /**
     * Fix centering issues in Android 4.4.
     */
    div[style*="margin: 16px 0;"] {
      margin: 0 !important;
    }
    body {
      font-family: 'Rajdhani', sans-serif;
      width: 100% !important;
      height: 100% !important;
      padding: 0 !important;
      margin: 0 !important;
    }
    /**
     * Collapse table borders to avoid space between cells.
     */
    table {
      border-collapse: collapse !important;
    }
    a {
      color: #1a82e2;
    }
    img {
      height: auto;
      line-height: 100%;
      text-decoration: none;
      border: 0;
      outline: none;
    }
    </style>
  
  </head>
  <body style="background-color: #e9ecef;">
  
    <!-- start preheader -->
    <div class="preheader" style="display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0;">
      A preheader is the short summary text that follows the subject line when an email is viewed in the inbox.
    </div>
    <!-- end preheader -->
  
    <!-- start body -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
  
      <!-- start logo -->
      <tbody><tr>
        <td align="center" bgcolor="#e9ecef">
          <!--[if (gte mso 9)|(IE)]>
          <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
          <tr>
          <td align="center" valign="top" width="600">
          <![endif]-->
          <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
            <tbody><tr>
              <td align="center" valign="top" style="padding: 36px 24px;">
                <a href="{{url('')}}" target="_blank" style="display: inline-block;">
                    <img class="img-fluid" src="{{isset(getSetting()['site_logo']) ? getSetting()['site_logo'] : asset('01-logo.png') }}" alt="{{isset(getSetting()['site_name']) ? getSetting()['site_name'] : 'Logo' }}">
                </a>
              </td>
            </tr>
          </tbody></table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
          </tr>
          </table>
          <![endif]-->
        </td>
      </tr>
      <!-- end logo -->
  
      <!-- start hero -->
      <tr>
        <td align="center" bgcolor="#e9ecef">
          <!--[if (gte mso 9)|(IE)]>
          <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
          <tr>
          <td align="center" valign="top" width="600">
          <![endif]-->
          <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
            <tbody><tr>
              <td align="left" bgcolor="#ffffff" style="padding: 36px 24px 0; font-family: 'Rajdhani', sans-serif; border-top: 3px solid #d4dadf;">
                <h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">Reset Your Password</h1>
              </td>
            </tr>
          </tbody></table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
          </tr>
          </table>
          <![endif]-->
        </td>
      </tr>
      <!-- end hero -->
  
      <!-- start copy block -->
      <tr>
        <td align="center" bgcolor="#e9ecef">
          <!--[if (gte mso 9)|(IE)]>
          <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
          <tr>
          <td align="center" valign="top" width="600">
          <![endif]-->
          <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
  
            <!-- start copy -->
            <tbody><tr>
              <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Rajdhani', sans-serif; font-size: 16px; line-height: 24px;">
                <p style="margin: 0;">Tap the button below to reset your customer account password. If you didn't request a new password, you can safely delete this email.</p>
              </td>
            </tr>
            <!-- end copy -->
  
            <!-- start button -->
            <tr>
              <td align="left" bgcolor="#ffffff">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tbody><tr>
                    <td align="center" bgcolor="#ffffff" style="padding: 12px;">
                      <table border="0" cellpadding="0" cellspacing="0">
                        <tbody><tr>
                          <td align="center" bgcolor="#fe4536">
                            <a target="_blank" style="display: inline-block; padding: 16px 36px; font-family: 'Rajdhani', sans-serif; font-size: 16px; color: #ffffff; text-decoration: none; " href="{{url('/reset-password?token='.$maildata['link'])}}">Reset Password</a>

                          </td>
                        </tr>
                      </tbody></table>
                    </td>
                  </tr>
                </tbody></table>
              </td>
            </tr>
            <!-- end button -->
  
            <!-- start copy -->
            <tr>
              <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Rajdhani', sans-serif; font-size: 16px; line-height: 24px;">
                <p style="margin: 0;">If that doesn't work, copy and paste the following link in your browser:</p>
                <p style="margin: 0;"><a href="{{url('/reset-password?token='.$maildata['link'])}}" target="_blank">{{url('/reset-password?token='.$maildata['link'])}}</a></p>
              </td>
            </tr>
            <!-- end copy -->
  
            <!-- start copy -->
            <tr>
              <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family: 'Rajdhani', sans-serif; font-size: 16px; line-height: 24px; border-bottom: 3px solid #d4dadf">
                <p style="margin: 0;">Cheers,<br> Paste</p>
              </td>
            </tr>
            <!-- end copy -->
  
          </tbody></table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
          </tr>
          </table>
          <![endif]-->
        </td>
      </tr>
      <!-- end copy block -->
  
      <!-- start footer -->
      <tr>
        <td align="center" bgcolor="#e9ecef" style="padding: 24px;">
          <!--[if (gte mso 9)|(IE)]>
          <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
          <tr>
          <td align="center" valign="top" width="600">
          <![endif]-->
          <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
  
            <!-- start permission -->
            <tbody><tr>
              <td align="center" bgcolor="#e9ecef" style="padding: 12px 24px; font-family: 'Rajdhani', sans-serif; font-size: 14px; line-height: 20px; color: #666;">
                <p style="margin: 0;">You received this email because we received a request for [type_of_action] for your account. If you didn't request [type_of_action] you can safely delete this email.</p>
              </td>
            </tr>
            <!-- end permission -->
  
            <!-- start unsubscribe -->
            <tr>
              <td align="center" bgcolor="#e9ecef" style="padding: 12px 24px; font-family: 'Rajdhani', sans-serif; font-size: 14px; line-height: 20px; color: #666;">
                <p style="margin: 0;">To stop receiving these emails, you can <a href="#" target="_blank">unsubscribe</a> at any time.</p>
                <p style="margin: 0;">1223, Main Street, Anytown New York, 38000 USA</p>
              </td>
            </tr>
            <!-- end unsubscribe -->
  
          </tbody></table>
          <!--[if (gte mso 9)|(IE)]>
          </td>
          </tr>
          </table>
          <![endif]-->
        </td>
      </tr>
      <!-- end footer -->
  
    </tbody></table>
    <!-- end body -->
  
  
  </body></html>