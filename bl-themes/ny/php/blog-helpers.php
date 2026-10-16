<?php defined('BLUDIT') or die('Bludit CMS.');
// Blog helpers, loaded by index.php.
//
// Blog posts are child pages of the static "blog" page, so they live at /blog/post-slug.
// They use the normal Bludit types: Published ("- Default -" in the editor), Sticky
// (shown first on the blog page), Static (listed like Published, as it's public anyway),
// Scheduled and Draft (these two are never listed).

define('BLOG_PAGE_KEY', 'blog');

// (array) Public posts as Page objects, newest first
function blogPosts()
{
    global $pages;

    $posts = array();
    foreach ($pages->getChildren(BLOG_PAGE_KEY) as $postKey) {
        try {
            $post = new Page($postKey);
        } catch (Exception $e) {
            continue;
        }
        if ($post->published() || $post->sticky() || $post->isStatic()) {
            $posts[] = $post;
        }
    }

    usort($posts, function ($a, $b) {
        return strcmp($b->dateRaw(), $a->dateRaw());
    });

    return $posts;
}

// (boolean) TRUE if the page is a blog post
function isBlogPost($page)
{
    return $page && $page->parentKey() === BLOG_PAGE_KEY;
}

// (string) HTML summary for post lists: the description if there is one,
// otherwise the content before the page break, otherwise nothing
function blogPostSummary($post)
{
    if ($post->description()) {
        return '<p>' . $post->description() . '</p>';
    }
    if ($post->readMore()) {
        // Drop the <p> TinyMCE wraps the pagebreak in
        return trim(preg_replace('#<p>\s*$#', '', $post->contentBreak()));
    }
    return '';
}

// (string) URL of a page of a list of posts (blog page, tag or category).
// Page 1 has no ?page= parameter.
function blogListPageUrl($number)
{
    $pageUrl = Paginator::numberUrl($number);
    return ($number > 1) ? $pageUrl : strtok($pageUrl, '?');
}
