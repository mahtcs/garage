<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Car;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use App\Models\Garage;

class CarManager extends Component
{
    public $cars;
    public $car_id, $brand, $model, $year, $body_type, $plate;
    public $approvedRentals;
    public $isModalOpen = false;
    public $showFindSpotModal = false;
    public $selectedCar = null;
    public $searchCep;
    public $searchGaragesResult = [];
    public $showRequestModal = false;
    public $selectedGarage = null;
    public $startDate, $endDate;

    public function render()
    {
        $user = Auth::user();
        // Carrega os carros do usuário logado
        $this->cars = $user->cars()->get();
        
        // Carrega os aluguéis ativos do cliente para a notificação
        $this->approvedRentals = Rental::where('client_id', $user->id)
                                        ->where('status', 'active')
                                        ->with(['car', 'owner'])
                                        ->get();

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

    // Método para abrir o modal de busca
    public function findSpot($carId)
    {
        $this->selectedCar = Car::findOrFail($carId);
        $this->searchCep = Auth::user()->zip_code; // Sugere o CEP do usuário
        $this->searchGaragesResult = [];
        $this->showFindSpotModal = true;
    }

    public function searchGarages()
    {
        $this->validate(['searchCep' => 'required|string|max:9']);
        
        $this->searchGaragesResult = Garage::where('zip_code', $this->searchCep)
            ->whereHas('spots', function ($query) {
                $query->where(function ($q) {
                    $q->where('supported_body_types', $this->selectedCar->body_type)
                    ->orWhere('supported_body_types', 'all');
                })
                ->whereDoesntHave('activeRental'); // Apenas vagas sem aluguel ativo
            })
            ->with('owner')
            ->withCount(['spots' => function ($query) {
                $query->where(function ($q) {
                    $q->where('supported_body_types', $this->selectedCar->body_type)
                    ->orWhere('supported_body_types', 'all');
                })
                ->whereDoesntHave('activeRental');
            }])
            ->get();
    }

    // Método para abrir o segundo modal (solicitação)
    public function showRequestRentalModal($garageId)
    {
        $this->selectedGarage = Garage::findOrFail($garageId);
        $this->startDate = now()->toDateString();
        $this->endDate = now()->addMonth()->toDateString();
        $this->showFindSpotModal = false; // Fecha o modal de busca
        $this->showRequestModal = true; // Abre o modal de solicitação
    }

    public function createRentalRequest()
    {
        $this->validate([
            'startDate' => 'required|date|after_or_equal:today',
            'endDate' => 'required|date|after:startDate|before_or_equal:' . now()->addYear()->toDateString(),
        ]);

        // Encontra a primeira vaga disponível na garagem que seja compatível
        $spot = $this->selectedGarage->spots()
            ->where(function ($q) {
                $q->where('supported_body_types', $this->selectedCar->body_type)
                ->orWhere('supported_body_types', 'all');
            })
            ->whereDoesntHave('activeRental')
            ->first();

        if (!$spot) {
            session()->flash('error', 'Nenhuma vaga compatível está disponível nesta garagem no momento.');
            $this->showRequestModal = false;
            return;
        }

        Rental::create([
            'spot_id' => $spot->id,
            'car_id' => $this->selectedCar->id,
            'client_id' => Auth::id(),
            'owner_id' => $this->selectedGarage->user_id,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'status' => 'pending',
        ]);

        session()->flash('message', 'Sua solicitação foi enviada ao dono da garagem. Avisaremos quando for aprovada.');
        $this->showRequestModal = false;
    }
}
