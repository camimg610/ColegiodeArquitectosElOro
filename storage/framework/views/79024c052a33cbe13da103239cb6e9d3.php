<nav class="full-box navbar-info">
    <a href="#" class="float-left show-nav-lateral">
        <i class="fas fa-exchange-alt"></i>
    </a>
    <a href="user-update.html">
        <i class="fas fa-user-cog"></i>
    </a>
    <a href="<?php echo e(route('logout')); ?>" class="btn-exit-system" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-power-off"></i>
    </a>
    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>
    </form>
</nav>
<?php /**PATH E:\SEmestre pasado\Disco-cami\Proj_ppi_02\Proj_ppi_01\resources\views/layout/nav.blade.php ENDPATH**/ ?>