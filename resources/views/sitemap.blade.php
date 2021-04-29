<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
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