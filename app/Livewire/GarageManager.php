<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Garage;
use Illuminate\Support\Facades\Auth;

class GarageManager extends Component
{
    public $garages;
    public $garage_id, $capacity, $street, $number, $complement, $district, $city, $state, $zip_code;
    public $isModalOpen = false;

    public function render()
    {
        // Carrega as garagens do usuário logado
        $this->garages = Auth::user()->garages()->withCount('spots')->get();
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
        $this->validate([
            'capacity' => 'required|integer|min:1',
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:50',
            'district' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2',
            'zip_code' => 'required|string|max:9',
        ]);

        $garage = Garage::updateOrCreate(['id' => $this->garage_id], [
            'user_id' => Auth::id(),
            'capacity' => $this->capacity,
            'street' => $this->street,
            'number' => $this->number,
            'complement' => $this->complement,
            'district' => $this->district,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
        ]);

        // Se for uma garagem nova, cria os spots
        if (!$this->garage_id) {
            for ($i = 1; $i <= $garage->capacity; $i++) {
                $garage->spots()->create([
                    'identification' => "Vaga #{$i}",
                    'supported_body_types' => 'all' // Padrão
                ]);
            }
        }

        // Atribui o role se o usuário ainda não tiver
        if (!Auth::user()->hasRole('garage_owner')) {
            Auth::user()->assignRole('garage_owner');
        }

        session()->flash('message', 'Garagem salva com sucesso.');
        $this->closeModal();
        $this->resetInputFields();
    }
    
    // Edita a garagem (aqui não permitimos alterar endereço, apenas capacidade)
    public function edit($id)
    {
        $garage = Garage::findOrFail($id);
        if ($garage->user_id !== Auth::id()) { abort(403); }

        $this->garage_id = $id;
        $this->capacity = $garage->capacity;
        // Preenche os outros campos apenas para exibição (desabilitados no form)
        $this->street = $garage->street;
        $this->number = $garage->number;
        $this->district = $garage->district;
        $this->city = $garage->city;
        $this->state = $garage->state;
        $this->zip_code = $garage->zip_code;

        $this->openModal();
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