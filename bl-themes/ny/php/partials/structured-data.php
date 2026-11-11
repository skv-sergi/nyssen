<?php defined('BLUDIT') or die('Bludit CMS.');
// Structured data (JSON-LD) for search engines and AI assistants, included in the <head> by index.php.
// Every page describes the business (Nyssen), the person behind it and the website. About pages
// add a ProfilePage, and blog posts add a BlogPosting. Browsers don't run JSON-LD, so it needs no CSP nonce.
// Check changes with https://validator.schema.org/ or https://search.google.com/test/rich-results

// Plain text for JSON: Bludit stores titles and descriptions with HTML entities
function structuredDataText($text)
{
    return trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($text), ENT_QUOTES, 'UTF-8')));
}

$sdHome = DOMAIN_BASE;
$sdBusinessId = $sdHome . '#business';
$sdPersonId = $sdHome . '#person';
$sdWebsiteId = $sdHome . '#website';

// The four services, in the same order as the Services page
$sdServices = array();
$sdServiceKeys = $pages->getChildren('services');
usort($sdServiceKeys, function ($a, $b) {
    return (new Page($a))->position() - (new Page($b))->position();
});
foreach ($sdServiceKeys as $sdKey) {
    try {
        $sdService = new Page($sdKey);
    } catch (Exception $e) {
        continue;
    }
    if (!$sdService->published() && !$sdService->isStatic()) {
        continue;
    }
    $sdServices[] = array(
        '@type' => 'Offer',
        'itemOffered' => array(
            '@type' => 'Service',
            'name' => structuredDataText($sdService->title()),
            'description' => structuredDataText($sdService->description()),
            'url' => $sdService->permalink(),
            'provider' => array('@id' => $sdBusinessId),
        ),
    );
}

$sdPerson = array(
    '@type' => 'Person',
    '@id' => $sdPersonId,
    'name' => 'Sergi Duran Nyssen',
    'jobTitle' => 'Digital Accessibility Specialist and Consultant',
    'url' => DOMAIN_PAGES . 'about',
    'email' => 'mailto:hello@nyssen.me',
    'worksFor' => array('@id' => $sdBusinessId),
    'knowsAbout' => array(
        'Digital accessibility',
        'Web Content Accessibility Guidelines (WCAG) 2.2',
        'Accessibility auditing and testing',
        'Accessible documents and PDF remediation',
        'Accessible web design and development',
        'Accessibility training',
    ),
);
if ($site->linkedin()) {
    $sdPerson['sameAs'] = array($site->linkedin());
}

$sdBusiness = array(
    '@type' => 'ProfessionalService',
    '@id' => $sdBusinessId,
    'name' => 'Nyssen',
    'url' => $sdHome,
    'description' => structuredDataText($site->description()),
    'email' => 'mailto:hello@nyssen.me',
    'logo' => DOMAIN_THEME . 'assets/images/share.png',
    'image' => DOMAIN_THEME . 'assets/images/share.png',
    'founder' => array('@id' => $sdPersonId),
    'hasOfferCatalog' => array(
        '@type' => 'OfferCatalog',
        'name' => 'Digital accessibility services',
        'itemListElement' => $sdServices,
    ),
);
if ($site->instagram()) {
    $sdBusiness['sameAs'] = array($site->instagram());
}

$sdGraph = array(
    $sdBusiness,
    $sdPerson,
    array(
        '@type' => 'WebSite',
        '@id' => $sdWebsiteId,
        'name' => 'Nyssen',
        'url' => $sdHome,
        'inLanguage' => 'en-GB',
        'publisher' => array('@id' => $sdBusinessId),
    ),
);

if ($WHERE_AM_I == 'page' && !$url->notFound()) {
    if ($page->key() === 'about') {
        $sdGraph[] = array(
            '@type' => 'ProfilePage',
            '@id' => $page->permalink() . '#webpage',
            'url' => $page->permalink(),
            'name' => structuredDataText($page->title()),
            'isPartOf' => array('@id' => $sdWebsiteId),
            'mainEntity' => array('@id' => $sdPersonId),
        );
    } elseif (isBlogPost($page)) {
        $sdPost = array(
            '@type' => 'BlogPosting',
            '@id' => $page->permalink() . '#article',
            'headline' => structuredDataText($page->title()),
            'url' => $page->permalink(),
            'mainEntityOfPage' => $page->permalink(),
            'datePublished' => $page->date('c'),
            'inLanguage' => 'en-GB',
            'author' => array('@id' => $sdPersonId),
            'publisher' => array('@id' => $sdBusinessId),
            'isPartOf' => array('@id' => $sdWebsiteId),
        );
        if ($page->getValue('dateModified')) {
            $sdPost['dateModified'] = $page->dateModified('c');
        }
        if ($page->description()) {
            $sdPost['description'] = structuredDataText($page->description());
        }
        if ($page->coverImage()) {
            $sdPost['image'] = $page->coverImage();
        }
        if ($page->tags(true)) {
            $sdPost['keywords'] = array_values(array_map('structuredDataText', $page->tags(true)));
        }
        $sdGraph[] = $sdPost;
    }
}

// JSON_HEX_TAG escapes < and >, so no text can close the <script> element early
$sdFlags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG;
?>
    <script type="application/ld+json"><?php echo json_encode(array('@context' => 'https://schema.org', '@graph' => $sdGraph), $sdFlags); ?></script>
