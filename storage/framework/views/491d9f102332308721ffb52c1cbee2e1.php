<?php $__env->startSection('titulo', 'Cita #' . $cita->id); ?>
<?php $__env->startSection('contenido'); ?>
    <h1>Cita #<?php echo e($cita->id); ?> <span class="estado <?php echo e($cita->estado); ?>"><?php echo e(str_replace('_', ' ', $cita->estado)); ?></span></h1>

    <div class="tarjeta">
        <div class="rejilla">
            <div><strong>Fecha:</strong> <?php echo e($cita->inicio->format('d/m/Y')); ?></div>
            <div><strong>Horario:</strong> <?php echo e($cita->inicio->format('H:i')); ?> a <?php echo e($cita->fin->format('H:i')); ?> (<?php echo e($cita->bloques); ?> <?php echo e($cita->bloques == 1 ? 'bloque' : 'bloques'); ?>)</div>
            <div><strong>Paciente:</strong> <a href="<?php echo e(route('pacientes.show', $cita->paciente)); ?>"><?php echo e($cita->paciente->nombre); ?> <?php echo e($cita->paciente->apellido); ?></a></div>
            <div><strong>Odontólogo:</strong> <a href="<?php echo e(route('odontologos.show', $cita->odontologo)); ?>"><?php echo e($cita->odontologo->nombre); ?> <?php echo e($cita->odontologo->apellido); ?></a></div>
            <div><strong>Motivo:</strong> <?php echo e($cita->motivo ?? '—'); ?></div>
            <?php if($cita->inicio_original): ?>
                <div><strong>Fecha original:</strong> <?php echo e($cita->inicio_original->format('d/m/Y H:i')); ?> (<?php echo e($cita->reprogramaciones); ?> <?php echo e($cita->reprogramaciones == 1 ? 'reprogramación' : 'reprogramaciones'); ?>)</div>
            <?php endif; ?>
        </div>

        <?php if(in_array($cita->estado, ['agendada', 'confirmada', 'reprogramada'])): ?>
            <div class="acciones" style="margin-top: 14px;">
                <?php if(in_array($cita->estado, ['agendada', 'reprogramada'])): ?>
                    <form method="POST" action="<?php echo e(route('citas.confirmar', $cita)); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="boton verde" type="submit">Confirmar</button>
                    </form>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route('citas.no-asistida', $cita)); ?>" onsubmit="return confirm('¿Marcar como no asistida? Se libera el bloque.')">
                    <?php echo csrf_field(); ?>
                    <button class="boton rojo" type="submit">Marcar no asistida</button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <?php if(in_array($cita->estado, ['agendada', 'confirmada', 'reprogramada'])): ?>
        <h2>Reprogramar</h2>
        <form class="tarjeta fila" method="POST" action="<?php echo e(route('citas.reprogramar', $cita)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div>
                <label for="fecha">Nueva fecha</label>
                <input id="fecha" type="date" name="fecha" min="<?php echo e(now()->toDateString()); ?>" value="<?php echo e(old('fecha')); ?>" required>
            </div>
            <div>
                <label for="hora">Nueva hora</label>
                <input id="hora" type="time" name="hora" step="1800" value="<?php echo e(old('hora')); ?>" required>
            </div>
            <div>
                <label for="bloques">Duración</label>
                <select id="bloques" name="bloques">
                    <option value="">Igual que ahora</option>
                    <?php $__currentLoopData = [1 => '30 minutos', 2 => '1 hora', 3 => '1 hora 30 min', 4 => '2 horas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n => $texto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($n); ?>" <?php if(old('bloques') == $n): echo 'selected'; endif; ?>><?php echo e($texto); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div style="flex: 0 0 auto;"><button class="boton" type="submit">Reprogramar</button></div>
        </form>
    <?php endif; ?>

    <h2>Tratamientos</h2>
    <table>
        <tr><th>Descripción</th><th class="num">Costo (Bs)</th></tr>
        <?php $__empty_1 = true; $__currentLoopData = $cita->tratamientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr><td><?php echo e($t->descripcion); ?></td><td class="num"><?php echo e(number_format($t->costo, 2)); ?></td></tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="2" class="vacio">Todavía no se registraron tratamientos.</td></tr>
        <?php endif; ?>
    </table>
    <?php if(in_array($cita->estado, ['confirmada', 'atendida'])): ?>
        <form class="tarjeta fila" style="margin-top: 10px;" method="POST" action="<?php echo e(route('tratamientos.store', $cita)); ?>">
            <?php echo csrf_field(); ?>
            <div style="flex: 3;">
                <label for="descripcion">Tratamiento realizado</label>
                <input id="descripcion" name="descripcion" value="<?php echo e(old('descripcion')); ?>" required>
            </div>
            <div>
                <label for="costo">Costo (Bs)</label>
                <input id="costo" type="number" step="0.01" min="0" name="costo" value="<?php echo e(old('costo')); ?>" required>
            </div>
            <div style="flex: 0 0 auto;"><button class="boton verde" type="submit">Registrar</button></div>
        </form>
    <?php else: ?>
        <p class="vacio">Solo se registran tratamientos en citas confirmadas o atendidas.</p>
    <?php endif; ?>

    <?php if($cita->pagos->count()): ?>
        <h2>Pagos ligados a esta cita</h2>
        <table>
            <tr><th>Fecha</th><th>Método</th><th class="num">Monto (Bs)</th></tr>
            <?php $__currentLoopData = $cita->pagos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pago): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr><td><?php echo e($pago->fecha_pago->format('d/m/Y')); ?></td><td><?php echo e(ucfirst($pago->metodo)); ?></td><td class="num"><?php echo e(number_format($pago->monto, 2)); ?></td></tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
    <?php endif; ?>

    <p style="margin-top: 20px;"><a class="boton gris" href="<?php echo e(route('citas.index')); ?>">Volver a las citas</a></p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Tecnologia web1\Proyectofinal_nueva_interfaz_v2\consultorio_actividad2\resources\views/citas/show.blade.php ENDPATH**/ ?>