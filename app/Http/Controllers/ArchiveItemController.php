<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArchiveItemRequest;
use App\Http\Requests\UpdateArchiveItemRequest;
use App\Models\ArchiveItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArchiveItemController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = ArchiveItem::query()
            ->where('user_id', $user->id)
            ->with('assets');

        // Search by title/description
        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Filter by year (with NULL fallback to uploaded_at)
        if ($year = $request->get('year')) {
            $query->where(function ($q) use ($year) {
                $q->whereYear('captured_at', $year)
                  ->orWhere(function ($subQ) use ($year) {
                      $subQ->whereNull('captured_at')
                           ->whereYear('uploaded_at', $year);
                  });
            });
        }

        // Filter by file format/extension
        if ($format = $request->get('format')) {
            $query->whereHas('assets', function ($assetQuery) use ($format) {
                $assetQuery->where('extension', $format);
            });
        }

        // Sorting
        $sort = $request->get('sort', 'captured_at');
        $direction = $request->get('direction', 'desc');

        if (! in_array($sort, ['captured_at', 'uploaded_at'], true)) {
            $sort = 'captured_at';
        }

        if (! in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        // Use COALESCE for sorting when captured_at might be NULL
        $sortColumn = $sort === 'captured_at'
            ? DB::raw('COALESCE(captured_at, uploaded_at)')
            : $sort;

        $archives = $query->orderBy($sortColumn, $direction)
            ->paginate(15)
            ->withQueryString();

        return view('archives.index', compact('archives'));
    }

    public function create()
    {
        return view('archives.create');
    }

    public function store(StoreArchiveItemRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['uploaded_at'] = $data['uploaded_at'] ?? now();

        $archive = ArchiveItem::create($data);

        return redirect()
            ->route('archives.show', $archive)
            ->with('status', 'Archive created successfully.');
    }

    public function show(ArchiveItem $archive)
    {
        $this->authorize('view', $archive);

        $archive->load('assets');

        return view('archives.show', compact('archive'));
    }

    public function edit(ArchiveItem $archive)
    {
        $this->authorize('update', $archive);

        return view('archives.edit', compact('archive'));
    }

    public function update(UpdateArchiveItemRequest $request, ArchiveItem $archive)
    {
        $this->authorize('update', $archive);

        $archive->update($request->validated());

        return redirect()
            ->route('archives.show', $archive)
            ->with('status', 'Archive updated successfully.');
    }

    public function destroy(ArchiveItem $archive)
    {
        $this->authorize('delete', $archive);

        // Explicitly delete all asset files from storage
        foreach ($archive->assets as $asset) {
            if ($asset->file_path && Storage::disk('public')->exists($asset->file_path)) {
                Storage::disk('public')->delete($asset->file_path);
            }
        }

        $archive->delete();

        return redirect()
            ->route('archives.index')
            ->with('status', 'Archive deleted successfully.');
    }
}
