<?= '<?xml version="1.0" encoding="UTF-8"?>'?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <url>
        <loc><?= base_url();?></loc>
        <lastmod><?= substr($date,0,10); ?></lastmod>
        <priority>0.1</priority>
    </url>
    <url>
        <loc><?= base_url("home/");?></loc>
        <lastmod><?= substr($date,0,10); ?></lastmod>
        <priority>0.1</priority>
    </url>
    <!-- Sitemap Services -->
    <url>
        <loc><?= base_url("services/");?></loc>
        <lastmod><?= substr($date,0,10); ?></lastmod>
        <priority>0.1</priority>
    </url>
    <?php foreach($services as $item) { ?>
    <url>
        <loc><?= base_url().$item['url'];?></loc>
        <lastmod><?= substr($date,0,10); ?></lastmod>
        <priority>0.8</priority>
    </url>
    <?php } ?>
    <!-- Sitemap Portfolio -->
    <url>
        <loc><?= base_url("portfolio/");?></loc>
        <lastmod><?= substr($date,0,10); ?></lastmod>
        <priority>0.1</priority>
    </url>
    <!-- Sitemap Blog -->
    <url>
        <loc><?= base_url("blog/");?></loc>
        <lastmod><?= substr($date,0,10); ?></lastmod>
        <priority>0.5</priority>
    </url>
    <!-- Blog Detail -->
    <?php foreach($blog as $item) { ?>
    <url>
        <loc><?= base_url().$item["url"];?></loc>
        <priority>0.5</priority>
        <lastmod><?= substr($date,0,10); ?></lastmod>
    </url>
    <?php } ?>
    <url>
        <loc><?= base_url("home/contact/");?></loc>
        <lastmod><?= substr($date,0,10); ?></lastmod>
        <priority>0.5</priority>
    </url>
    <?php foreach($submenu as $item) { ?>        
        <url>
            <loc><?= base_url().$item["url"];?></loc>
            <priority>0.5</priority>
            <lastmod><?= substr($date,0,10); ?></lastmod>
        </url>
    <?php } ?>
    <?php foreach($menu as $item) { ?>        
        <url>
            <loc><?= base_url().$item["url"];?></loc>
            <priority>0.5</priority>
            <lastmod><?= substr($date,0,10); ?></lastmod>
        </url>
    <?php } ?>
</urlset>