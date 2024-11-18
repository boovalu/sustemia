<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Area;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Asegura que el usuario esté autenticado
    }

    public function index(Request $request)
    {
        $user = Auth::user();
    
        if (!$user->role) {
            return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta página.');
        }
    
        // Si el usuario es admin, redirigir a adminDashboard
        if ($user->role->name === 'admin') {
            return $this->adminDashboard();
        }

        // Para los demás roles, llamar a los métodos correspondientes
        switch ($user->role->name) {
            case 'editor':
                return $this->editorDashboard($request);
            case 'viewer':
                return $this->viewerDashboard($request);
            default:
                return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta página.');
        }
    }

    public function adminDashboard()
    {
        $users = User::all();
        $tasks = Task::with('area')->get();
        $areas = Area::all();
    
        return view('dashboards.admin', compact('users', 'tasks', 'areas'));
    }
    
    

    public function editorDashboard(Request $request)
    {
        // Validación de rol
        if (Auth::user()->role->name !== 'editor') {
            return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta página.');
        }

        $tasks = Task::with('area');
    
        // Buscar por palabras clave
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $tasks->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%")
                      ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }
        
        // Filtrar por área
        if ($request->filled('area')) {
            $tasks->where('area_id', $request->area);
        }
        
        // Filtrar por mes
        if ($request->filled('month')) {
            $tasks->whereMonth('due_date', $request->month);
        }
        
        // Filtrar por año
        if ($request->filled('year')) {
            $tasks->whereYear('due_date', $request->year);
        }
        
        // Filtrar por estado
        if ($request->filled('status')) {
            $tasks->where('status', $request->status);
        }
        
        // Obtener las tareas filtradas y ordenadas por la fecha de creación más reciente
        $tasks = $tasks->orderBy('created_at', 'desc')->get();
        $areas = Area::all();
    
        return view('dashboards.editor', compact('tasks', 'areas'));
    }

    public function viewerDashboard(Request $request)
    {
        // Validación de rol
        if (Auth::user()->role->name !== 'viewer') {
            return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta página.');
        }
    
        // Obtener todas las áreas
        $areas = Area::all();
    
        // Obtener todas las tareas con su área
        $tasks = Task::with('area');
    
        // Filtrar por área
        if ($request->filled('area')) {
            $tasks->where('area_id', $request->area);
        }
    
        // Filtrar por mes
        if ($request->filled('month')) {
            $tasks->whereMonth('due_date', $request->month);
        }
    
        // Filtrar por año
        if ($request->filled('year')) {
            $tasks->whereYear('due_date', $request->year);
        }
    
        // Filtrar tareas vencidas (si el filtro de "vencidas" está activado)
        if ($request->filled('overdue') && $request->overdue == '1') {
            $tasks->where('due_date', '<', now());
        }
    
        // Obtener las tareas filtradas
        $tasks = $tasks->get();
    
        // Agrupar tareas por año, área y mes
        $groupedTasks = [];
        foreach ($tasks as $task) {
            $year = $task->due_date->format('Y');
            $area = $task->area->name;
            $month = Carbon::parse($task->due_date)->translatedFormat('F');
    
            if (!isset($groupedTasks[$year][$area][$month])) {
                $groupedTasks[$year][$area][$month] = [];
            }
    
            $groupedTasks[$year][$area][$month][] = $task;
        }
    
        // Contar tareas por estado
        $tasksByStatus = [
            'Pendiente' => $tasks->where('status', 'Pendiente')->count(),
            'Completada' => $tasks->where('status', 'Completada')->count(),
            'Retrasada' => $tasks->where('due_date', '<', now())->count(),
        ];
    
        // Contar tareas por área
        $tasksByArea = $tasks->groupBy('area_id')->map(function ($tasks) {
            return $tasks->count();
        });
    
        // Asegurarse de que $tasks y otros datos sean pasados a la vista
        return view('dashboards.viewer', compact('groupedTasks', 'areas', 'tasksByStatus', 'tasksByArea', 'tasks'));
    }
    
    public function reportsDashboard()
{
    // Obtener las tareas próximas a vencer
    $upcomingTasks = Task::where('due_date', '>', now())
        ->orderBy('due_date')
        ->take(5)
        ->get();

    // Obtener las tareas retrasadas
    $overdueTasks = Task::where('due_date', '<', now())->get();

    // Contar tareas por estado
    $completedTasksCount = Task::where('status', 'Completada')->count();
    $pendingTasksCount = Task::where('status', 'Pendiente')->count();
    $overdueTasksCount = $overdueTasks->count(); // Ya hemos obtenido las retrasadas

    // Datos para el gráfico
    $taskStatusData = [
        'Completadas' => $completedTasksCount,
        'Pendientes' => $pendingTasksCount,
        'Retrasadas' => $overdueTasksCount,
    ];

    // Si es admin, contar usuarios, roles, tareas y áreas
    if (Auth::user()->role->name === 'admin') {
        $totalUsersCount = User::count();
        $totalRolesCount = \DB::table('roles')->count();
        $totalTasksCount = Task::count();
        $totalAreasCount = Area::count();

        return view('dashboards.reports', compact(
            'upcomingTasks',
            'overdueTasks',
            'totalUsersCount',
            'totalRolesCount',
            'totalTasksCount',
            'totalAreasCount',
            'taskStatusData',
            'completedTasksCount',
            'pendingTasksCount',
            'overdueTasksCount'
        ));
    }

    // Para editor y viewer, solo devuelve las tareas
    return view('dashboards.reports', compact('upcomingTasks', 'overdueTasks', 'taskStatusData', 'completedTasksCount', 'pendingTasksCount', 'overdueTasksCount'));
}
    
    
}
