<x-app-layout>
    <div class="flex justify-center items-start min-h-screen pt-10">
        <div class="w-full max-w-xl bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6 text-center">Create Staff</h1>

            <form action="{{ route('staff-management.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block font-semibold mb-1">Name</label>
                    <input type="text" name="name" id="name"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block font-semibold mb-1">Email</label>
                    <input type="email" name="email" id="email"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block font-semibold mb-1">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block font-semibold mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-6">
                    <label for="province" class="block font-semibold mb-1">Province</label>
                    <input type="text" name="province" id="province"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="flex justify-center space-x-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">Submit</button>
                    <a href="{{ route('staff-management.index') }}"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
