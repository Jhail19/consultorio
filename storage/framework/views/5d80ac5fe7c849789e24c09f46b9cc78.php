<?php $__env->startSection('titulo', 'Pacientes'); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="encabezado">
        <h1>Pacientes</h1>
        <a class="boton" href="<?php echo e(route('pacientes.create')); ?>">Nuevo paciente</a>
    </div>
    <form class="fila tarjeta" method="GET" action="<?php echo e(route('pacientes.index')); ?>">
        <div>
            <label for="q">Buscar por CI, nombre o apellido</label>
            <input id="q" name="q" value="<?php echo e($buscar); ?>">
        </div>
        <div style="flex: 0 0 auto;">
            <button class="boton" type="submit">Buscar</button>
        </div>
    </form>
    <table>
        <tr><th>CI</th><th>Paciente</th><th>Teléfono</th><th class="num">Citas</th><th></th></tr>
        <?php $__empty_1 = true; $__currentLoopData = $pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($p->ci); ?></td>
                <td><?php echo e($p->apellido); ?>, <?php echo e($p->nombre); ?></td>
                <td><?php echo e($p->telefono ?? '—'); ?></td>
                <td class="num"><?php echo e($p->citas_count); ?></td>
                <td class="acciones">
                    <a class="boton chico" href="<?php echo e(route('pacientes.show', $p)); ?>">Ver</a>
                    <a class="boton chico gris" href="<?php echo e(route('pacientes.edit', $p)); ?>">Editar</a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="5" class="vacio">No hay pacientes que coincidan.</td></tr>
        <?php endif; ?>
    </table>
    <?php echo e($pacientes->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Tecnologia web1\Proyectofinal_nueva_interfaz_v2\consultorio_actividad2\resources\views/pacientes/index.blade.php ENDPATH**/ ?>