<?php

namespace Modules\Test\Http\Controllers;

use App\Http\Controllers\Controller;
use Emargareten\InertiaModal\Modal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TestController extends Controller
{
    /**
     * Get sample test data
     */
    private function getSampleData()
    {
        return [
            [
                'id' => 1,
                'name' => 'Test Item 1',
                'description' => 'This is the first test item',
                'status' => 'active',
                'created_at' => now()->subDays(2)->format('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'name' => 'Test Item 2',
                'description' => 'This is the second test item',
                'status' => 'inactive',
                'created_at' => now()->subDays(5)->format('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'name' => 'Test Item 3',
                'description' => 'This is the third test item',
                'status' => 'active',
                'created_at' => now()->subDays(10)->format('Y-m-d H:i:s')
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Test::index', [
            'tests' => $this->getSampleData()
        ]);
    }

    /**
     * Show the form for creating a new resource (modal).
     */
    public function create(): Modal
    {
        return Inertia::modal('Test::create')
            ->baseRoute('test.index');
    }

    /**
     * Show the form for editing the specified resource (modal).
     */
    public function edit($id): Modal
    {
        $test = [
            'id' => $id,
            'name' => 'Test Item ' . $id,
            'description' => 'This is test item number ' . $id,
            'status' => 'active',
            'created_at' => now()->format('Y-m-d H:i:s')
        ];

        return Inertia::modal('Test::edit', [
            'item' => $test
        ])->baseRoute('test.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TODO: Implement store logic
        return redirect()->route('test.index')
            ->with('success', 'Test item created successfully!');
    }

    /**
     * Show the specified resource (modal).
     */
    public function show($id): Modal
    {
        $test = [
            'id' => $id,
            'name' => 'Test Item ' . $id,
            'description' => 'This is test item number ' . $id,
            'status' => 'active',
            'created_at' => now()->format('Y-m-d H:i:s')
        ];

        return Inertia::modal('Test::show', [
            'item' => $test
        ])->baseRoute('test.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // TODO: Implement update logic
        return redirect()->route('test.index')
            ->with('success', 'Test item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // TODO: Implement destroy logic
        return redirect()->route('test.index')
            ->with('success', 'Test item deleted successfully!');
    }

    /**
     * Bulk destroy multiple resources.
     */
    public function bulkDestroy(Request $request)
    {
        // TODO: Implement bulk destroy logic
        return redirect()->route('test.index')
            ->with('success', 'Test items deleted successfully!');
    }
}
