<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Newsbull</title>
    <style type="text/css">
        * {margin: 0; padding: 0; font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;}
        img {max-width: 100%;}
        body {-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none; width: 100%!important; height: 100%;}
        a { color: #5e8dcf; text-decoration: none;}

        .btn {
            text-decoration:none;
            color: #FFF;
            background-color: #5e8dcf;
            padding:7px 10px;
            text-align:center;
            cursor:pointer;
            display: inline-block;
        }

        .body-wrap { width: 100%;}
        .footer-wrap { width: 100%;	clear:both!important;}
        .footer-wrap .container .foot { border-top: 1px solid #ddd; padding-top: 30px;}
        .footer-wrap .container .content {padding-top: 0;}


        h1,h2,h3,h4,h5,h6 {font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;  }
        h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

        h1 { font-weight:200; font-size: 44px;}
        h2 { font-weight:200; font-size: 37px;}
        h3 { font-weight:500; font-size: 27px;}
        h4 { font-weight:500; font-size: 23px;}
        h5 { font-weight:900; font-size: 17px;}
        h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

        p, ul {
            margin-bottom: 10px;
            font-weight: normal;
            font-size:14px;
            line-height:1.6;
        }
        p.lead { font-size:17px; }
        p.small { font-size:12px; }

        ul li {
            margin-left:5px;
            list-style-position: inside;
        }

        .container {
            display:block!important;
            max-width:600px!important;
            margin:0 auto!important; /* makes it centered */
            clear:both!important;
        }

        .content {
            padding:15px;
            max-width:600px;
            margin:0 auto;
            display:block;
        }
        .content table { width: 100%; }
        .clear { display: block; clear: both; }

        @media only screen and (max-width: 600px) {
            a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}
            div[class="column"] { width: auto!important; float:none!important;}
            table.social div[class="column"] {
                width:auto!important;
            }
        }
    </style>
</head>
<body bgcolor="#FFFFFF">



<table class="body-wrap">
    <tr>
        <td class="container" bgcolor="#FFFFFF">
            <div class="content">
                <table cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td>
                            <?php $this->view($view); ?>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>

<table class="footer-wrap">
    <tr>
        <td class="container">
            <div class="content">
                <table class="foot" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td>
                            <p><a href="<?php echo base_url() ?>">Newsbull</a></p>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>
</body>
</html>