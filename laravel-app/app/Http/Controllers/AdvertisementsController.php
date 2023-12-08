<?php

namespace App\Http\Controllers;

use App\Models\Advertisements;
use Illuminate\Http\Request;

class AdvertisementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            // title description type
            $advertisements = Advertisements::where('title', 'like', '%' . $request->search . '%')->orWhere('type', 'like', '%' . $request->search . '%')->orderBy('created_at', 'desc')->paginate(10);
            if ($advertisements->isEmpty()) {
                return response()->json(['message' => 'No advertisements found'], 404);
            }
            return response()->json(
                [
                    'data' => $advertisements,
                    'message' => 'success',
                ],
                200
            );
        }
        $advertisements = Advertisements::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(10);
        if ($advertisements->isEmpty()) {
            return response()->json(['message' => 'No advertisements found for this user'], 404);
        }
        return response()->json(
            [
                'data' => $advertisements,
                'message' => 'success',
            ],
            200
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'type' => 'required',
        ]);

        $advertisement = Advertisements::create([
            'user_id' => auth()->user()->id,
            'title' => $validate['title'],
            'description' => $validate['description'],
            'type' => $validate['type'],
        ]);

        return response()->json(
            [
                'data' => $advertisement,
                'message' => 'success',
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Advertisements $advertisements)
    {
        $advertisement = Advertisements::find($advertisements);
        return response()->json(
            [
                'data' => $advertisement,
                'message' => 'success',
            ],
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advertisements $advertisements)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advertisements $advertisements)
    {
        $validate = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'type' => 'required',
        ]);

        $advertisement = Advertisements::find($advertisements);
        $advertisement->title = $validate['title'];
        $advertisement->description = $validate['description'];
        $advertisement->type = $validate['type'];
        $advertisement->save();

        return response()->json(
            [
                'data' => $advertisement,
                'message' => 'success',
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertisements $advertisements)
    {
        $advertisement = Advertisements::find($advertisements);
        $advertisement->delete();

        return response()->json(
            [
                'data' => $advertisement,
                'message' => 'success',
            ],
            200
        );
    }
}
