<?php $__env->startSection('titulo', 'Citas'); ?>
<?php $__env->startSection('contenido'); ?>
    <div class="encabezado">
        <h1>Citas</h1>
        <a class="boton" href="<?php echo e(route('citas.create')); ?>">Registrar cita</a>
    </div>
    <form class="tarjeta fila" method="GET" action="<?php echo e(route('citas.index')); ?>">
        <div>
            <label for="fecha">Fecha</label>
            <input id="fecha" type="date" name="fecha" value="<?php echo e(request('fecha')); ?>">
        </div>
        <div>
            <label for="odontologo_id">Odontólogo</label>
            <select id="odontologo_id" name="odontologo_id">
                <option value="">Todos</option>
                <?php $__currentLoopData = $odontologos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($o->id); ?>" <?php if(request('odontologo_id') == $o->id): echo 'selected'; endif; ?>><?php echo e($o->nombre); ?> <?php echo e($o->apellido); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label for="estado">Estado</label>
            <select id="estado" name="estado">
                <option value="">Todos</option>
                <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($estado); ?>" <?php if(request('estado') == $estado): echo 'selected'; endif; ?>><?php echo e(str_replace('_', ' ', ucfirst($estado))); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div style="flex: 0 0 auto;">
            <button class="boton" type="submit">Filtrar</button>
            <a class="boton gris" href="<?php echo e(route('citas.create')); ?>">Nueva cita</a>
        </div>
    </form>
    <table>
        <tr><th>Fecha y hora</th><th>Paciente</th><th>Odontólogo</th><th>Estado</th><th></th></tr>
        <?php $__empty_1 = true; $__currentLoopData = $citas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($c->inicio->format('d/m/Y H:i')); ?> - <?php echo e($c->fin->format('H:i')); ?></td>
                <td><?php echo e($c->paciente->nombre); ?> <?php echo e($c->paciente->apellido); ?></td>
                <td><?php echo e($c->odontologo->nombre); ?> <?php echo e($c->odontologo->apellido); ?><br><small><?php echo e(ucfirst($c->odontologo->especialidad)); ?></small></td>
                <td><span class="estado <?php echo e($c->estado); ?>"><?php echo e(str_replace('_', ' ', $c->estado)); ?></span></td>
                <td><a class="boton chico" href="<?php echo e(route('citas.show', $c)); ?>">Ver</a></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="5" class="vacio">No hay citas con esos filtros.</td></tr>
        <?php endif; ?>
    </table>
    <?php echo e($citas->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Tecnologia web1\Proyectofinal_nueva_interfaz_v2\consultorio_actividad2\resources\views/citas/index.blade.php ENDPATH**/ ?>