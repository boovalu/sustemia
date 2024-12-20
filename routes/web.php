<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

// Rutas para el controlador de inicio
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Rutas de Autenticación (solo para usuarios invitados)
Route::middleware('guest')->group(function () {
  Route::get('/login', [AuthenticationController::class, 'login'])->name('auth.login');
  Route::post('/login', [AuthenticationController::class, 'processLogin'])->name('auth.login.process');
});

// Ruta para cerrar sesión (solo autenticados)
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('auth.logout');

// Rutas de perfil de usuario (solo autenticados)
Route::middleware('auth')->group(function () {
  Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
  Route::get('/profile/view', [ProfileController::class, 'show'])->name('profile.view');
});

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {

  // Dashboard general
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

  // Dashboards específicos por rol
  Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboards.admin');
  Route::get('/reports', [DashboardController::class, 'reportsDashboard'])->name('reports.index');
  Route::get('/editor', [DashboardController::class, 'editorDashboard'])->name('editor.index');
  Route::middleware('role:viewer')->get('/viewer', [DashboardController::class, 'viewerDashboard'])->name('viewer.index');

  // Ruta para ver detalles de una tarea (accesible para cualquier usuario autenticado)
  Route::get('tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');

  // Rutas de administración para tareas (solo accesibles por editores y administradores)
  Route::middleware('role:editor|admin')->prefix('tasks')->name('tasks.')->group(function () {
    Route::get('/create', [TaskController::class, 'create'])->name('create');
    Route::post('/', [TaskController::class, 'store'])->name('store');
    Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
    Route::put('/{task}', [TaskController::class, 'update'])->name('update');
  });
});

// Rutas específicas para administradores
Route::middleware(['auth', 'role:admin'])->group(function () {

  // Rutas de administración de tareas (solo accesibles para admin)
  Route::prefix('tasks')->name('tasks.')->group(function () {
    Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
    Route::get('/{task}/confirm-delete', [TaskController::class, 'confirmDelete'])->name('confirmDelete');
  });

  // Dashboard de administrador
  Route::get('/settings', [AdminController::class, 'index'])->name('admin.index');

  // Rutas de administración de usuarios (solo accesibles para admin)
  Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    Route::get('/{user}', [UserController::class, 'show'])->name('show');
    Route::post('/{user}/toggle', [UserController::class, 'toggleActive'])->name('toggle');
  });

  // Rutas de administración de áreas (solo accesibles para admin)
  Route::prefix('areas')->name('areas.')->group(function () {
    Route::get('/', [AreaController::class, 'index'])->name('index');
    Route::get('/create', [AreaController::class, 'create'])->name('create');
    Route::post('/', [AreaController::class, 'store'])->name('store');
    Route::get('/{area}', [AreaController::class, 'show'])->name('show');
    Route::get('/{area}/edit', [AreaController::class, 'edit'])->name('edit');
    Route::put('/{area}', [AreaController::class, 'update'])->name('update');
    Route::delete('/{area}', [AreaController::class, 'destroy'])->name('destroy');
  });
});

