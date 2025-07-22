<div class="fixed z-20 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Solicitar Aluguel</h3>
                    <p class="text-sm text-gray-600 mt-1">Garagem de: {{ $selectedGarage->owner->name }}</p>
                    <div class="mt-4">
                        <div class="mb-4">
                            <label for="startDate" class="block text-gray-700 text-sm font-bold mb-2">Data de Início:</label>
                            <input type="date" wire:model="startDate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                            @error('startDate') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="endDate" class="block text-gray-700 text-sm font-bold mb-2">Data de Fim:</label>
                            <input type="date" wire:model="endDate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                            @error('endDate') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click.prevent="createRentalRequest()" type="button" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Confirmar
                    </button>
                    <button wire:click="$set('showRequestModal', false)" type="button" class="mr-3 bg-white hover:bg-gray-100 text-gray-700 font-bold py-2 px-4 rounded border border-gray-300">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
