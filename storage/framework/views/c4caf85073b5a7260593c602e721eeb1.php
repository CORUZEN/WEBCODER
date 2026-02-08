<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="<?php echo e(route('home')); ?>" class="text-2xl font-bold text-primary-600">
                    IAGUS
                </a>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8">
                <a href="<?php echo e(route('home')); ?>" class="text-gray-700 hover:text-primary-600 transition <?php echo e(request()->routeIs('home') ? 'text-primary-600 font-semibold' : ''); ?>">
                    Início
                </a>
                <a href="<?php echo e(route('about')); ?>" class="text-gray-700 hover:text-primary-600 transition <?php echo e(request()->routeIs('about') ? 'text-primary-600 font-semibold' : ''); ?>">
                    Conheça
                </a>
                <a href="<?php echo e(route('worship')); ?>" class="text-gray-700 hover:text-primary-600 transition <?php echo e(request()->routeIs('worship') ? 'text-primary-600 font-semibold' : ''); ?>">
                    Cultos
                </a>
                <a href="<?php echo e(route('events.index')); ?>" class="text-gray-700 hover:text-primary-600 transition <?php echo e(request()->routeIs('events.*') ? 'text-primary-600 font-semibold' : ''); ?>">
                    Eventos
                </a>
                <a href="<?php echo e(route('youth')); ?>" class="text-gray-700 hover:text-primary-600 transition <?php echo e(request()->routeIs('youth') ? 'text-primary-600 font-semibold' : ''); ?>">
                    Juventude
                </a>
                <a href="<?php echo e(route('contact')); ?>" class="text-gray-700 hover:text-primary-600 transition <?php echo e(request()->routeIs('contact') ? 'text-primary-600 font-semibold' : ''); ?>">
                    Contato
                </a>
            </div>
            
            <!-- User Menu -->
            <div class="hidden md:flex items-center space-x-4">
                <?php if(auth()->guard()->check()): ?>
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-primary-600">
                            <span><?php echo e(auth()->user()->name); ?></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden group-hover:block">
                            <?php if(auth()->user()->isAdmin()): ?>
                                <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    Painel Admin
                                </a>
                            <?php endif; ?>
                            <a href="<?php echo e(route('user.dashboard')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                Minhas Inscrições
                            </a>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    Sair
                                </button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="text-gray-700 hover:text-primary-600">
                        Entrar
                    </a>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">
                        Criar Conta
                    </a>
                <?php endif; ?>
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button onclick="toggleMobileMenu()" class="text-gray-700 hover:text-primary-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="<?php echo e(route('home')); ?>" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Início</a>
            <a href="<?php echo e(route('about')); ?>" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Conheça</a>
            <a href="<?php echo e(route('worship')); ?>" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Cultos</a>
            <a href="<?php echo e(route('events.index')); ?>" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Eventos</a>
            <a href="<?php echo e(route('youth')); ?>" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Juventude</a>
            <a href="<?php echo e(route('contact')); ?>" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Contato</a>
            
            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->isAdmin()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Painel Admin</a>
                <?php endif; ?>
                <a href="<?php echo e(route('user.dashboard')); ?>" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Minhas Inscrições</a>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Sair</button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">Entrar</a>
                <a href="<?php echo e(route('register')); ?>" class="block px-3 py-2 rounded-md text-primary-600 hover:bg-gray-100">Criar Conta</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<?php /**PATH D:\CORUZEN\WEBCODER\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>