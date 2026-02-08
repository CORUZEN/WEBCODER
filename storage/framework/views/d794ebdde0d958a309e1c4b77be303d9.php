

<?php $__env->startSection('title', 'Conheça a IAGUS'); ?>

<?php $__env->startSection('content'); ?>

<div class="bg-gray-50 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-6">Conheça a IAGUS</h1>
        
        <div class="card mb-8">
            <h2 class="text-2xl font-bold mb-4">Quem Somos</h2>
            <p class="text-gray-700 mb-4">
                A Igreja Anglicana de Garanhuns (IAGUS) é uma comunidade de fé cristã que busca viver e compartilhar o amor de Deus em Garanhuns e região.
            </p>
            <p class="text-gray-700">
                Nossa missão é ser uma família acolhedora onde cada pessoa pode pertencer, crescer na fé e servir ao próximo.
            </p>
        </div>
        
        <div class="card mb-8">
            <h2 class="text-2xl font-bold mb-4">Nossos Valores</h2>
            <ul class="space-y-3 text-gray-700">
                <li class="flex items-start gap-3">
                    <span class="text-primary-600">✓</span>
                    <span><strong>Acolhimento:</strong> Todos são bem-vindos, independente de onde vêm ou em que ponto da jornada de fé estão.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-primary-600">✓</span>
                    <span><strong>Comunidade:</strong> Acreditamos que a fé cresce em relacionamentos genuínos.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-primary-600">✓</span>
                    <span><strong>Ensino Bíblico:</strong> A Palavra de Deus é nossa base para vida e fé.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-primary-600">✓</span>
                    <span><strong>Serviço:</strong> Somos chamados a servir uns aos outros e à nossa cidade.</span>
                </li>
            </ul>
        </div>
        
        <div class="card bg-primary-50 border-2 border-primary-200 text-center">
            <h2 class="text-2xl font-bold mb-4">Venha como você está</h2>
            <p class="text-gray-700 mb-6">
                Não importa de onde você vem ou o que está enfrentando. Aqui você encontrará uma família pronta para recebê-lo.
            </p>
            <a href="<?php echo e(route('contact')); ?>" class="btn btn-primary">
                Fale conosco
            </a>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CORUZEN\WEBCODER\resources\views/about.blade.php ENDPATH**/ ?>