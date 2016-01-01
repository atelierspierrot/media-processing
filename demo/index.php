<?php

/**
 * Show errors at least initially
 *
 * `E_ALL` => for hard dev
 * `E_ALL & ~E_STRICT` => for hard dev in PHP5.4 avoiding strict warnings
 * `E_ALL & ~E_NOTICE & ~E_STRICT` => classic setting
 */
@ini_set('display_errors', '1'); @error_reporting(E_ALL);
//@ini_set('display_errors','1'); @error_reporting(E_ALL & ~E_STRICT);
//@ini_set('display_errors','1'); @error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

/**
 * Set a default timezone to avoid PHP5 warnings
 */
$dtmz = @date_default_timezone_get();
date_default_timezone_set($dtmz?:'Europe/Paris');

/**
 * For security, transform a realpath as '/[***]/package_root/...'
 *
 * @param string $path
 * @param int $depth_from_root
 *
 * @return string
 */
function _getSecuredRealPath($path, $depth_from_root = 1)
{
    $ds = DIRECTORY_SEPARATOR;
    $parts = explode($ds, realpath('.'));
    for ($i=0; $i<=$depth_from_root; $i++) {
        array_pop($parts);
    }
    return str_replace(join($ds, $parts), $ds.'[***]', $path);
}

/**
 * GET arguments settings
 */
$arg_ln = isset($_GET['ln']) ? $_GET['ln'] : 'en';
$arg_dir = isset($_GET['dir']) ? rtrim($_GET['dir'], '/').'/' : 'media/';
$arg_root = isset($_GET['root']) ? $_GET['root'] : __DIR__;
$arg_i = isset($_GET['i']) ? $_GET['i'] : 0;

// namespaces
$autoloader = '../vendor/autoload.php';
if (file_exists($autoloader)) {
    require_once $autoloader;
} else {
    die('You need to run Composer on the package to install dependencies');
}

function getPhpClassManualLink($class_name, $ln='en')
{
    return sprintf('http://php.net/manual/%s/class.%s.php', $ln, strtolower($class_name));
}

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Test & documentation of PHP "MediaProcessing" package</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="assets/html5boilerplate/css/normalize.css" />
    <link rel="stylesheet" href="assets/html5boilerplate/css/main.css" />
    <script src="assets/html5boilerplate/js/vendor/modernizr-2.6.2.min.js"></script>
	<link rel="stylesheet" href="assets/styles.css" />
</head>
<body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

    <header id="top" role="banner">
        <hgroup>
            <h1>The PHP "<em>MediaProcessing</em>" package</h1>
            <h2 class="slogan">a collection of classes to manage web files and directories and loop over their contents.</h2>
        </hgroup>
        <div class="hat">
            <p>These pages show and demonstrate the use and functionality of the <a href="https://github.com/atelierspierrot/media-processing">atelierspierrot/media-processing</a> PHP package you just downloaded.</p>
        </div>
    </header>

	<nav>
		<h2>Map of the package</h2>
        <ul id="navigation_menu" class="menu" role="navigation">
            <li><a href="index.php">Homepage</a></li>
            <li><a href="index.php#usage">Usage</a></li>
            <li><a href="index.php#MediaFile">MediaFile</a></li>
            <li><a href="index.php#ImageFilter">ImageFilter</a></li>
        </ul>

        <div class="info">
            <p><a href="https://github.com/atelierspierrot/media-processing">See online on GitHub</a></p>
            <p class="comment">The sources of this plugin are hosted on <a href="http://github.com">GitHub</a>. To follow sources updates, report a bug or read opened bug tickets and any other information, please see the GitHub website above.</p>
        </div>

    	<p class="credits" id="user_agent"></p>
	</nav>

    <div id="content" role="main">

        <article>

    <h1>Tests of PHP <em>MediaProcessing</em> package</h1>

    <h2 id="notes">First notes</h2>
    <p>All these classes works in a PHP version 5.3 minus environment. They are included in the <em>Namespace</em> <strong>MediaProcessing</strong>.</p>
    <p>For clarity, the examples below are NOT written as a working PHP code when it seems not necessary. For example, rather than write <var>echo "my_string";</var> we would write <var>echo my_string</var> or rather than <var>var_export($data);</var> we would write <var>echo $data</var>. The main code for these classes'usage is written strictly.</p>
    <p>As a reminder, and because it's always useful, have a look at the <a href="http://pear.php.net/manual/<?php echo $arg_ln; ?>/standards.php">PHP common coding standards</a>.</p>

	<h2 id="tests">Tests & documentation</h2>
    
    <h3 id="usage">Including the <em>MediaProcessing</em> package in your work</h3>

    <p>As the package classes names are built following the <a href="https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md">PHP Framework Interoperability Group recommandations</a>, we use the <a href="https://gist.github.com/jwage/221634">SplClassLoader</a> to load package classes. The loader is included in the package but you can use your own.</p>
    <p>But this package requires some dependencies to work, so you need to use <a href="http://getcomposer.org/" title="See online">Composer</a> and include its autoloader:</p>

    <pre class="code" data-language="php">
<?php
echo '~$ path/to/composer.phar install'."\n";
echo '...'."\n";
echo "\n";
echo '&lt;?php'."\n"
    .'require_once "path/to/package/vendor/autoload.php";'."\n";
?>
    </pre>

    <h3 id="MediaFile">Test of class <em>MediaProcessing\MediaFile</em> class</h3>

    <pre class="code" data-language="php">
<?php
$test_img = 'media/plant3.jpg';
$test_noext = 'media/test1234';

foreach (array($test_img, $test_noext) as $_f) {
    $a = new \MediaProcessing\MediaFile($_f, null, __DIR__);
    echo 'object : '.var_export($a, 1)."\n";
    echo 'filename : '.$a->getFilename()."\n";
    echo 'file basename : '.$a->getBasename()."\n";
    echo 'file extension : '.$a->getExtension()."\n";
    echo 'file guess extension : '.$a->guessExtension()."\n";
    echo 'file basename without extension : '.$a->getFilenameWithoutExtension()."\n";
    echo 'file real path : '.$a->getRealPath()."\n";
    echo 'file size : '.$a->getSize()."\n";
    echo 'file size human readable : '.$a->getHumanSize()."\n";
    echo 'file stats : '.var_export($a->getStat(), 1)."\n";
    echo 'file aTime as DateTime : '.var_export($a->getATimeAsDatetime(), 1)."\n";
    echo 'file cTime as DateTime : '.var_export($a->getCTimeAsDatetime(), 1)."\n";
    echo 'file mTime as DateTime : '.var_export($a->getMTimeAsDatetime(), 1)."\n";
    echo 'file is image ? : '.var_export($a->isImage(), 1)."\n";
    echo 'file mime type ? : '.$a->getMime()."\n";
    echo "\n\n";
}
?>
    </pre>

    <h3 id="ImageFilter">Test of class <em>MediaProcessing\ImageFilter\ImageFilter</em> class</h3>

    <pre class="code" data-language="php">
<?php
$test_img = 'media/plant1.jpg';
$_img = new \MediaProcessing\ImageFilter\ImageFilter(__DIR__.'/'.$test_img, null, 'resize', array('max_width'=>200, 'max_height'=>200));
$_result = $_img->process()->getTargetWebPath();
echo '$test_img = "media/plant1.jpg";'."\n";
echo '$_img = new \MediaProcessing\ImageFilter\ImageFilter('."\n"
    ."\t".'__DIR__."/".$test_img, null, "resize", array("max_width"=>200,"max_height"=>200)'."\n"
    .');'."\n";
echo '$_result = $_img->process()->getTargetWebPath();'."\n\n";
var_export($_img);
?>
    </pre>
    
    <p>Initial image was:</p>
    <a href="<?php echo $test_img; ?>"><img src="<?php echo $test_img; ?>" /></a>
    
    <p>Resized result is:</p>
    <a href="<?php echo $_result; ?>"><img src="<?php echo $_result; ?>" /></a>

        </article>
    </div>

    <footer id="footer">
		<div class="credits float-left">
		    This page is <a href="" title="Check now online" id="html_validation">HTML5</a> & <a href="" title="Check now online" id="css_validation">CSS3</a> valid.
		</div>
		<div class="credits float-right">
		    <a href="https://github.com/atelierspierrot/media-processing">atelierspierrot/media-processing</a> package by <a href="https://github.com/piwi">Piero Wbmstr</a> under <a href="http://www.apache.org/licenses/LICENSE-2.0">Apache 2.0</a> license.
		</div>
    </footer>

    <div class="back_menu" id="short_navigation">
        <a href="#" title="See navigation menu" id="short_menu_handler"><span class="text">Navigation Menu</span></a>
        &nbsp;|&nbsp;
        <a href="#top" title="Back to the top of the page"><span class="text">Back to top&nbsp;</span>&uarr;</a>
        <ul id="short_menu" class="menu" role="navigation"></ul>
    </div>

    <div id="message_box" class="msg_box"></div>

<!-- jQuery lib -->
<script src="assets/js/jquery-1.9.1.min.js"></script>

<!-- HTML5 boilerplate -->
<script src="assets/html5boilerplate/js/plugins.js"></script>

<!-- jQuery.highlight plugin -->
<script src="assets/js/highlight.js"></script>

<!-- scripts for demo -->
<script src="assets/scripts.js"></script>

<script>
$(function() {
    initBacklinks();
    activateMenuItem();
    getToHash();
    buildFootNotes();
    addCSSValidatorLink('assets/styles.css');
    addHTMLValidatorLink();
    $("#user_agent").html( navigator.userAgent );
    $('pre.code').highlight({source:0, indent:'tabs', code_lang: 'data-language'});
});
</script>
</body>
</html>
