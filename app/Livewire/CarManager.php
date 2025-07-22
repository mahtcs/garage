<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;

class CarManager extends Component
{
    public $cars;
    public $car_id, $brand, $model, $year, $body_type, $plate;
    public $isModalOpen = false;

    public function render()
    {
        $this->cars = Auth::user()->cars()->get();
        return view('livewire.car-manager')->layout('layouts.app');
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->car_id = null;
        $this->brand = '';
        $this->model = '';
        $this->year = '';
        $this->body_type = '';
        $this->plate = '';
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function store()
    {
        $this->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|digits:4',
            'body_type' => 'required|in:hatch,sedan,suv,pickup,moto',
            'plate' => 'required|string|unique:cars,plate,' . $this->car_id,
        ]);

        Car::updateOrCreate(['id' => $this->car_id], [
            'user_id' => Auth::id(),
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'body_type' => $this->body_type,
            'plate' => $this->plate,
        ]);

        session()->flash('message', $this->car_id ? 'Carro atualizado com sucesso.' : 'Carro cadastrado com sucesso.');

        $this->closeModal();
        $this->resetInputFields();
    }
    // Carrega os dados do carro para edição
    public function edit($id)
    {
        $car = Car::findOrFail($id);
        // Garante que o usuário só pode editar o próprio carro
        if ($car->user_id !== Auth::id()) {
            abort(403);
        }

        $this->car_id = $id;
        $this->brand = $car->brand;
        $this->model = $car->model;
        $this->year = $car->year;
        $this->body_type = $car->body_type;
        $this->plate = $car->plate;

        $this->openModal();
    }

    public function delete($id)
    {
        $car = Car::findOrFail($id);
        if ($car->user_id !== Auth::id()) {
            abort(403);
        }
        $car->delete();
        session()->flash('message', 'Carro deletado com sucesso.');
    }

}
