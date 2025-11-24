<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
                    My Archives
                </h2>
                <p class="text-sm text-gray-600 mt-1">Manage your personal archives and collections</p>
            </div>
            <a href="{{ route('archives.create') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-lg rounded-lg shadow-xl hover:shadow-2xl transition-all transform hover:scale-105 hover:-translate-y-0.5">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create Archive
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Search and Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('archives.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Search -->
                            <div>
                                <label for="q" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <input type="text" name="q" id="q" value="{{ request('q') }}"
                                       placeholder="Search title or description..."
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Year Filter -->
                            <div>
                                <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                                <input type="number" name="year" id="year" value="{{ request('year') }}"
                                       placeholder="e.g., 2024"
                                       class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Format Filter -->
                            <div>
                                <label for="format" class="block text-sm font-medium text-gray-700 mb-1">File Format</label>
                                <select name="format" id="format" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All formats</option>
                                    <option value="jpg" {{ request('format') === 'jpg' ? 'selected' : '' }}>JPG</option>
                                    <option value="png" {{ request('format') === 'png' ? 'selected' : '' }}>PNG</option>
                                    <option value="gif" {{ request('format') === 'gif' ? 'selected' : '' }}>GIF</option>
                                    <option value="mp4" {{ request('format') === 'mp4' ? 'selected' : '' }}>MP4</option>
                                    <option value="pdf" {{ request('format') === 'pdf' ? 'selected' : '' }}>PDF</option>
                                    <option value="txt" {{ request('format') === 'txt' ? 'selected' : '' }}>TXT</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('archives.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Clear
                            </a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Archives Grid -->
            @if($archives->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($archives as $archive)
                        <div class="bg-white overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-200 border border-gray-100">
                            <a href="{{ route('archives.show', $archive) }}" class="block group">
                                <!-- Cover Image (First image asset) -->
                                @php
                                    $coverAsset = $archive->assets->where('mime_type', 'like', 'image/%')->first();
                                @endphp

                                @if($coverAsset)
                                    <div class="aspect-video bg-gray-200 overflow-hidden">
                                        <img src="{{ asset('storage/' . $coverAsset->file_path) }}"
                                             alt="{{ $archive->title }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="aspect-video bg-gray-100 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="p-5">
                                    <h3 class="font-semibold text-lg text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">{{ $archive->title }}</h3>

                                    @if($archive->description)
                                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ Str::limit($archive->description, 100) }}</p>
                                    @endif

                                    <div class="flex items-center justify-between text-xs text-gray-500 mb-3 pb-3 border-b border-gray-100">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            <span class="font-medium">{{ $archive->assets->count() }} files</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ $archive->captured_at?->format('M d, Y') ?? $archive->uploaded_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>

                                    @if($archive->category)
                                        <span class="inline-flex items-center px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-medium rounded-full">
                                            {{ $archive->category }}
                                        </span>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $archives->links() }}
                </div>
            @else
                <div class="bg-white overflow-hidden rounded-xl shadow-md p-16 border border-gray-100">
                    <div class="text-center max-w-2xl mx-auto">
                        <div class="bg-indigo-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                            <svg class="h-10 w-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No archives found</h3>
                        <p class="text-gray-600 mb-8">
                            @if(request()->has('q') || request()->has('year') || request()->has('format'))
                                No archives match your search criteria. Try adjusting your filters or create a new archive.
                            @else
                                Start preserving your memories by creating your first archive collection.
                            @endif
                        </p>
                        <a href="{{ route('archives.create') }}"
                           class="inline-flex items-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-lg rounded-lg shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create New Archive
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
