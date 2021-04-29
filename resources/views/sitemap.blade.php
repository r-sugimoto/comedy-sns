<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <url>
        <loc>{{ url('/') }}</loc>
        <priority>1.0</priority>
        <changefreq>daily</changefreq>
    </url>
    <? foreach($map as $v): ?>
        <url>
            <loc>{{ url('/') }}/{{ $v }}</loc>
            <priority>0.8</priority>
            <changefreq>weekly</changefreq>
        </url>
    <? endforeach; ?>
</urlset>