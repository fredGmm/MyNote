<?php

/* @var $this \yii\web\View */
/* @var $content string */

?>


<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" href="http://www.j-book.cn/wp-content/themes/gk-portfolio/favicon2.ico">
<!--    <script src="https://cdn.bootcss.com/jquery/1.8.3/jquery.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://www.j-book.cn/wp-content/themes/gk-portfolio/gmm/css/style.css">
    <script type="text/javascript" src="http://www.j-book.cn/wp-content/themes/gk-portfolio/gmm/js/script.js"></script>
    <!--[if lt IE 9]>
    <script src="http://www.j-book.cn/wp-content/themes/gk-portfolio/js/html5.js"></script>
    <![endif]-->
    <title>卷书网 &#8211; 别致的推书小站</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link href="" rel="stylesheet">
    <link rel='dns-prefetch' href='//www.j-book.cn' />
    <link rel="alternate" type="application/rss+xml" title="卷书网 &raquo; Feed" href="http://www.j-book.cn/feed" />
    <link rel="alternate" type="application/rss+xml" title="卷书网 &raquo; 评论Feed" href="http://www.j-book.cn/comments/feed" />

    <style type="text/css">
        img.wp-smiley,
        img.emoji {
            display: inline !important;
            border: none !important;
            box-shadow: none !important;
            height: 1em !important;
            width: 1em !important;
            margin: 0 .07em !important;
            vertical-align: -0.1em !important;
            background: none !important;
            padding: 0 !important;
        }
    </style>
    <link rel='stylesheet' id='portfolio-normalize-css' href='http://www.j-book.cn/wp-content/themes/gk-portfolio/css/normalize.css?ver=4.9.4' type='text/css' media='all' />
    <link rel='stylesheet' id='portfolio-fonts-css' href='http://fonts.googleapis.com/css?family=Open+Sans%3A700&#038;ver=4.9.4' type='text/css' media='all' />
    <link rel='stylesheet' id='portfolio-fonts-body-css' href='http://fonts.googleapis.com/css?family=Open+Sans%3A400&#038;ver=4.9.4' type='text/css' media='all' />
    <link rel='stylesheet' id='portfolio-font-awesome-css' href='http://www.j-book.cn/wp-content/themes/gk-portfolio/css/font.awesome.css?ver=4.0.3' type='text/css' media='all' />
    <link rel='stylesheet' id='portfolio-style-css' href='http://www.j-book.cn/wp-content/themes/gk-portfolio/style.css?ver=4.9.4' type='text/css' media='all' />
    <!--[if lt IE 9]>
    <link rel='stylesheet' id='portfolio-ie8-css'  href='http://www.j-book.cn/wp-content/themes/gk-portfolio/css/ie8.css?ver=4.9.4' type='text/css' media='all' />
    <![endif]-->
    <!--[if IE 9]>
    <link rel='stylesheet' id='portfolio-ie9-css'  href='http://www.j-book.cn/wp-content/themes/gk-portfolio/css/ie9.css?ver=4.9.4' type='text/css' media='all' />
    <![endif]-->
<!--    <script type='text/javascript' src='http://www.j-book.cn/wp-includes/js/jquery/jquery.js?ver=1.12.4'></script>-->
    <script type='text/javascript' src='http://www.j-book.cn/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.4.1'></script>
    <link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://www.j-book.cn/xmlrpc.php?rsd" />
    <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://www.j-book.cn/wp-includes/wlwmanifest.xml" />
    <meta name="generator" content="WordPress 4.9.4" />
    <!-- <meta name="NextGEN" version="3.0.8" /> -->
    <style type="text/css">
        body {
            font-family:
        }

        .site-title {
            font-family:
        }

        .site-main #page {
            max-width: 1260px;
        }

        #primary,
        #comments,
        .author-info,
        .attachment #primary,
        .site-content.archive #gk-search,
        .search-no-results .page-content {
            width: 700px;
        }


        a,
        a.inverse:active,
        a.inverse:focus,
        a.inverse:hover,
        button,
        input[type="submit"],
        input[type="button"],
        input[type="reset"],
        .entry-summary .readon,
        .comment-author .fn,
        .comment-author .url,
        .comment-reply-link,
        .comment-reply-login,
        #content .tags-links a:active,
        #content .tags-links a:focus,
        #content .tags-links a:hover,
        .nav-menu li a:active,
        .nav-menu li a:focus,
        .nav-menu li a:hover,
        ul.nav-menu ul a:hover,
        .nav-menu ul ul a:hover,
        .gk-social-buttons a:hover:before,
        .format-gallery .entry-content .page-links a:hover,
        .format-audio .entry-content .page-links a:hover,
        .format-status .entry-content .page-links a:hover,
        .format-video .entry-content .page-links a:hover,
        .format-chat .entry-content .page-links a:hover,
        .format-quote .entry-content .page-links a:hover,
        .page-links a:hover,
        .paging-navigation a:active,
        .paging-navigation a:focus,
        .paging-navigation a:hover,
        .comment-meta a:hover,
        .social-menu li:hover:before,
        .social-menu-topbar li:hover:before,
        .entry-title a:hover {
            color: #5cc1a9;
        }

        button,
        input[type="submit"],
        input[type="button"],
        input[type="reset"],
        .entry-summary .readon {
            border: 1px solid #5cc1a9;
        }

        body .nav-menu .current_page_item>a,
        body .nav-menu .current_page_ancestor>a,
        body .nav-menu .current-menu-item>a,
        body .nav-menu .current-menu-ancestor>a {
            border-color: #5cc1a9;
            color: #5cc1a9 !important;
        }

        .format-status .entry-content .page-links a,
        .format-gallery .entry-content .page-links a,
        .format-chat .entry-content .page-links a,
        .format-quote .entry-content .page-links a,
        .page-links a {
            background: #5cc1a9;
            border-color: #5cc1a9;
        }

        .hentry .mejs-controls .mejs-time-rail .mejs-time-current,
        .comment-post-author,
        .sticky .post-preview:after,
        .entry-header.sticky:after,
        .article-helper.sticky:after,
        #prev-post>a:hover,
        #next-post>a:hover {
            background: #5cc1a9;
        }

        .comments-title>span,
        .comment-reply-title>span {
            border-bottom-color: #5cc1a9;
        }

        .site-header,
        .home-link>img {
            height: auto;
            max-height: none;
        }

        .article-helper {
            height: 380px;
        }

        .site-content.archive article {
            height: 416px;
        }

        .post-preview {
            padding: 56px 36px 36px 36px;
        }

        @media (max-width: 1140px) {
            .site-content.archive article {
                height: 336px;
            }

            .article-helper {
                height: 320px;
            }

            .post-preview {
                padding: 20px 16px 36px 16px;
            }
        }
    </style>
    <style type="text/css">
        .site-content.archive article {
            width: 25%;
        }
    </style>
    <style type="text/css">
        body.custom-background #main {
            background-color: #f1f1f1;
        }
    </style>
    <style type="text/css" id="wp-custom-css">
        .archive-title {
            display: none
        }
    </style>

    <?= \yii\helpers\Html::csrfMetaTags() ?>


    <?php $this->head() ?>
</head>

<body class="home blog">
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
