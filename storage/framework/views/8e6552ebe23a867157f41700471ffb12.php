

<?php $__env->startSection('title', 'Contato - IAGUS'); ?>

<?php $__env->startSection('content'); ?>

<div class="bg-gray-50 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-6 text-center">Entre em Contato</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="card">
                <h2 class="text-xl font-bold mb-4">📍 Localização</h2>
                <p class="text-gray-700 mb-2">Garanhuns - PE</p>
                <p class="text-sm text-gray-600">Entre em contato para endereço completo e direções</p>
            </div>
            
            <div class="card">
                <h2 class="text-xl font-bold mb-4">📧 E-mail</h2>
                <a href="mailto:contato@iagus.org.br" class="text-primary-600 hover:text-primary-700">
                    contato@iagus.org.br
                </a>
            </div>
            
            <div class="card">
                <h2 class="text-xl font-bold mb-4">📱 WhatsApp</h2>
                <a href="https://wa.me/5587999999999" target="_blank" class="text-primary-600 hover:text-primary-700">
                    (87) 9 9999-9999
                </a>
            </div>
            
            <div class="card">
                <h2 class="text-xl font-bold mb-4">📱 Redes Sociais</h2>
                <div class="space-y-2">
                    <a href="#" class="block text-primary-600 hover:text-primary-700">
                        📘 Facebook: @iagus.garanhuns
                    </a>
                    <a href="#" class="block text-primary-600 hover:text-primary-700">
                        📷 Instagram: @iagus_garanhuns
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card bg-primary-50 border-2 border-primary-200 text-center">
            <h2 class="text-2xl font-bold mb-4">Horário de Atendimento</h2>
            <p class="text-gray-700 mb-2">
                Segunda a Sexta: 9h às 17h<br>
                Sábado e Domingo: Durante os cultos
            </p>
            <p class="text-sm text-gray-600 mt-4">
                Ficamos felizes em responder suas dúvidas!
            </p>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\CORUZEN\WEBCODER\resources\views/contact.blade.php ENDPATH**/ ?>