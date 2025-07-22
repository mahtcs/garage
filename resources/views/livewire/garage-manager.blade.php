<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minhas Garagens') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                
                
                @if (session()->has('message'))
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                        <p class="text-sm">{{ session('message') }}</p>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-3" role="alert">
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                @endif

                <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Cadastrar Nova Garagem</button>

                @if($isModalOpen)
                    @include('livewire.create-garage-modal') 
                @endif

                <table class="table-fixed w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2">Endereço</th>
                            <th class="px-4 py-2">Capacidade</th>
                            <th class="px-4 py-2">Vagas Ocupadas</th>
                            <th class="px-4 py-2">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($garages as $garage)
                        <tr>
                            <td class="border px-4 py-2">{{ $garage->street }}, {{ $garage->number }} - {{ $garage->district }}</td>
                            <td class="border px-4 py-2">{{ $garage->capacity }}</td>
                            <td class="border px-4 py-2">{{ $garage->rentals_count }}</td>
                            <td class="border px-4 py-2">
                                <button wire:click="edit({{ $garage->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                                <button wire:click="delete({{ $garage->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Deletar</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
