<?php $o = $odontologo ?? null; ?>
<div class="rejilla">
    <div>
        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" value="<?php echo e(old('nombre', $o?->nombre)); ?>" required>
    </div>
    <div>
        <label for="apellido">Apellido</label>
        <input id="apellido" name="apellido" value="<?php echo e(old('apellido', $o?->apellido)); ?>" required>
    </div>
    <div>
        <label for="email">Correo</label>
        <input id="email" type="email" name="email" value="<?php echo e(old('email', $o?->email)); ?>" required>
    </div>
    <div>
        <label for="especialidad">Especialidad</label>
        <select id="especialidad" name="especialidad">
            <?php $__currentLoopData = ['ortodoncia', 'endodoncia', 'odontopediatria']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $esp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($esp); ?>" <?php if(old('especialidad', $o?->especialidad) == $esp): echo 'selected'; endif; ?>><?php echo e(ucfirst($esp)); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div>
        <label>&nbsp;</label>
        <label style="font-weight: normal;">
            <input type="checkbox" name="activo" value="1" <?php if(old('activo', $o?->activo ?? true)): echo 'checked'; endif; ?>> Activo (puede recibir citas)
        </label>
    </div>
</div>
<p><button class="boton" type="submit">Guardar</button> <a class="boton gris" href="<?php echo e(route('odontologos.index')); ?>">Cancelar</a></p>
<?php /**PATH C:\Tecnologia web1\Proyectofinal_nueva_interfaz_v2\consultorio_actividad2\resources\views/odontologos/_form.blade.php ENDPATH**/ ?>