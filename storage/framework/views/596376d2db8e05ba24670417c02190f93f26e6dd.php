<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php $__currentLoopData = $trayectorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trayectoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <url>
            <loc><?php echo e(url('/')); ?>/trayectorias/<?php echo e($trayectoria->id); ?></loc>
            <lastmod><?php echo date('c',time()); ?></lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</urlset>
<?php /**PATH /home/nmrlipid/databank.nmrlipids.fi/databank/laravel/resources/views/sitemap.blade.php ENDPATH**/ ?>