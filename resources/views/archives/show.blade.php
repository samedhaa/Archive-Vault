<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ $archive->title }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">View and manage your archive</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('archives.edit', $archive) }}" class="inline-flex items-center px-6 py-3 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Archive
                </a>
                <form method="POST" action="{{ route('archives.destroy', $archive) }}" onsubmit="return confirm('Are you sure you want to delete this archive and all its files?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Archive Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($archive->description)
                        <p class="text-gray-700 mb-4">{{ $archive->description }}</p>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        @if($archive->category)
                            <div>
                                <span class="font-medium text-gray-600">Category:</span>
                                <span class="ml-2 px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full">{{ $archive->category }}</span>
                            </div>
                        @endif

                        @if($archive->captured_at)
                            <div>
                                <span class="font-medium text-gray-600">Captured:</span>
                                <span class="text-gray-900">{{ $archive->captured_at->format('F d, Y') }}</span>
                            </div>
                        @endif

                        @if($archive->location)
                            <div>
                                <span class="font-medium text-gray-600">Location:</span>
                                <span class="text-gray-900">{{ $archive->location }}</span>
                            </div>
                        @endif

                        <div>
                            <span class="font-medium text-gray-600">Uploaded:</span>
                            <span class="text-gray-900">{{ $archive->uploaded_at->format('F d, Y') }}</span>
                        </div>

                        <div>
                            <span class="font-medium text-gray-600">Total Files:</span>
                            <span class="text-gray-900">{{ $archive->assets->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            <div class="bg-gradient-to-br from-indigo-50 to-white overflow-hidden rounded-xl shadow-md border-2 border-indigo-100">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-indigo-100 rounded-lg p-2 mr-3">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Upload Files</h3>
                            <p class="text-sm text-gray-600">Add photos, videos, and documents to this archive</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('archives.assets.store', $archive) }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div class="bg-white rounded-lg p-3 border-2 border-dashed border-gray-300 hover:border-indigo-400 transition-colors">
                            <label for="file" class="block cursor-pointer">
                                <div class="text-center py-3">
                                    <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div>
                                        <span class="text-indigo-600 font-semibold hover:text-indigo-500">Click to select a file</span>
                                        <span class="text-gray-600"> or drag and drop</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">JPEG, PNG, GIF, MP4, PDF, TXT up to 20MB</p>
                                </div>
                                <input type="file" name="file" id="file" required class="hidden">
                            </label>
                            @error('file')
                                <p class="mt-2 text-sm text-red-600 text-center">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-center">
                            <button type="submit" class="inline-flex items-center px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-lg rounded-lg shadow-xl hover:shadow-2xl transition-all duration-200 transform hover:scale-105 hover:-translate-y-0.5">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Upload File
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Files List -->
            @if($archive->assets->count() > 0)
                <div class="bg-white overflow-hidden rounded-xl shadow-md border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Uploaded Files</h3>
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm font-medium rounded-full">
                                {{ $archive->assets->count() }} {{ Str::plural('file', $archive->assets->count()) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($archive->assets as $asset)
                                <div class="border-2 border-gray-100 rounded-xl p-4 hover:border-indigo-300 hover:shadow-md transition-all bg-gray-50">
                                    <!-- Preview -->
                                    @if(str_starts_with($asset->mime_type, 'image/'))
                                        <div class="aspect-video bg-gray-100 rounded mb-3 overflow-hidden">
                                            <img src="{{ asset('storage/' . $asset->file_path) }}"
                                                 alt="{{ $asset->original_filename }}"
                                                 class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="aspect-video bg-gray-100 rounded mb-3 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif

                                    <!-- File Info -->
                                    <div class="space-y-2">
                                        <p class="text-sm font-medium text-gray-900 truncate" title="{{ $asset->original_filename }}">
                                            {{ $asset->original_filename }}
                                        </p>

                                        <div class="flex items-center justify-between text-xs text-gray-500">
                                            <span class="uppercase">{{ $asset->extension }}</span>
                                            <span>{{ number_format($asset->size_bytes / 1024, 1) }} KB</span>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex gap-2 pt-2">
                                            <a href="{{ route('assets.download', $asset) }}"
                                               class="flex-1 text-center px-3 py-1.5 bg-indigo-600 text-white text-xs rounded hover:bg-indigo-700">
                                                Download
                                            </a>
                                            <form method="POST" action="{{ route('assets.destroy', $asset) }}"
                                                  onsubmit="return confirm('Are you sure you want to delete this file?');"
                                                  class="flex-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full px-3 py-1.5 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden rounded-xl shadow-md border border-gray-100 p-12">
                    <div class="text-center">
                        <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">No files yet</h4>
                        <p class="text-gray-600">Use the upload form above to add your first file to this archive.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
