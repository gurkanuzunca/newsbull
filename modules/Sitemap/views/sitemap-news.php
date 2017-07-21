<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
    <?php foreach ($sitemap as $url): ?>
        <url>
            <loc><?php echo $url->loc ?></loc>
            <lastmod><?php echo $url->lastmod ?></lastmod>
            <changefreq><?php echo $url->changefreq ?></changefreq>
            <priority><?php echo $url->priority ?></priority>
            <news:news>
                <news:publication>
                    <news:name><?php echo $url->news->name; ?></news:name>
                    <news:language><?php echo $url->news->language; ?></news:language>
                </news:publication>
                <news:genres>PressRelease, UserGenerated</news:genres>
                <news:publication_date><?php echo $url->news->publication_date; ?></news:publication_date>
                <news:title><?php echo $url->news->title; ?></news:title>
            </news:news>
        </url>
    <?php endforeach; ?>
</urlset>