<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Garage;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;

class GarageManager extends Component
{
    public $garages;
    public $garage_id, $capacity, $street, $number, $complement, $district, $city, $state, $zip_code;
    public $isModalOpen = false;
    public $spots_data = [];

    // Hook que é executado sempre que a propriedade $capacity é atualizada
    public function updatedCapacity($value)
    {
        $current_spots_count = count($this->spots_data);
        $new_capacity = (int)$value;

        if ($new_capacity > $current_spots_count) {
            for ($i = $current_spots_count; $i < $new_capacity; $i++) {
                $this->spots_data[] = ['identification' => 'Vaga #' . ($i + 1), 'supported_body_types' => 'all'];
            }
        } elseif ($new_capacity < $current_spots_count) {
            $this->spots_data = array_slice($this->spots_data, 0, $new_capacity);
        }
    }

    public function render()
    {
        $user = Auth::user();
        $this->garages = $user->garages()->withCount('rentals')->get();
        $this->pendingRentals = Rental::where('owner_id', $user->id)
                                      ->where('status', 'pending')
                                      ->with(['car', 'client'])
                                      ->get();
        return view('livewire.garage-manager')->layout('layouts.app');
    }
    
    // Abre o modal de criação
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal() { $this->isModalOpen = true; }
    public function closeModal() { $this->isModalOpen = false; }

    private function resetInputFields(){
        $this->garage_id = null;
        $this->capacity = '';
        $this->street = '';
        $this->number = '';
        $this->complement = '';
        $this->district = '';
        $this->city = '';
        $this->state = '';
        $this->zip_code = '';
    }
    
    // Salva a garagem
    public function store()
    {
        $validatedData = $this->validate([
            'capacity' => 'required|integer|min:1',
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:50',
            'district' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2',
            'zip_code' => 'required|string|max:9',
            'spots_data.*.identification' => 'required|string',
            'spots_data.*.supported_body_types' => 'required|in:hatch,sedan,suv,pickup,moto,all',
        ]);
        
        $validatedData['user_id'] = Auth::id();
        $garage = Garage::create($validatedData);

        // Criar as vagas personalizadas
        foreach ($this->spots_data as $spot) {
            $garage->spots()->create($spot);
        }

        if (!Auth::user()->hasRole('garage_owner')) {
            Auth::user()->assignRole('garage_owner');
        }

        session()->flash('message', 'Garagem e vagas cadastradas com sucesso.');
        $this->closeModal();
    }
    
    // Deleta a garagem (com validação)
    public function delete($id)
    {
        $garage = Garage::withCount('activeRental')->findOrFail($id);
        if ($garage->user_id !== Auth::id()) { abort(403); }
        
        // Regra de negócio: não pode excluir se tiver vagas alugadas
        if ($garage->active_rental_count > 0) {
            session()->flash('error', 'Não é possível excluir uma garagem com vagas alugadas.');
            return;
        }

        $garage->delete();
        session()->flash('message', 'Garagem excluída com sucesso.');
    }
}