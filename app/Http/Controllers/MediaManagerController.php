<?php

namespace App\Http\Controllers;

use App\Models\MediaManager;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;

class MediaManagerController extends Controller
{
    # get media files
    public function index(Request $request)
    {
        $searchKey  = null;
        $type       = null;

        $mediaFiles = MediaManager::query()->latest();

        if (Auth::user()->user_type != 'admin') {
            $mediaFiles = $mediaFiles->where('user_id', Auth::user()->id);
        }

        if ($request->type != 'all') {
            $mediaFiles = $mediaFiles->where('media_type', $type);
        }

        $recentFiles = $mediaFiles->take(3)->get();
        $recentFileIds = $recentFiles->pluck('id');

        if ($request->searchKey != null) {
            $searchKey = $request->searchKey;
            $mediaFiles = $mediaFiles->where('media_name', 'like', '%' . $request->searchKey . '%');
        }
        $mediaFiles  = $mediaFiles->whereNotIn('id', $recentFileIds)->paginate(paginationNumber(30))->appends(request()->query());

        return [
            'status' => true,
            'recentFiles' => view('backend.inc.media-manager.recent', compact('recentFiles'))->render(),
            'mediaFiles' => view('backend.inc.media-manager.previous', compact('mediaFiles'))->render(),
            'mediaQuery' => $mediaFiles
        ];
    }

    # get selected media files
    public function selectedFiles(Request $request)
    {
        $mediaFiles = MediaManager::whereIn('id', $request->mediaIds)->get();
        return [
            'status' => true,
            'mediaFiles' => view('backend.inc.media-manager.image', compact('mediaFiles'))->render()
        ];
    }

    # store media file to media manager
    public function store(Request $request)
    {
        if ($request->hasFile('media_file')) {
            $mediaFile = new MediaManager;
            $mediaFile->user_id = Auth::user()->id;

            $mediaFile->media_file = $request->file('media_file')->store('uploads/media');
            $mediaFile->media_size = $request->file('media_file')->getSize();
            $mediaFile->media_name = $request->file('media_file')->getClientOriginalName();
            $mediaFile->media_extension = $request->file('media_file')->getClientOriginalExtension();

            if (getFileType(Str::lower($mediaFile->media_extension)) != null) {
                $mediaFile->media_type = getFileType(Str::lower($mediaFile->media_extension));
            } else {
                $mediaFile->media_type = "unknown";
            }
            $mediaFile->save();
            return true;
        }
    }

    # delete media
    // public function delete($id)
    // {
    //     $mediaFile = MediaManager::findOrFail($id);
    //     if (!is_null($mediaFile)) {
    //         fileDelete($mediaFile->media_file);
    //         # todo:: check auth user, media user -- 
    //         $mediaFile->delete();
    //     }

    //     flash(localize('File has been deleted successfully'))->success();
    //     return back();
    // }

    public function delete($id)
    {

        $mediaFile = MediaManager::findOrFail($id);
        if (!is_null($mediaFile)) {
            fileDelete($mediaFile->media_file);
            # todo:: check auth user, media user --
            $mediaFile->delete();
        }

        return response()->json(['success' => true, 'message' => 'Il file è stato cancellato con successo']);
    }

    public function updateDetails(Request $request)
    {
        // Validazione dei dati ricevuti
        $request->validate([
            'media_id' => 'required|exists:media_managers,id',
            'alt_text' => 'nullable|string|max:255',
            'description' => 'nullable|string'
        ]);

        try {
            // Trova l'immagine tramite l'ID
            $mediaFile = MediaManager::findOrFail($request->media_id);

            // Aggiorna i campi alt_text e description
            $mediaFile->alt_text = $request->alt_text;
            $mediaFile->description = $request->description;
            $mediaFile->save();

            // Restituisce una risposta JSON di successo
            return response()->json(['success' => true, 'message' => 'Dettagli immagine aggiornati con successo.']);
        } catch (\Exception $e) {
            // Gestione dell'errore e restituzione di una risposta JSON di errore
            return response()->json(['success' => false, 'message' => 'Errore durante l\'aggiornamento dei dettagli dell\'immagine.'], 500);
        }
    }
}
