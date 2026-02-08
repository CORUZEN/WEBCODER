

<?php $__env->startSection('title', 'Juventude - IAGUS'); ?>

<?php $__env->startSection('content'); ?>

<div class="bg-gradient-to-r from-secondary-500 to-secondary-700 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-4">Juventude IAGUS</h1>
        <p class="text-xl">Um lugar seguro para pertencer, crescer e servir</p>
    </div>
</div>

<section class="py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="card mb-8">
            <h2 class="text-2xl font-bold mb-4">Nossos Encontros</h2>
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="font-bold text-lg mb-2">Sextas-feiras - 19:30h</h3>
                <p class="text-gray-700 mb-4">
                    Encontro semanal com louvor, mensagem relevante e muita comunhão.
                </p>
                <p class="text-gray-600">
                    Um espaço criado especialmente para jovens de 13 a 25 anos.
                </p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="card">
                <h3 class="text-xl font-bold mb-3">👥 Grupos Pequenos</h3>
                <p class="text-gray-700">
                    Encontros semanais em casas para estudo bíblico, oração e amizade.
                </p>
            </div>
            
            <div class="card">
                <h3 class="text-xl font-bold mb-3">🎯 Discipulado</h3>
                <p class="text-gray-700">
                    Mentoria individual ou em dupla para crescimento espiritual.
                </p>
            </div>
            
            <div class="card">
                <h3 class="text-xl font-bold mb-3">🙌 Ministérios</h3>
                <p class="text-gray-700">
                    Oportunidades para servir em louvor, mídia, recepção e mais.
                </p>
            </div>
            
            <div class="card">
                <h3 class="text-xl font-bold mb-3">🏕️ Eventos</h3>
                <p class="text-gray-700">
                    Retiros, acampamentos, conferências e atividades recreativas.
                </p>
            </div>
        </div>
        
        <div class="card bg-secondary-50 border-2 border-secondary-200 text-center">
            <h2 class="text-2xl font-bold mb-4">Conecte-se com a gente!</h2>
            <p class="text-gray-700 mb-6">
                Se você está recomeçando, buscando fé ou só quer conversar: você é bem-vindo!
            </p>
            <a href="<?php echo e(route('contact')); ?>" class="btn bg-secondary-600 text-white hover:bg-secondary-700">
                Falar com a liderança da juventude
            </a>
        </div>
        
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CORUZEN\WEBCODER\resources\views/youth.blade.php ENDPATH**/ ?>