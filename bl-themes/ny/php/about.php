<main id="maincontent" class="wrapper page">

    <section>
        <div class="container container-narrow padding-short">
            <div class="row">
                <div class="column">
        
                    <?php Theme::plugins('pageBegin'); // Load Bludit Plugins: Page Begin ?>
                    
                    <h1 class="page-title"><?php echo $page->title(); ?></h1>
        
                </div>
            </div>

            <div class="row reverse">
                <div class="column">
                
                    <?php // Remove the page break and the <p> TinyMCE wraps it in ?>
                    <?php echo preg_replace('#(<p>\s*)?' . preg_quote(PAGE_BREAK, '#') . '(\s*</p>)?\s*#', '', $page->content()); ?>
        
                </div>

                <div class="column column-40 column-offset-4">

                    <?php
                    // One of these profile photos is picked at random on each page load (all 400x400)
                    $profilePhotos = array(
                        array('file' => 'sergi-1.webp', 'alt' => 'Sergi Duran in a green corduroy cap and glasses, looking at the camera with wide eyes'),
                        array('file' => 'sergi-2.webp', 'alt' => 'Sergi Duran in glasses and a dark jacket, looking thoughtfully to the side'),
                        array('file' => 'sergi-3.webp', 'alt' => 'Sergi Duran in a grey flat cap, glasses and a light blue jumper, looking at the camera'),
                        /* array('file' => 'sergi-4.webp', 'alt' => 'Sergi Duran in glasses and a light blue jumper, finger to the lips, deep in thought'), */
                    );
                    $profilePhoto = $profilePhotos[array_rand($profilePhotos)];
                    ?>
                    <img class="profile-photo" src="<?php echo DOMAIN_THEME; ?>assets/images/<?php echo $profilePhoto['file']; ?>" alt="<?php echo htmlspecialchars($profilePhoto['alt'], ENT_QUOTES, 'UTF-8'); ?>" width="400" height="400">

                </div>
            </div>
        </div>
    </section>

    <section aria-labelledby="gallery-title">
        <div class="container container-narrow padding-short">

            <div class="row">
                <div class="column">

                    <?php include(THEME_DIR_PHP . 'partials' . DS . 'gallery.php'); ?>

                </div>
            </div>

        </div>
    </section>

    <section>
        <div class="container container-narrow padding-short">

            <div class="row">
                <div class="column">

                    <h2 class="section-title">Let’s talk</h2>

                    <p>If you’d like to talk about your website or documents, I’d be happy to hear from you.</p>
                    <p>Email me at <a href="mailto:hello@nyssen.me">hello<!--antispam code-->@<!--va-bene-->nyssen.me</a>.</p>

                </div>
            </div>

        </div>
    </section>

</main>