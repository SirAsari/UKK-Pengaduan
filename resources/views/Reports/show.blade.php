<x-app-layout>
    <div class="container mx-auto mt-8">
        <!-- Report Details Section -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-blue-600 text-white px-6 py-4">
                <h1 class="text-2xl font-bold">Report Details</h1>
                <p class="text-sm">Report ID: <span class="font-semibold">{{ $report->id }}</span></p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        @if($report->image)
                            <img src="{{ asset('storage/' . $report->image) }}" alt="Report Image" class="rounded-lg shadow-md mt-2">
                        @endif
                        <p class="text-gray-700 pt-4"><strong>Voting:</strong>
                            <i class="fas fa-thumbs-up text-blue-500"></i> {{ $report->voting }}
                        </p>
                        <p class="text-gray-700"><strong>Viewers:</strong> {{ $report->viewers }}</p>
                    </div>

                    <div>
                        <p class="text-gray-700 pt-1"><strong>Description:</strong> {{ $report->description }}</p>
                        <p class="text-gray-700 pt-1"><strong>Type:</strong> {{ $report->type }}</p>
                        <p class="text-gray-700 pt-1"><strong>Province:</strong> {{ $report->province }}</p>
                        <p class="text-gray-700 pt-1"><strong>Regency:</strong> {{ $report->regency }}</p>
                        <p class="text-gray-700 pt-1"><strong>Subdistrict:</strong> {{ $report->subdistrict }}</p>
                        <p class="text-gray-700 pt-1"><strong>Village:</strong> {{ $report->village }}</p>
                        <p class="text-gray-700 pt-1"><strong>Status:</strong>
                            <span class="px-3 py-1 rounded-full text-white
                                @if($report->statement == 'pending') bg-yellow-500
                                @elseif($report->statement == 'on_process') bg-blue-500
                                @elseif($report->statement == 'done') bg-green-500
                                @elseif($report->statement == 'rejected') bg-red-500
                                @endif">
                                {{ ucfirst($report->statement) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Update Status Section (if user is staff) -->
            @if(auth()->user()->role === 'STAFF')
            <div class="bg-gray-100 px-6 py-4">
                <form action="{{ route('report.updateStatus', $report->id) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label for="statement" class="form-label">Update Report Status</label>
                        <select name="statement" id="statement" class="form-control" required
                                @if($report->statement === 'done') disabled @endif>
                            <option value="on_process" {{ $report->statement == 'on_process' ? 'selected' : '' }}>On Process</option>
                            <option value="done" {{ $report->statement == 'done' ? 'selected' : '' }}>Done</option>
                            <option value="rejected" {{ $report->statement == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    @if($report->statement !== 'done')
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    @else
                        <button type="button" class="btn btn-secondary" disabled>Laporan telah ditangani</button>
                    @endif
                </form>
            </div>

            @endif
        </div>

        <!-- Comments Section -->
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4">Comments</h2>
            <form action="{{ route('admin.report.comment', $report->id) }}" method="POST" class="mb-6">
                @csrf
                <textarea name="comment" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Write your comment..." required></textarea>
                <button type="submit" class="mt-3 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Submit Comment
                </button>
            </form>

            <div class="space-y-4">
                @forelse($report->comments as $comment)
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <p class="font-semibold">{{ $comment->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                        <p class="text-gray-700 mt-2">{{ $comment->comment }}</p>
                    </div>
                @empty
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <p class="text-gray-500">Belum ada komentar.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
