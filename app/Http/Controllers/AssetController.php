<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetRequest;
use App\Models\ArchiveItem;
use App\Models\Asset;
use Illuminate\Support\Facades\Storage;
use Exception;

class AssetController extends Controller
{
    public function store(StoreAssetRequest $request, ArchiveItem $archive)
    {
        $this->authorize('update', $archive);

        $file = $request->file('file');

        try {
            // Store file in public storage
            $path = $file->store('archives', 'public');

            // Create asset record
            $asset = $archive->assets()->create([
                'file_path'         => $path,
                'original_filename' => $file->getClientOriginalName(),
                'mime_type'         => $file->getMimeType(),
                'extension'         => $file->getClientOriginalExtension(),
                'size_bytes'        => $file->getSize(),
                'uploaded_at'       => now(),
            ]);

            return back()->with('status', 'File uploaded successfully.');
        } catch (Exception $e) {
            // If DB creation fails, delete the uploaded file
            if (isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            return back()->withErrors(['file' => 'Failed to upload file. Please try again.']);
        }
    }

    public function download(Asset $asset)
    {
        $archive = $asset->archiveItem;
        $this->authorize('view', $archive);

        if (!Storage::disk('public')->exists($asset->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download(
            $asset->file_path,
            $asset->original_filename
        );
    }

    public function destroy(Asset $asset)
    {
        $archive = $asset->archiveItem;
        $this->authorize('update', $archive);

        // Delete file from storage
        if ($asset->file_path && Storage::disk('public')->exists($asset->file_path)) {
            Storage::disk('public')->delete($asset->file_path);
        }

        $asset->delete();

        return back()->with('status', 'File deleted successfully.');
    }
}
