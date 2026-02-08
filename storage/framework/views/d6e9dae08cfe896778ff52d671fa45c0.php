

<?php $__env->startSection('title', 'Eventos - IAGUS'); ?>

<?php $__env->startSection('content'); ?>

<div class="bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-2">Eventos</h1>
        <p class="text-gray-600">Participe dos nossos encontros e atividades</p>
    </div>
</div>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <?php if($events->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card hover:shadow-xl transition">
                        <?php if($event->image_url): ?>
                            <img src="<?php echo e($event->image_url); ?>" alt="<?php echo e($event->title); ?>" class="w-full h-48 object-cover rounded-lg mb-4">
                        <?php endif; ?>
                        
                        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <?php echo e($event->start_at->format('d/m/Y - H:i')); ?>

                        </div>
                        
                        <h3 class="text-xl font-bold mb-3"><?php echo e($event->title); ?></h3>
                        
                        <div class="flex items-start gap-2 text-gray-600 mb-4">
                            <svg class="w-4 h-4 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-sm"><?php echo e($event->location_name); ?></span>
                        </div>
                        
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-semibold text-primary-600">
                                <?php echo e($event->priceFormatted()); ?>

                            </span>
                            <?php if($event->capacity): ?>
                                <span class="text-sm text-gray-500">
                                    <?php echo e($event->availableSpots()); ?> vagas
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <a href="<?php echo e(route('events.show', $event->slug)); ?>" class="btn btn-primary w-full">
                            Ver detalhes e inscrever-se
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <div class="mt-12">
                <?php echo e($events->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Nenhum evento disponível no momento.</p>
                <p class="text-gray-400 mt-2">Em breve teremos novidades!</p>
            </div>
        <?php endif; ?>
        
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CORUZEN\WEBCODER\resources\views/events/index.blade.php ENDPATH**/ ?>