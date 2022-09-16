<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Marcas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-center  bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h1 class="pb-4">Baja de una marca</h1>
    <!-- formulario -->
                    <div class="flex items-center justify-center shadow-md rounded-md max-w-3xl mb-72">
                        <form action="/marca/delete" method="post">
                            @csrf
                            <div class="p-6 bg-white">
                                <div>
                                    Se eliminará la marca:
                                    <span class="text-2xl text-yellow-600">Nombre</span>
                                </div>
                                <div class="py-6 flex items-center justify-end">

                                    <button class="text-yellow-900 hover:text-yellow-800
                                        bg-yellow-400 hover:bg-yellow-300 px-5 py-1 mr-6
                                        border border-yellow-500 rounded
                                        ">Confirmar baja</button>
                                    <a href="/marcas" class="text-yellow-600 hover:text-yellow-500
                                        bg-gray-50 hover:bg-white px-5 py-1
                                        border border-gray-300 rounded
                                        ">Volver a panel de marcas</a>

                                </div>

                            </div>
                        </form>

                    </div>
        <!-- FIN formulario -->

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
