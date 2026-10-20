<?php
include(THEME_DIR_PHP . 'blog-helpers.php');

// The homepage only shows the Home page. Bludit puts every published page in
// $content there, and blog posts are published pages too.
if ($WHERE_AM_I == 'home') {
    $content = array(new Page('home'));
    $page = $content[0];
}
?>
<!DOCTYPE html>
<html lang="<?php echo Theme::lang() ?>">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="generator" content="Bludit">

	<?php echo Theme::metaTagTitle(); // Dynamic title tag ?>

	<?php echo Theme::metaTagDescription(); // Dynamic description tag ?>

    <?php // Open Graph / social preview (WhatsApp, LinkedIn, Facebook, Slack, X...)
    $isPage = ($WHERE_AM_I == 'page');
    $isPost = $isPage && isBlogPost($page);
    $ogTitle = $isPage ? $page->title() : $site->slogan();
    $ogDescription = ($isPage && $page->description()) ? $page->description() : $site->description();
    $ogDescription = trim(preg_replace('/\s+/', ' ', $ogDescription));
    $ogUrl = $isPage ? $page->permalink() : DOMAIN_BASE;
    $ogImage = ($isPage && $page->coverImage()) ? $page->coverImage() : DOMAIN_THEME . 'assets/images/share.png';
    ?>
    <meta property="og:type" content="<?php echo $isPost ? 'article' : 'website'; ?>">
    <?php if ($isPost): ?>
    <meta property="article:published_time" content="<?php echo $page->date('c'); ?>">
    <?php endif; ?>
    <meta property="og:site_name" content="Nyssen">
    <meta property="og:locale" content="en_GB">
    <meta property="og:title" content="<?php echo Sanitize::html($ogTitle); ?>">
    <meta property="og:description" content="<?php echo Sanitize::html($ogDescription); ?>">
    <meta property="og:url" content="<?php echo $ogUrl; ?>">
    <meta property="og:image" content="<?php echo $ogImage; ?>">
    <?php if ($ogImage === DOMAIN_THEME . 'assets/images/share.png'): ?>
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Nyssen logo next to the text: Nyssen, Digital Accessibility Specialist and Consultant">
    <?php endif; ?>
    <meta name="twitter:card" content="summary_large_image">

	<link rel="shortcut icon" href="/favicon.ico" />
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-precomposed.png">

	<?php echo Theme::css('assets/css/style-min.css?ver=1.15'); ?>

    <!-- Prevent theme flash - applies saved theme before render (no saved theme = system theme) -->
    <script>
        try {
            var theme = localStorage.getItem('theme');
            if (theme === 'light' || theme === 'dark') {
                document.documentElement.setAttribute('data-theme', theme);
            }
        } catch (e) {}
    </script>

    <!-- Google tag (gtag.js), loaded once the page has finished loading so it doesn't slow down first paint.
         Calls to gtag() before then are queued in dataLayer and sent when the script arrives. -->
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-2NL1HCVV9X');

        window.addEventListener('load', function () {
            function loadGtag() {
                var s = document.createElement('script');
                s.async = true;
                s.src = 'https://www.googletagmanager.com/gtag/js?id=G-2NL1HCVV9X';
                document.head.appendChild(s);
            }
            if ('requestIdleCallback' in window) requestIdleCallback(loadGtag, { timeout: 3000 });
            else setTimeout(loadGtag, 1000);
        });
    </script>

	<?php Theme::plugins('siteHead'); // Load Bludit Plugins: Site head ?>
</head>

<body id="top">

	<?php // Load Bludit Plugins: Site Body Begin
    Theme::plugins('siteBodyBegin'); ?>

	<?php // Header
    include(THEME_DIR_PHP.'header.php'); ?>

	<?php // Content
    if ($WHERE_AM_I == 'page') {
        // Check if page has a custom template
        $template = $page->template();
        $templateFile = THEME_DIR_PHP . $template . '.php';
        
        // Use custom template if it exists, then the blog templates, otherwise use default page.php
        if (file_exists($templateFile)) {
            include($templateFile);
        } elseif ($page->key() === BLOG_PAGE_KEY) {
            include(THEME_DIR_PHP . 'blog.php');
        } elseif (isBlogPost($page)) {
            include(THEME_DIR_PHP . 'post.php');
        } else {
            include(THEME_DIR_PHP . 'page.php');
        }
    } elseif ($WHERE_AM_I == 'tag' || $WHERE_AM_I == 'category') {
        include(THEME_DIR_PHP . 'archive.php');
    } else {
        include(THEME_DIR_PHP . 'home.php');
    }
    ?>


	<?php // Footer
    include(THEME_DIR_PHP.'footer.php'); ?>


	<script>

        // Theme switcher (light/dark, defaults to the system theme)
        (function() {
            const button = document.getElementById('js-theme-toggle');
            if (!button) return;

            const root = document.documentElement;
            const systemDark = window.matchMedia('(prefers-color-scheme: dark)');

            // A saved choice (data-theme) wins over the system theme
            const isDark = () => root.dataset.theme ? root.dataset.theme === 'dark' : systemDark.matches;

            const updateButton = () => {
                button.setAttribute('aria-pressed', isDark() ? 'true' : 'false');
            };

            button.addEventListener('click', () => {
                const theme = isDark() ? 'light' : 'dark';
                root.dataset.theme = theme;
                try {
                    localStorage.setItem('theme', theme);
                } catch (e) {}
                updateButton();
            });

            // Keep the button in sync if the system theme changes
            systemDark.addEventListener('change', updateButton);

            updateButton();
            button.hidden = false;
        })();


        // Scroll to top button
        (function() {
            const button = document.getElementById('js-top');
            if (!button) return;

            const SCROLL_THRESHOLD = 800;

            // Show/hide button based on scroll position
            const toggleButtonVisibility = () => {
                const isVisible = window.scrollY > SCROLL_THRESHOLD;
                button.classList.toggle('show', isVisible);
                button.classList.toggle('hide', !isVisible);
            };

            // Use passive listener for better scroll performance
            window.addEventListener('scroll', toggleButtonVisibility, { passive: true });

            // No click handler: the native #top link moves focus back to the top of the page,
            // and smooth scrolling comes from CSS so it respects prefers-reduced-motion

            // Initial state check
            toggleButtonVisibility();
        })();
                
    </script>
    <!-- <script src="assets/js/lazysizes.min.js"></script> -->

	<?php // Load Bludit Plugins: Site Body End
    Theme::plugins('siteBodyEnd'); ?>

</body>
</html>