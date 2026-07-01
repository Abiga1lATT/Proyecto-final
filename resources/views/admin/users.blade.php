<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Administración de usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1a2332] shadow-lg sm:rounded-lg overflow-hidden border border-[#2a3a4e]">
                <table class="w-full text-left">
                    <thead class="bg-[#0f1623] border-b border-[#2a3a4e]">
                        <tr>
                            <th class="py-3 px-4 text-gray-300 font-medium">Nombre</th>
                            <th class="py-3 px-4 text-gray-300 font-medium">Email</th>
                            <th class="py-3 px-4 text-gray-300 font-medium">Rol actual</th>
                            <th class="py-3 px-4 text-gray-300 font-medium">Cambiar rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b border-[#2a3a4e] hover:bg-[#1f2a3e] transition-colors">
                                <td class="py-3 px-4 text-gray-300">{{ $user->name }}</td>
                                <td class="py-3 px-4 text-gray-300">{{ $user->email }}</td>
                                <td class="py-3 px-4">
                                    @php $userRoles = $user->roles->pluck('name')->toArray(); @endphp
                                    @if (count($userRoles) > 0)
                                        @foreach ($userRoles as $userRole)
                                            <span class="px-2 py-0.5 text-xs rounded-full
                                                {{ $userRole === 'admin' ? 'bg-purple-900/30 text-purple-400 border border-purple-700' : '' }}
                                                {{ $userRole === 'lider' ? 'bg-blue-900/30 text-blue-400 border border-blue-700' : '' }}
                                                {{ $userRole === 'colaborador' ? 'bg-green-900/30 text-green-400 border border-green-700' : '' }}
                                                {{ $userRole === 'invitado' ? 'bg-gray-700/30 text-gray-400 border border-gray-600' : '' }}">
                                                {{ ucfirst($userRole) }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-gray-500">—</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <form action="{{ route('admin.users.assignRole', $user) }}"
                                        method="POST" class="flex gap-2">
                                        @csrf
                                        <select name="role"
                                            class="bg-[#0f1623] border-[#2a3a4e] text-white rounded-md shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    @selected($user->hasRole($role->name))
                                                    class="bg-[#1a2332]">
                                                    {{ ucfirst($role->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit"
                                            class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                                            Asignar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4 bg-[#0f1623] border-t border-[#2a3a4e]">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>