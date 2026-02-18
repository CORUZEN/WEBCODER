<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\WebhookController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Área Pública
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/conheca', [HomeController::class, 'about'])->name('about');
Route::get('/cultos', [HomeController::class, 'worship'])->name('worship');
Route::get('/juventude', [HomeController::class, 'youth'])->name('youth');
Route::get('/contato', [HomeController::class, 'contact'])->name('contact');

// Eventos
Route::get('/eventos', [EventController::class, 'index'])->name('events.index');
Route::get('/eventos/{slug}', [EventController::class, 'show'])->name('events.show');

/*
|--------------------------------------------------------------------------
| Autenticação
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/entrar', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/entrar', [AuthController::class, 'login']);
    Route::get('/cadastrar', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/cadastrar', [AuthController::class, 'register']);
});

Route::post('/sair', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Área do Usuário
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('minha-conta')->name('user.')->group(function () {
    Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/inscricoes', [UserDashboardController::class, 'registrations'])->name('registrations');
    Route::get('/inscricoes/{code}', [UserDashboardController::class, 'showRegistration'])->name('registrations.show');
});

/*
|--------------------------------------------------------------------------
| Inscrições
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::post('/eventos/{event}/inscrever', [RegistrationController::class, 'store'])->name('registrations.store');
});

/*
|--------------------------------------------------------------------------
| Pagamentos
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('pagamento')->name('payment.')->group(function () {
    Route::get('/{registrationCode}', [PaymentController::class, 'create'])->name('create');
    Route::get('/retorno/sucesso', [PaymentController::class, 'success'])->name('success');
    Route::get('/retorno/falha', [PaymentController::class, 'failure'])->name('failure');
    Route::get('/retorno/pendente', [PaymentController::class, 'pending'])->name('pending');
});

/*
|--------------------------------------------------------------------------
| Webhooks (sem CSRF)
|--------------------------------------------------------------------------
*/

Route::post('/webhooks/mercadopago', [WebhookController::class, 'mercadopago'])
    ->name('webhooks.mercadopago')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

/*
|--------------------------------------------------------------------------
| Painel Administrativo
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', EnsureUserIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Eventos
    Route::resource('eventos', AdminEventController::class)->parameters(['eventos' => 'event']);
    Route::get('/eventos/{event}/export', [AdminEventController::class, 'export'])->name('events.export');
    
    // Inscrições
    Route::get('/inscricoes', [AdminRegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/inscricoes/{registration}', [AdminRegistrationController::class, 'show'])->name('registrations.show');
    Route::post('/inscricoes/{registration}/cancelar', [AdminRegistrationController::class, 'cancel'])->name('registrations.cancel');
});

// ROTA TEMPORÁRIA DE SETUP - DELETE APÓS USO
// Acesse: /setup-iagus-2026?token=IAGUS_SETUP_KEY
Route::get('/setup-iagus-2026', function (\Illuminate\Http\Request $request) {
    if ($request->query('token') !== 'IAGUS_SETUP_KEY') {
        abort(403);
    }
    $output = '<pre style="background:#111;color:#0f0;padding:20px;font-family:monospace;">';
    $output .= "=== SETUP IAGUS ===\n\n";
    $kernel = app(\Illuminate\Contracts\Console\Kernel::class);
    foreach (['migrate --force', 'optimize:clear', 'optimize', 'storage:link --relative'] as $cmd) {
        $output .= "▶ php artisan $cmd\n";
        try {
            $parts = explode(' ', $cmd);
            $command = array_shift($parts);
            $args = [];
            foreach ($parts as $p) { if (str_starts_with($p, '--')) $args[ltrim($p,'--')] = true; }
            $kernel->call($command, $args);
            $output .= $kernel->output() . "✅ OK\n\n";
        } catch (\Exception $e) {
            $output .= "❌ " . $e->getMessage() . "\n\n";
        }
    }
    @chmod(storage_path(), 0775);
    @chmod(base_path('bootstrap/cache'), 0775);
    $output .= "✅ chmod storage e bootstrap/cache\n\n";
    $output .= "=== CONCLUÍDO ===\n⚠️ DELETE ESTA ROTA DO web.php AGORA!\n</pre>";
    return $output;
});
