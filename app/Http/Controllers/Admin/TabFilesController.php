<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TabFiles;
use App\Models\Tabs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;

class TabFilesController extends Controller
{
    /**
     * List files for a tab.
     */
    public function index(Tabs $tab)
    {
        $files = $tab->files()->orderBy('sort_order')->get();

        return view('admin.tab-files.index', compact('tab', 'files'));
    }

    /**
     * Store uploaded file.
     */
public function store(Request $request, Tabs $tab)
{
    $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

    if (!$receiver->isUploaded()) {
        return response()->json(['error' => 'Upload failed'], 400);
    }

    $save = $receiver->receive();

    if ($save->isFinished()) {

        $file = $save->getFile();
        $originalName = $file->getClientOriginalName();

        $destinationPath = public_path('factsheet/Policies');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $fileName = time().'_'.$originalName;

        $file->move($destinationPath, $fileName);

        TabFiles::create([
            'tab_id' => $tab->id,
            'category' => 'file',
            'title' => $request->title,
            'file_path' => 'factsheet/Policies/'.$fileName,
            'status' => 1,
            'sort_order' => ($tab->files()->max('sort_order') ?? 0) + 1,
        ]);

        return response()->json(['success' => true]);
    }

    // Not finished yet
    $handler = $save->handler();

    return response()->json([
        'done' => $handler->getPercentageDone()
    ]);
}

public function storeChunk(Request $request, Tabs $tab)
{
    $fileName     = $request->resumableFilename;
    $chunkNumber  = $request->resumableChunkNumber;
    $totalChunks  = $request->resumableTotalChunks;

    $tempPath = storage_path('app/chunks/'.$fileName);

    if (!file_exists($tempPath)) {
        mkdir($tempPath, 0777, true);
    }

    $chunk = $request->file('file');

    if (!$chunk) {
        return response()->json(['error' => 'No chunk'], 400);
    }

    $chunk->move($tempPath, $chunkNumber);

    // If last chunk → merge
    if ($chunkNumber == $totalChunks) {

        $destinationPath = public_path('factsheet/Policies');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $finalPath = $destinationPath.'/'.$fileName;

        $out = fopen($finalPath, "ab");

        for ($i = 1; $i <= $totalChunks; $i++) {
            fwrite($out, file_get_contents($tempPath.'/'.$i));
            unlink($tempPath.'/'.$i);
        }

        fclose($out);
        rmdir($tempPath);

        TabFiles::create([
            'tab_id'    => $tab->id,
            'category'  => 'file',
            'title'     => $request->title ?? $fileName,
            'file_path' => 'factsheet/Policies/'.$fileName,
            'status'    => $request->status ?? 1,
            'sort_order'=> ($tab->files()->max('sort_order') ?? 0) + 1,
        ]);
    }

    return response()->json(['success' => true]);
}

    /**
     * Delete file.
     */
    public function destroy(TabFiles $file)
    {
        if ($file->file_path && Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        $file->delete();

        return back()->with('success', 'File deleted successfully');
    }
    
}
