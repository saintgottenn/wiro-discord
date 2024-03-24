<?php

namespace App\Http\Controllers;

use App\Models\BankLog;
use Illuminate\Http\Request;
use App\Http\Resources\BankLogResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BankLogController extends Controller
{
    public function index(Request $request)
    {
        $bankLink = $request->query('bank_link');
        $balance = $request->query('balance');

        $bankLogs = BankLogResource::collection(
                        BankLog::when($bankLink, function($query) use ($bankLink) {
                                    return $query->where('bank_link', 'like', "%{$bankLink}%");
                                })
                                ->when($balance, function($query) use ($balance) {
                                    return $query->where('balance', 'like', "{$balance}%");
                                })
                                ->latest()
                                ->paginate(15)
                    )
                    ->response()
                    ->getData(true);

        return response()->json($bankLogs, 200);
    }

    public function store(Request $request)
    {
        $errors = [];
        $results = [];
        
        $dataItems = $request->input('data'); 

        foreach ($dataItems as $index => $itemData) {
            $archivePath = 'data.' . $index . '.archive'; 
            $imagePath = 'data.' . $index . '.image';

            if ($request->hasFile($archivePath)) {
                $file = $request->file($archivePath);

                $validMimeTypes = ['application/zip', 'application/x-zip-compressed', 'application/x-zip', 'multipart/x-zip'];
                $validExtension = 'zip';

                if (!in_array($file->getMimeType(), $validMimeTypes) || $file->getClientOriginalExtension() !== $validExtension) {
                    $errors[$index] = ['archive' => 'The archive must be a file of type: zip.'];
                    continue;
                }
            } else {
                $errors[$index] = ['archive' => 'Archive is required'];
                continue;
            }

            if($request->hasFile('data.' . $index . '.image')) {
                $image = $request->file($imagePath);

                $validMimeTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/avif'];
                $validExtensions = ['jpeg', 'jpg', 'png', 'webp', 'avif'];

                if (!in_array($image->getMimeType(), $validMimeTypes) || !in_array($image->getClientOriginalExtension(), $validExtensions)) {
                    $errors[$index] = ['image' => 'The image must be a file of type: jpeg, jpg, png, webp, avif.'];
                    continue;
                }
            } else {
                $errors[$index] = ['image' => 'Image is required'];
                continue;
            }
        
            $validator = Validator::make($itemData, [
                'seller_id' => 'required|integer|exists:users,id',
                'amount' => 'required|integer|max:255',
                'balance' => 'required|string|max:255',  
                'bank_link' => 'required|string|max:255',  
            ]);

            if ($validator->fails()) {
                $errors[$index] = $validator->errors();
                continue;
            }
            
            $file = $request->file($archivePath);
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $timestamp = time();
            $extension = $file->getClientOriginalExtension();
            $newFileName = $originalName . '_' . uniqid() . $timestamp . '.' . $extension;
            $fileUrl = Storage::url($file->storeAs('banklogs_archives', $newFileName, 'public'));

            $imageUrl = Storage::url($request->file($imagePath)->store('banklogs_images', 'public'));

            $itemData['archive_link'] = $fileUrl; 
            $itemData['image_link'] = $imageUrl; 
            unset($itemData['archive']);
            unset($itemData['image']);

            $validatedData = $validator->validated();
            $validatedData['archive_link'] = $itemData['archive_link']; 
            $validatedData['image_link'] = $itemData['image_link']; 

            $results[$index] = BankLog::create($validatedData); 
        }

        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }


        return response()->json(['message' => 'Data processed successfully', 'data' => $results], 201);
    }
    
    public function update(Request $request, $id)
    {
        $bankLog = BankLog::find($id);

        if (null === $bankLog) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'nullable|integer|max:255',
            'archive' => 'nullable|file|mimes:zip',
            'bank_link' => 'nullable|string|max:255', 
            'balance' => 'nullable|string|max:255', 
            'on_sale' => 'nullable|boolean', 
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        if($request->has('amount')) {
            $bankLog->amount = $request->amount;
        }

        if($request->has('bank_link')) {
            $bankLog->bank_link = $request->bank_link;
        }

        if($request->has('balance')) {
            $bankLog->balance = $request->balance;
        }

        if($request->has('on_sale')) {
            $bankLog->on_sale = $request->on_sale;
        }

        if($request->hasFile('archive')) {
            $file = $request->file('archive');

            $validMimeTypes = ['application/zip', 'application/x-zip-compressed', 'application/x-zip', 'multipart/x-zip'];
            $validExtension = 'zip';

            if (!in_array($file->getMimeType(), $validMimeTypes) || $file->getClientOriginalExtension() !== $validExtension) {
                return resonse()->json(['errors' => ['archive' => 'The archive must be a file of type: zip.']], 422);
            }

            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); 
            $timestamp = time(); 
            $extension = $file->getClientOriginalExtension();
            $newFileName = $originalName . '_' . uniqid() . $timestamp . '.' . $extension;

            $fileUrl = Storage::url($request->file('archive')->storeAs('banklogs_archives', $newFileName, 'public'));
            
            $bankLog->archive_link = $fileUrl;
        }

        if($request->has('image')) {
            $image = $request->file('image');

            $validMimeTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/avif'];
            $validExtensions = ['jpeg', 'jpg', 'png', 'webp', 'avif'];

            if (!in_array($image->getMimeType(), $validMimeTypes) || !in_array($image->getClientOriginalExtension(), $validExtensions)) {
                return response()->json(['errors' => ['image' => 'The image must be a file of type: jpeg, jpg, png, webp, avif.']], 422);
            }

            $imageUrl = Storage::url($image->store('banklogs_images', 'public'));
            
            $bankLog->image_link = $imageUrl;
        }

        $bankLog->save();

        return response()->json(['message' => 'Data has been successfully updated', 'bankLog' => $bankLog]);
    }

    public function delete($id)
    {
        $bankLog = BankLog::find($id);

        if($bankLog === null) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $bankLog->delete();

        return response()->json(['message' => 'Data has been successfully deleted']);
    }

}
