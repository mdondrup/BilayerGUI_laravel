<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($trayectorias as $trayectoria)
        <url>
            <loc>{{ url('/') }}/trayectorias/{{ $trayectoria->id }}</loc>
            <lastmod>{!! date('c',time()) !!}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>
