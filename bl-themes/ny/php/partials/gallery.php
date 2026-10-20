<?php
// Photo gallery for the About page.
// Images live in assets/images/gallery/ and are shown in this order.
$galleryImages = array(
    array('file' => 'old-picture-of-my-mum.jpg', 'alt' => 'Old photo of my mum as a toddler, taken by my grandfather and hand-coloured by his sister. She sits crying on the floor next to an overturned basket of oranges, with a ribbon in her hair'),
    array('file' => 'freedom.jpg',               'alt' => 'Black and white silhouette of a small child with an arm raised among tall grass on a dune, against the sun'),
    /* array('file' => 'my-sister-and-i.jpg',       'alt' => 'Old colour photo of my sister and me as small children: a girl in a red pinafore dress reaching for a beach ball held by a younger boy'), */
    array('file' => 'ma-fiancee-after-eating-several-lampchops.jpg', 'alt' => 'Very blurry, warm orange-toned photo of a woman with dark shoulder-length hair and a faint smile, inside a worn, scratched frame'),
    array('file' => 'runaway.jpg',               'alt' => 'Bearded man in a flat cap and sunglasses riding a tiny child\'s bike down a path, while a laughing child runs behind'),
    array('file' => 'hang-gliding.jpg',          'alt' => 'Selfie in a helmet and orange goggles while hang-gliding high above a green valley surrounded by mountains'),
    array('file' => 'montserrat.jpg',            'alt' => 'Sunset over hazy hills, with the jagged ridge of Montserrat on the horizon'),
    array('file' => 'in-the-beach.jpg',          'alt' => 'A few people and a yellow parasol on a narrow strip of beach under a grey stormy sky, seen from the water'),
    array('file' => 'swimming.jpg',              'alt' => 'Black and white photo, taken from above, of a child swimming next to a wooden pier'),
    array('file' => 'windy.jpg',                 'alt' => 'Group of people at a windy hilltop viewpoint, with two men in the front looking at a phone together'),
    array('file' => 'sonica.jpg',                'alt' => 'Close-up of Sonica, a white cat with pale blue eyes, looking up'),
    array('file' => 'museu-dali.jpg',            'alt' => 'Part of the Palace of the Wind ceiling painting at the Dalí Theatre-Museum in Figueres: the soles of two huge feet and a red cloth seen from below, among clouds'),
    array('file' => 'the-art-of-moving.jpg',     'alt' => 'Pale blue Abels removal van with the slogan "The art of moving", parked in front of a brick townhouse'),
    array('file' => 'happy.jpg',                 'alt' => 'My daughter\'s colourful drawing of a laughing face with a big open mouth, blue eyes with long lashes, an orange nose and yellow and green hair'),
    array('file' => 'japanese-doll.jpg',         'alt' => 'Doll handmade by Keiko Iwamuro, with a pale face, wearing a fluffy grey-blue bear hood with a pink crocheted flower and a floral dress'),
    /* array('file' => 'little-man.jpg',            'alt' => 'Small plastic toy figure in a blue hood and green shorts, holding a red bag, standing on a table'),
    array('file' => 'snow-globe.jpg',            'alt' => 'Vintage souvenir snow globe with the New York skyline and the SS United States ocean liner'), */
    array('file' => 'tintin-in-tibet.jpg',       'alt' => 'Cover of a Chinese edition of Tintin in Tibet, with climbers following footprints in the snow'),
    array('file' => 'dupond-et-dupont.jpg',      'alt' => 'Thomson and Thompson from Hergé\'s Tintin comics running side by side in striped swimsuits and bowler hats'),
    array('file' => 'alarm-clock.jpg',           'alt' => 'Vintage oval alarm clock that belonged to my grandmother, with a cream face and brass numbers'),
    array('file' => 'paprika.jpg',               'alt' => 'Four round tins: three Butterfly brand balm tins in green, blue and yellow-green, and a red Hungarian paprika tin'),
    array('file' => 'dad-ready-to-go-out-in-winter.jpg', 'alt' => 'My dad in a hat, sunglasses, leather jacket and gloves, sitting in an armchair with his feet up towards the camera, the worn soles of his shoes filling the front of the photo'),
    array('file' => 'beach-in-st-pere-pescador.jpg', 'alt' => 'Marram grass on a sand dune under a blue sky with a small white cloud, on the beach at Sant Pere Pescador'),
    array('file' => 'discoteca-fata-morgana-st-pere-pescador.jpg', 'alt' => 'Bright blue wall of the Fata Morgana nightclub in Sant Pere Pescador, with red ventilation pipes, a metal railing and the top of a sign reading "FATA" against a deep blue sky'),
    array('file' => 'suomi.jpg',                 'alt' => 'Raindrops on an orange umbrella, with a still, misty lake and a line of forest beyond, in Finland'),
    array('file' => 'misty.jpg',                 'alt' => 'Bare trees fading into thick fog beyond an empty field'),
    array('file' => 'holbrook-creek-at-sunset.jpg', 'alt' => 'Pink and orange sunset reflected in the still water of Holbrook Creek, with a few boats moored in the distance'),
);

$galleryDir = THEME_DIR . 'assets' . DS . 'images' . DS . 'gallery' . DS;
$galleryUrl = DOMAIN_THEME . 'assets/images/gallery/';
?>
<ul class="image-gallery">
    <?php foreach ($galleryImages as $image):
        $size = @getimagesize($galleryDir . $image['file']);
        if (!$size) continue; // Skip missing files
    ?>
    <li><img src="<?php echo $galleryUrl . $image['file']; ?>" alt="<?php echo htmlspecialchars($image['alt'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo $size[3]; ?> loading="lazy"></li>
    <?php endforeach; ?>
</ul>
