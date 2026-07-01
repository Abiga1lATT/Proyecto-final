<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __('Eliminar cuenta') }}
        </h2>
        <p class="mt-1 text-sm text-gray-400">
            {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Antes de eliminarla, descarga cualquier información que desees conservar.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow transition-all duration-200">
        {{ __('Eliminar cuenta') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-gray-900">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-white">
                {{ __('¿Estás seguro de que quieres eliminar tu cuenta?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                {{ __('Una vez eliminada, todos los recursos y datos serán borrados permanentemente. Ingresa tu contraseña para confirmar.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Contraseña') }}" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 bg-gray-800 border-gray-700 text-white focus:border-purple-500 focus:ring-purple-500"
                    placeholder="{{ __('Contraseña') }}" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button"
                    x-on:click="$dispatch('close')"
                    class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg text-sm transition-all duration-200">
                    {{ __('Cancelar') }}
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow transition-all duration-200">
                    {{ __('Eliminar cuenta') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>