<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Area;
use Illuminate\Http\Request;
use Carbon\Carbon;


class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('area')->get();
        return view('tasks.index', compact('tasks'));
    }
    

    public function show(Task $task)
    {
        $areas = Area::all(); // Carga todas las áreas
        
        return view('tasks.show', compact('task', 'areas'));
    }
    

    public function create()
    {
        $areas = Area::all();
        return view('tasks.create', compact('areas'));
    }

    public function store(Request $request)
    {
        // Validación de los campos requeridos
        $request->validate([
            'title' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'due_date' => 'required|date|after_or_equal:today', // Validación para que la fecha sea igual o posterior a la fecha actual
            'description' => 'required|string',
        ], [
            'due_date.after_or_equal' => 'La fecha de vencimiento no puede ser menor a la fecha actual.', // Mensaje de error personalizado
        ]);
    
        // Si la validación pasa, crear la tarea
        Task::create([
            'user_id' => auth()->id(),
            'area_id' => $request->area_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => 'Pendiente',
        ]);
    
        // Redireccionar según el rol del usuario
        $user = auth()->user();
        if ($user->role->name === 'editor') {
            return redirect()->route('editor.index')->with('success', 'Tarea creada con éxito.');
        } elseif ($user->role->name === 'admin') {
            return redirect()->route('tasks.index')->with('success', 'Tarea creada con éxito.');
        }
    
        // Redirección por defecto si no se encuentra el rol
        return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta página.');
    }
 
    

    public function edit(Task $task)
    {
        $areas = Area::all();
        return view('tasks.edit', compact('task', 'areas'));
    }


    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'due_date' => 'required|date',
            'status' => 'required|in:Pendiente,Completada',
        ]);
    
        // Si el estado es "Completada" y no tiene fecha de cierre, asignamos la fecha actual
        if ($request->status === 'Completada') {
            if (!$task->completed_at) {
                $task->completed_at = Carbon::now(); // Establecemos la fecha de completado como la fecha y hora actual
            }
        } else {
            // Si el estado es "Pendiente", eliminamos la fecha de cierre
            $task->completed_at = null;
        }
    
        // Actualizamos la tarea con los nuevos valores
        $task->update($request->only('title', 'area_id', 'due_date', 'status'));
    
        $user = auth()->user();
    
        // Redireccionar según el rol del usuario
        if ($user->role->name === 'editor') {
            return redirect()->route('editor.index')->with('success', 'Tarea actualizada con éxito.');
        } elseif ($user->role->name === 'admin') {
            return redirect()->route('tasks.index')->with('success', 'Tarea actualizada con éxito.');
        }
    
        return redirect()->route('home')->with('success', 'Tarea actualizada con éxito.');
    }
    
    

    public function destroy(Task $task)
    {
        $task->delete();
        
        // Redireccionar según el rol del usuario
        $user = auth()->user();
        if ($user->role->name === 'editor') {
            return redirect()->route('editor.index')->with('success', 'Tarea eliminada con éxito.');
        } elseif ($user->role->name === 'admin') {
            return redirect()->route('tasks.index')->with('success', 'Tarea eliminada con éxito.');
        }
    
        // Redirección por defecto si no se encuentra el rol
        return redirect()->route('home')->with('error', 'No tienes permisos para acceder a esta página.');
    }
    
}
