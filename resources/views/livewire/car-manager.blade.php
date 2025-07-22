<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @if (session()->has('message'))
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ session('message') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex justify-start space-x-4 my-3">
                    <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Cadastrar Novo Carro</button>
                    <a href="{{ route('garages.manager') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Inscrever Garagem</a>
                </div>

                @if($isModalOpen)
                    @include('livewire.create-car-modal')
                @endif

                <h3 class="text-lg font-semibold text-gray-900 mb-4 mt-6">Meus Carros</h3>
                <table class="table-fixed w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 w-20">No.</th>
                            <th class="px-4 py-2">Marca</th>
                            <th class="px-4 py-2">Modelo</th>
                            <th class="px-4 py-2">Placa</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cars as $car)
                        <tr>
                            <td class="border px-4 py-2">{{ $car->id }}</td>
                            <td class="border px-4 py-2">{{ $car->brand }}</td>
                            <td class="border px-4 py-2">{{ $car->model }}</td>
                            <td class="border px-4 py-2">{{ $car->plate }}</td>
                            <td class="border px-4 py-2">
                                @if($car->rental)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Alocado
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Sem Vaga
                                    </span>
                                @endif
                            </td>
                            <td class="border px-4 py-2">
                                <button wire:click="edit({{ $car->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                                <button wire:click="delete({{ $car->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Deletar</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>