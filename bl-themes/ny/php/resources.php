<main id="maincontent" class="wrapper">

    <section>
        <div class="container container-narrow padding-short padding-bottom-none">
            <div class="row">
                <div class="column">
        
                    <?php Theme::plugins('pageBegin'); // Load Bludit Plugins: Page Begin ?>
                    
                    <h1 class="page-title"><?php echo $page->title(); ?></h1>
                    
                    <?php if ($page->coverImage()): ?>
                    <img class="cover-image" src="<?php echo $page->coverImage(); ?>" alt="<?php echo $page->custom('coverImageAlt'); ?>">
                    <?php endif ?>
                
                    <div class="page-content"><?php echo $page->content(); ?></div>
        
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container container-narrow padding-top-none">
            <div class="row">
                <div class="column">

                    <?php
                    global $pages;
                    // Only public pages (skip drafts, scheduled pages and autosaves)
                    $resourceChildren = array();
                    foreach ($pages->getChildren('resources') as $childKey) {
                        $childPage = new Page($childKey);
                        if ($childPage->published() || $childPage->sticky() || $childPage->isStatic()) {
                            $resourceChildren[] = $childPage;
                        }
                    }
                    usort($resourceChildren, function($a, $b) {
                        return $a->position() - $b->position();
                    });
                    if (!empty($resourceChildren)):
                    ?>
                    <ul class="resources-list">
                        <?php foreach ($resourceChildren as $childPage):
                            $externalUrl = trim((string) $childPage->custom('externalUrl'));
                            $isExternal = $externalUrl !== '' && filter_var($externalUrl, FILTER_VALIDATE_URL);
                        ?>
                        <li>
                            <h2><?php echo $childPage->title(); ?></h2>
                            <?php if ($childPage->description()): ?>
                            <p><?php echo $childPage->description(); ?></p>
                            <?php endif; ?>
                            <?php if ($isExternal): ?>
                            <a href="<?php echo htmlspecialchars($externalUrl, ENT_QUOTES); ?>" class="link-external" target="_blank" rel="noopener">
                                View resource<span class="visually-hidden">: <?php echo $childPage->title(); ?> (external site, opens in a new tab)</span><svg aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h7v2H5v14h14v-7h2v7q0 .825-.587 1.413T19 21zm4.7-5.3-1.4-1.4L17.6 5H14V3h7v7h-2V6.4z"/></svg>
                            </a>
                            <?php else: ?>
                            <a href="<?php echo $childPage->permalink(); ?>">Learn more<span class="visually-hidden"> about <?php echo $childPage->title(); ?></span></a>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>


                    <?php Theme::plugins('pageEnd'); // Load Bludit Plugins: Page End ?>

                </div>
            </div>
        </div>
    </section>

</main>