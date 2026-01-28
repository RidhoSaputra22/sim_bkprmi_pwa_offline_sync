<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Santri;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SyncController extends Controller
{
    /**
     * Get all data for initial sync/cache
     */
    public function index(Request $request)
    {
        return response()->json([
            'santri' => Santri::with('person')->get(),
            'activities' => Activity::with('unit')->get(),
            'units' => Unit::all(),
            'synced_at' => now()->toISOString(),
        ]);
    }

    /**
     * Get data that changed since last sync
     */
    public function delta(Request $request)
    {
        $lastSync = $request->input('last_sync');

        $query = fn($model) => $lastSync
            ? $model::where('updated_at', '>', $lastSync)
            : $model::query();

        return response()->json([
            'santri' => $query(Santri::class)->with('person')->get(),
            'activities' => $query(Activity::class)->with('unit')->get(),
            'units' => $query(Unit::class)->get(),
            'synced_at' => now()->toISOString(),
        ]);
    }

    /**
     * Sync offline changes to server
     */
    public function push(Request $request)
    {
        $operations = $request->input('operations', []);
        $results = [];
        $errors = [];

        DB::beginTransaction();

        try {
            foreach ($operations as $operation) {
                $result = $this->processOperation($operation);
                if ($result['success']) {
                    $results[] = $result;
                } else {
                    $errors[] = $result;
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'synced' => count($results),
                'failed' => count($errors),
                'results' => $results,
                'errors' => $errors,
                'synced_at' => now()->toISOString(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Sync failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Process a single sync operation
     */
    protected function processOperation(array $operation): array
    {
        $type = $operation['type'] ?? null;
        $action = $operation['action'] ?? null;
        $data = $operation['data'] ?? [];
        $localId = $operation['local_id'] ?? null;

        try {
            $model = match($type) {
                'santri' => Santri::class,
                'activity' => Activity::class,
                'unit' => Unit::class,
                default => throw new \Exception("Unknown type: {$type}"),
            };

            $result = match($action) {
                'create' => $this->handleCreate($model, $data),
                'update' => $this->handleUpdate($model, $data),
                'delete' => $this->handleDelete($model, $data),
                default => throw new \Exception("Unknown action: {$action}"),
            };

            return [
                'success' => true,
                'type' => $type,
                'action' => $action,
                'local_id' => $localId,
                'server_id' => $result->id ?? null,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'type' => $type,
                'action' => $action,
                'local_id' => $localId,
                'error' => $e->getMessage(),
            ];
        }
    }

    protected function handleCreate(string $model, array $data)
    {
        unset($data['id'], $data['local_id'], $data['synced'], $data['localUpdatedAt']);
        return $model::create($data);
    }

    protected function handleUpdate(string $model, array $data)
    {
        $id = $data['id'] ?? null;
        if (!$id) {
            throw new \Exception('ID required for update');
        }

        unset($data['id'], $data['local_id'], $data['synced'], $data['localUpdatedAt']);

        $record = $model::findOrFail($id);
        $record->update($data);

        return $record;
    }

    protected function handleDelete(string $model, array $data)
    {
        $id = $data['id'] ?? null;
        if (!$id) {
            throw new \Exception('ID required for delete');
        }

        $record = $model::findOrFail($id);
        $record->delete();

        return $record;
    }

    /**
     * Get sync status
     */
    public function status(Request $request)
    {
        return response()->json([
            'online' => true,
            'server_time' => now()->toISOString(),
            'counts' => [
                'santri' => Santri::count(),
                'activities' => Activity::count(),
                'units' => Unit::count(),
            ],
        ]);
    }
}
