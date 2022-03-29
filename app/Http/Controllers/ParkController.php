<?php
 
namespace App\Http\Controllers;
 
use App\Enums\RouteModel;
use \Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Park;
 
class ParkController extends Controller
{
    /**
     * Provision a new web server.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Park $park, Request $request)
    {
        // ...
        $validated = $request->validate([
            'id' => 'bail|required|integer|exists:breeds,id',
            'type' => 'required|in:'.RouteModel::Breed->value,
        ]);

        $park->breeds()->syncWithoutDetaching([$validated['id'] => ['created_at' => now(), 'updated_at' => now()]]);

        return response()->json([
            'message' => 'success'
        ], 200);
    }
}