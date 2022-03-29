<?php

namespace App\Http\Controllers;

use Cache;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreBreedRequest;
use App\Http\Requests\UpdateBreedRequest;
use App\Models\Breed;

class BreedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $breeds = Cache::remember("breeds", 60, function () {
            if (Breed::count() > 0) {
                return Breed::all();
            }

            $response = Http::get(env('DOG_CEO_API') . 'breeds/list/all');
            $breeds = array_keys($response['message']);
            $breeds = array_map(function ($breed) {
                return [ 
                    'name' => $breed,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $breeds);

            Breed::insert($breeds);

            return Breed::all();
        });

        return response()->json([
            'data' => $breeds,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBreedRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBreedRequest $request)
    {
        //
    }

    private function getBreedImage ($name) :string {
        $response = Http::get(env('DOG_CEO_API') . "breed/{$name}/images");
        return $response['message'][0];
    }

    private function getBreed ($breed) :Breed {
        $breed = Cache::remember("breed-{$breed}", 60, function () use ($breed) {
            $breed = Breed::findorFail($breed);

            if (!$breed->image) {
                $breed->image = $this->getBreedImage($breed->name);
            }

            $breed->save();

            $breed->load([
                'users',
                'parks',
            ]);

            return $breed;
        });

        return $breed;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Breed  $breed
     * @return \Illuminate\Http\Response
     */
    public function show($breed)
    {
        //
        $breed = $this->getBreed($breed);

        return response()->json([
            'message' => 'success',
            'data' => $breed
        ], 200);
    }

    public function showRandom () {
        $breed = Breed::inRandomOrder()->limit(1)->first();

        if (!$breed->image) {
            $breed->image = $this->getBreedImage($breed->name);
        }

        $breed->save();

        return response()->json([
            'message' => 'success',
            'data' => $breed
        ]);
    }

    public function showImage ($breed) {
        $breed = $this->getBreed($breed);

        return response()->json([
            'data' => $breed->image,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Breed  $breed
     * @return \Illuminate\Http\Response
     */
    public function edit(Breed $breed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBreedRequest  $request
     * @param  \App\Models\Breed  $breed
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBreedRequest $request, Breed $breed)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Breed  $breed
     * @return \Illuminate\Http\Response
     */
    public function destroy(Breed $breed)
    {
        //
    }
}
