<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">

  <?php foreach ($pages as $page): ?>
  <url>
    <loc><?php echo $page['url']; ?></loc>
    
    <?php if ($page['last_modified']): ?><lastmod><?php echo $page['last_modified']; ?></lastmod><?php endif; ?>
    
    <?php if ($page['xml_change_freq']): ?><changefreq><?php echo $page['xml_change_freq']; ?></changefreq><?php endif; ?>
    
    <priority><?php echo $page['xml_priority']; ?></priority>
    
  </url>
  <?php endforeach; ?>

</urlset> 