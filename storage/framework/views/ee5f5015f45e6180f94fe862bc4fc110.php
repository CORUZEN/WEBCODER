

<?php $__env->startSection('title', 'Início - IAGUS'); ?>

<?php $__env->startSection('content'); ?>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-bold mb-6">Uma família para pertencer</h1>
        <p class="text-xl mb-8 max-w-3xl mx-auto">
            Conheça a IAGUS e participe dos nossos cultos e eventos em Garanhuns.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo e(route('about')); ?>" class="btn bg-white text-primary-600 hover:bg-gray-100 px-8 py-3 text-lg">
                Quero visitar
            </a>
            <a href="<?php echo e(route('events.index')); ?>" class="btn bg-primary-500 hover:bg-primary-700 px-8 py-3 text-lg">
                Ver próximos eventos
            </a>
        </div>
    </div>
</section>

<!-- O que esperar na sua visita -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12">O que esperar na sua visita</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Recepção e acolhimento</h3>
                <p class="text-gray-600">Nossa equipe estará pronta para recebê-lo com um sorriso</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Louvor e oração</h3>
                <p class="text-gray-600">Momento de adoração sincera e comunhão com Deus</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Mensagem bíblica</h3>
                <p class="text-gray-600">Ensino relevante e aplicável para o dia a dia</p>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Ambiente familiar</h3>
                <p class="text-gray-600">Espaço acolhedor para famílias e jovens</p>
            </div>
        </div>
    </div>
</section>

<!-- Próximos Eventos -->
<?php if($upcomingEvents->count() > 0): ?>
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12">Próximos Eventos</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php $__currentLoopData = $upcomingEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card hover:shadow-xl transition">
                    <div class="text-sm text-gray-500 mb-2">
                        <?php echo e($event->start_at->format('d/m/Y - H:i')); ?>

                    </div>
                    <h3 class="text-xl font-bold mb-3"><?php echo e($event->title); ?></h3>
                    <div class="text-gray-600 mb-4">
                        📍 <?php echo e($event->location_name); ?>

                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-primary-600"><?php echo e($event->priceFormatted()); ?></span>
                        <a href="<?php echo e(route('events.show', $event->slug)); ?>" class="btn btn-primary">
                            Ver detalhes
                        </a>
                    </div>
                    <?php if($event->capacity): ?>
                        <div class="mt-3 text-sm text-gray-500">
                            <?php echo e($event->availableSpots()); ?> vagas disponíveis
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="text-center mt-8">
            <a href="<?php echo e(route('events.index')); ?>" class="btn btn-secondary">
                Ver todos os eventos
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Juventude -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-secondary-500 to-secondary-700 rounded-2xl p-12 text-white text-center">
            <h2 class="text-3xl font-bold mb-4">Juventude IAGUS</h2>
            <p class="text-xl mb-6 max-w-2xl mx-auto">
                "Um lugar seguro para pertencer, crescer e servir."
            </p>
            <a href="<?php echo e(route('youth')); ?>" class="btn bg-white text-secondary-600 hover:bg-gray-100">
                Conheça a juventude
            </a>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CORUZEN\WEBCODER\resources\views/home.blade.php ENDPATH**/ ?>