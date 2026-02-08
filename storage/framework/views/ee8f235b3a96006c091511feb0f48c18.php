

<?php $__env->startSection('title', 'Cultos e Agenda - IAGUS'); ?>

<?php $__env->startSection('content'); ?>

<div class="bg-gray-50 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-6">Cultos e Agenda</h1>
        
        <div class="card mb-8">
            <h2 class="text-2xl font-bold mb-6">Horários dos Cultos</h2>
            
            <div class="space-y-4">
                <div class="p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-bold text-lg mb-2">🌞 Domingo - Manhã</h3>
                    <p class="text-gray-700">9:00h - Culto de Celebração</p>
                    <p class="text-sm text-gray-600">Louvor, adoração e mensagem bíblica</p>
                </div>
                
                <div class="p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-bold text-lg mb-2">🌙 Quarta-feira - Noite</h3>
                    <p class="text-gray-700">19:30h - Culto de Oração e Ensino</p>
                    <p class="text-sm text-gray-600">Momento de oração e estudo bíblico</p>
                </div>
            </div>
        </div>
        
        <div class="card mb-8">
            <h2 class="text-2xl font-bold mb-4">Localização</h2>
            <p class="text-gray-700 mb-4">
                📍 Garanhuns - PE<br>
                (Endereço específico disponível ao entrar em contato)
            </p>
            <a href="<?php echo e(route('contact')); ?>" class="btn btn-primary">
                Como chegar
            </a>
        </div>
        
        <div class="card bg-blue-50 border-2 border-blue-200">
            <h2 class="text-2xl font-bold mb-4">Primeira Visita?</h2>
            <p class="text-gray-700 mb-4">
                Ficaremos felizes em recebê-lo! Chegue alguns minutos antes para conhecer nossa equipe de recepção.
            </p>
            <ul class="space-y-2 text-gray-700">
                <li>✓ Estacionamento disponível</li>
                <li>✓ Ambiente familiar e acolhedor</li>
                <li>✓ Ministério infantil durante o culto</li>
            </ul>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CORUZEN\WEBCODER\resources\views/worship.blade.php ENDPATH**/ ?>