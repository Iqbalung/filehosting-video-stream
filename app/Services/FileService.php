<?php

namespace App\Services;

use App\Helpers\StorageServerHelper;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileService implements FileServiceInterface
{
    /**
     * @param Request $request
     * @param mixed $directoryID
     * @return mixed
     * @throws \Exception
     */
    public function store(Request $request, $directoryID)
    {
        if ($request->hasFile("video")) {
            $fileDatabases = [];

            foreach ($request->file("video") as $file) {
                $random = substr(
                    str_shuffle(
                        "0123456789abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTVWXYZ"
                    ),
                    0,
                    8
                );
                $randomHash = $random;

                $filename = $random . "." . $file->getClientOriginalExtension();
                $fileStore = $file->storeAs("video", $filename, "s3");

                $fileParam = [
                    "user_id" => Auth::id(),
                    "directory_id" => $directoryID,
                    "storage_server_id" => StorageServerHelper::getActiveID(),
                    "code" => $randomHash,
                    "client_original_name" => $file->getClientOriginalName(),
                    "client_original_mime_type" => $file->getClientMimeType(),
                    "client_original_extension" => $file->getClientOriginalExtension(),
                    "name" => $filename,
                    "mime_type" => $file->getMimeType(),
                    "extension" => $file->extension(),
                    "path" => $fileStore,
                    "size" => $file->getSize(),
                ];

                $fileDatabase = new File($fileParam);

                foreach ($fileParam as $key => $value) {
                    $fileDatabase->$key = $value;
                }

                $fileDatabase->save();

                $fileDatabases[] = $fileDatabase;
            }

            return $fileDatabases;
        }
    }

    public function delete($fileID)
    {
        File::findOrFail($fileID)->delete();
    }
}
