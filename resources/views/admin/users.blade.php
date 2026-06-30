<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administración de usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="py-3 px-4">Nombre</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Rol actual</th>
                            <th class="py-3 px-4">Cambiar rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $user->name }}</td>
                                <td class="py-3 px-4">{{ $user->email }}</td>
                                <td class="py-3 px-4">
                                    {{ $user->roles->pluck('name')->join(', ') ?: '—' }}
                                </td>
                                <td class="py-3 px-4">
                                    <form action="{{ route('admin.users.assignRole', $user) }}"
                                        method="POST" class="flex gap-2">
                                        @csrf
                                        <select name="role"
                                            class="border-gray-300 rounded-md shadow-sm text-sm">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    @selected($user->hasRole($role->name))>
                                                    {{ ucfirst($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit"
                                            class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">
                                            Asignar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>