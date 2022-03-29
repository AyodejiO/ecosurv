<?php
 
namespace App\Http\Controllers;

use App\Enums\RouteModel;
use Illuminate\Database\Eloquent\Relations\Relation;
use \Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
 
class UserController extends Controller
{
    /**
     * Provision a new web server.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(User $user, Request $request)
    {
        // ...
        $validated = $request->validate([
            'id' => 'bail|required|integer',
            'type' => 'required',
        ]);

        $relation = $validated['type'] === RouteModel::Breed->value
            ? $user->breeds()
            : $user->parks();

        $model = $relation->getRelated()->findOrFail($validated['id']);

        $relation->syncWithoutDetaching([$model->id => ['created_at' => now(), 'updated_at' => now()]]);

        return response()->json([
            'message' => 'success'
        ], 200);
    }
}