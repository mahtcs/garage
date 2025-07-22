<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <form>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium text-gray-900">Cadastrar Nova Garagem</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Campos do Endereço -->
                        <div>
                            <label for="street" class="block text-sm font-medium text-gray-700">Rua</label>
                            <input type="text" wire:model.defer="street" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="number" class="block text-sm font-medium text-gray-700">Número</label>
                            <input type="text" wire:model.defer="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="district" class="block text-sm font-medium text-gray-700">Bairro</label>
                            <input type="text" wire:model.defer="district" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">Cidade</label>
                            <input type="text" wire:model.defer="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700">Estado</label>
                            <input type="text" wire:model.defer="state" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label for="zip_code" class="block text-sm font-medium text-gray-700">CEP</label>
                            <input type="text" wire:model.defer="zip_code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label for="capacity" class="block text-sm font-medium text-gray-700">Capacidade (Nº de Vagas)</label>
                            <input type="number" wire:model.live="capacity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>

                    <!-- Detalhes das Vagas -->
                    @if($capacity > 0)
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-gray-800">Detalhes das Vagas</h4>
                        <div class="mt-2 space-y-4 max-h-60 overflow-y-auto">
                            @foreach($spots_data as $index => $spot)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-2 border rounded-md">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600">Identificação da Vaga {{ $index + 1 }}</label>
                                    <input type="text" wire:model.defer="spots_data.{{ $index }}.identification" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600">Tipos de Veículo Suportados</label>
                                    <select wire:model.defer="spots_data.{{ $index }}.supported_body_types" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                                        <option value="all">Todos</option>
                                        <option value="hatch">Hatch</option>
                                        <option value="sedan">Sedan</option>
                                        <option value="suv">SUV</option>
                                        <option value="pickup">Pickup</option>
                                        <option value="moto">Moto</option>
                                    </select>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click.prevent="store()" type="button" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Salvar Garagem</button>
                    <button wire:click="closeModal()" type="button" class="mr-3 bg-white hover:bg-gray-100 text-gray-700 font-bold py-2 px-4 rounded border">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>