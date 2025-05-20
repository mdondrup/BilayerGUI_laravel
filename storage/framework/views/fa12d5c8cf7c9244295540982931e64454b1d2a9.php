<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<?php echo $__env->make('layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php
$allSession = Session::all();
$numSelected = 0;
foreach ($allSession as $key => $value) {
    if (str_contains($key, 'CompareID') && $value == 1) {
        $numSelected = $numSelected + 1;
    }
}
?>

<body>
    <div id="app" class="bg-datos" style="height:auto;overflow-x:hidden; ">
        <nav id="mainNav" class="navbar navbar-expand-md navbar-light ">
            <div class="container">
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                    <img class="img-fluid" style="width:225px" alt="Responsive image"
                        src="<?php echo e(asset('storage/images/nmr_w_letras.png')); ?>" alt="">
                    <?php //{{ config('app.name') }}
                    ?>
                    <div class="d-none">
                        <span>Versión: <?php echo e(config('app.version')); ?></span>
                        <span>Entorno: <?php echo e(config('app.env')); ?></span>
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="<?php echo e(__('Toggle navigation')); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <?php if(auth()->guard()->guest()): ?>
                            <?php if($numSelected > 0): ?>
                                <!--<li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('new_advanced_search.compare')); ?>"><?php echo e(__('Compare')); ?></a>
                            </li>-->
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="<?php echo e(route('new_advanced_search.form')); ?>"><?php echo e(__('Advanced Search')); ?></a>
                            </li>
                            <!--  <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                                </li>-->
                            <?php if(Route::has('register')): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
                                </li>
                            <?php endif; ?>
                        <?php else: ?>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <?php echo e(__('Logout')); ?>

                                    </a>

                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST"
                                        style="display: none;">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <main style="padding-bottom: 140px;">
            <?php echo $__env->yieldContent('content'); ?>
        </main>


    </div>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script>
        $(function() {
            $('[title]').tooltip()
        })
    </script>


    <?php echo $__env->yieldContent('js'); ?>

    <?php echo $__env->make('layouts.foot', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/nmrlipid/databank.nmrlipids.fi/databank/laravel/resources/views/layouts/app.blade.php ENDPATH**/ ?>