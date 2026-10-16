<?php
// List of post summaries (blog page, tag and category archives).
// Expects $postList: an array of Page objects.
?>
<ul class="post-list">
    <?php foreach ($postList as $post):
        $postSummary = blogPostSummary($post);
    ?>
    <li>
        <article class="post-summary">
            <h2 class="post-summary__title"><a href="<?php echo $post->permalink(); ?>"><?php echo $post->title(); ?></a></h2>
            <p class="post-meta"><time datetime="<?php echo $post->date('Y-m-d'); ?>"><?php echo $post->date(); ?></time></p>
            <?php if ($postSummary !== ''): ?>
            <div class="post-summary__text"><?php echo $postSummary; ?></div>
            <?php endif; ?>
        </article>
    </li>
    <?php endforeach; ?>
</ul>
