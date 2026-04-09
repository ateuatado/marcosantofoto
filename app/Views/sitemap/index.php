<?= '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $url): ?>
    <url>
        <loc><?= htmlspecialchars($url['loc'], ENT_QUOTES, 'UTF-8') ?></loc>
        <?php if (isset($url['lastmod'])): ?>
            <lastmod><?= $url['lastmod'] ?></lastmod>
        <?php endif; ?>
        <?php if (isset($url['changefreq'])): ?>
            <changefreq><?= $url['changefreq'] ?></changefreq>
        <?php endif; ?>
        <?php if (isset($url['priority'])): ?>
            <priority><?= $url['priority'] ?></priority>
        <?php endif; ?>
    </url>
<?php endforeach; ?>
</urlset>
