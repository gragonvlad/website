<?php
    header('Content-Type: application/xml');
    echo '<?xml version="1.0" encoding="UTF-8"?>', "\n";
    require_once(dirname(__FILE__) . '/common/code/boost.php');
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

<?php

// Returns true if the library is part of the current release of boost.

function xmlentities($text) {
    return str_replace(
        array('&', '<', '>', '"', "'"),
        array('&amp;', '&lt;', '&gt;', '&quot;', '&apos;'),
        $text);
}

function echo_sitemap_url($loc, $priority, $freq) {
    $loc_xml = isset($_SERVER['HTTP_HOST']) ?
            xmlentities("http://{$_SERVER['HTTP_HOST']}/{$loc}") :
            xmlentities("http://www.boost.org/{$loc}");

    echo <<<EOL
<url>
<loc>$loc_xml</loc>
<priority>$priority</priority>
<changefreq>$freq</changefreq>
</url>

EOL;
}

// Library list

echo_sitemap_url("doc/libs/", '1.0', 'daily');

// Library 'home pages'

$libs = BoostLibraries::load();
foreach ($libs->get_for_version(BoostVersion::current()) as $lib) {
    echo_sitemap_url("doc/libs/release/$lib[documentation]", '1.0', 'daily');
}

?>
</urlset>
