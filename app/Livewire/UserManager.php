<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;

class UserManager extends Component
{
    public $users, $user_id, $username, $password, $nombre, $rol = 'gestor';
    public $isOpen = false;
    public $search = '';

    public function mount()
    {
        if (auth()->user()->rol !== 'administrador') {
            abort(403, 'No tienes autorización para acceder a esta sección.');
        }
    }

    public function render()
    {
        $this->users = User::where('nombre', 'like', '%'.$this->search.'%')
            ->orWhere('username', 'like', '%'.$this->search.'%')
            ->orderBy('id', 'desc')
            ->get();
                               
        return view('livewire.user-manager')
            ->layout('layouts.app', ['header' => 'Gestión de Usuarios y Roles']);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->user_id = null;
        $this->username = '';
        $this->password = '';
        $this->nombre = '';
        $this->rol = 'gestor';
    }

    public function store()
    {
        $rules = [
            'nombre' => 'required',
            'username' => 'required|unique:usuarios,username,' . $this->user_id,
            'rol' => 'required',
        ];

        if (!$this->user_id) {
            $rules['password'] = 'required|min:6';
        }

        $this->validate($rules);

        $data = [
            'nombre' => $this->nombre,
            'username' => $this->username,
            'rol' => $this->rol,
        ];

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        if (!$this->user_id) {
            $data['created_at'] = now();
        }

        User::updateOrCreate(['id' => $this->user_id], $data);

        session()->flash('message', 
            $this->user_id ? 'Usuario actualizado exitosamente.' : 'Usuario registrado exitosamente.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->nombre = $user->nombre;
        $this->username = $user->username;
        $this->rol = $user->rol ?: 'gestor';
        $this->password = ''; // Don't show password
    
        $this->openModal();
    }

    public function delete($id)
    {
        if (auth()->id() == $id) {
            session()->flash('error', 'No puedes eliminar tu propia cuenta mientras estás conectado.');
            return;
        }

        User::find($id)->delete();
        session()->flash('message', 'Usuario eliminado exitosamente.');
    }
}
