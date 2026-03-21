<?php

namespace App\Http\Controllers;

use App\Filters\PersonFilter,
    App\Http\Requests\PersonIndexRequest,
    App\Http\Requests\StorePersonRequest,
    App\Http\Requests\UpdatePersonRequest,
    App\Models\Person,
    Inertia\Inertia;

class PersonController extends Controller
{
    public function index(PersonIndexRequest $request, PersonFilter $personFilter)
    {
        $filters = $request->validated('filters', []);

        $people = $personFilter
            ->apply(Person::query(), $filters)
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('People/Index', [
            'people' => $people,
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('People/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonRequest $request)
    {
        Person::create($request->validated());

        return redirect()
            ->route('people.index')
            ->with('success', 'Pessoa cadastrada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        return Inertia::render('People/Show', [
            'person' => $person,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Person $person)
    {
        return Inertia::render('People/Edit', [
            'person' => $person,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonRequest $request, Person $person)
    {
        $person->update($request->validated());

        return redirect()
            ->route('people.index')
            ->with('success', 'Pessoa atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        $person->delete();

        return redirect()
            ->route('people.index')
            ->with('success', 'Pessoa excluída com sucesso.');
    }
}
