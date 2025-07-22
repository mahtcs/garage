<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Encontrar Vaga para: {{ $selectedCar->brand }} {{ $selectedCar->model }}</h3>
                <div class="mt-4 flex items-center space-x-3">
                    <input type="text" wire:model.defer="searchCep" placeholder="Digite o CEP" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    <button wire:click="searchGarages" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buscar</button>
                </div>

                <div class="mt-6">
                    <!-- Carrossel de Resultados (simplificado como uma lista) -->
                    @forelse($searchGaragesResult as $garage)
                        <div class="p-4 border rounded-lg mb-3">
                            <h4 class="font-bold">Garagem de {{ $garage->owner->name }} em {{ $garage->district }}</h4>
                            <p>Capacidade: {{ $garage->capacity }} vagas.</p>
                            <p>Há <strong>{{ $garage->spots_count }}</strong> vagas que atendem seu carro.</p>
                            <button wire:click="showRequestRentalModal({{ $garage->id }})" class="mt-2 bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                                Solicitar Aluguel de Vaga
                            </button>
                        </div>
                    @empty
                        <p class="text-gray-500">Nenhuma garagem encontrada para este CEP e tipo de carro.</p>
                    @endforelse
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button wire:click="$set('showFindSpotModal', false)" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base font-medium text-gray-700">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>