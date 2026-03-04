<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreideaRequest;
use App\Http\Requests\UpdateideaRequest;
use App\IdeaStatus;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class IdeaController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Idea::class);

        $statusFilter = $request->string('status')->toString();
        $validStatusFilter = IdeaStatus::tryFrom($statusFilter);

        $totalIdeasCount = $request->user()->ideas()->count();
        $ideasQuery = $request->user()->ideas()->latest();

        if ($validStatusFilter !== null) {
            $ideasQuery->where('status', $validStatusFilter->value);
        }

        $ideas = $ideasQuery->paginate(9)->withQueryString();

        $statusCounts = $request->user()
            ->ideas()
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        return view('ideas.index', [
            'ideas' => $ideas,
            'statuses' => IdeaStatus::cases(),
            'statusFilter' => $validStatusFilter?->value,
            'statusCounts' => $statusCounts,
            'totalIdeasCount' => $totalIdeasCount,
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', Idea::class);

        return view('ideas.create', [
            'statuses' => IdeaStatus::cases(),
        ]);
    }

    public function store(StoreideaRequest $request): RedirectResponse
    {
        $this->authorize('create', Idea::class);

        $validated = $request->validated();
        $links = collect($validated['links'] ?? [])->filter(fn (?string $link): bool => filled($link))->values()->all();

        $idea = $request->user()->ideas()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'links' => $links,
            'image_path' => $request->file('image')?->store('ideas', 'public'),
        ]);

        return redirect()->route('ideas.show', $idea)->with('success', 'Idea created successfully.');
    }

    public function show(Idea $idea): View
    {
        $this->authorize('view', $idea);

        return view('ideas.show', [
            'idea' => $idea,
        ]);
    }

    public function edit(Idea $idea): View
    {
        $this->authorize('update', $idea);

        return view('ideas.edit', [
            'idea' => $idea,
            'statuses' => IdeaStatus::cases(),
        ]);
    }

    public function update(UpdateideaRequest $request, Idea $idea): RedirectResponse
    {
        $this->authorize('update', $idea);

        $validated = $request->validated();
        $links = collect($validated['links'] ?? [])->filter(fn (?string $link): bool => filled($link))->values()->all();
        $imagePath = $idea->image_path;

        if ($request->hasFile('image')) {
            if ($idea->image_path !== null) {
                Storage::disk('public')->delete($idea->image_path);
            }

            $imagePath = $request->file('image')->store('ideas', 'public');
        } elseif ($request->boolean('remove_image') && $idea->image_path !== null) {
            Storage::disk('public')->delete($idea->image_path);
            $imagePath = null;
        }

        $idea->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'links' => $links,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('ideas.show', $idea)->with('success', 'Idea updated successfully.');
    }

    public function destroy(Idea $idea): RedirectResponse
    {
        $this->authorize('delete', $idea);

        if ($idea->image_path !== null) {
            Storage::disk('public')->delete($idea->image_path);
        }

        $idea->delete();

        return redirect()->route('ideas.index')->with('success', 'Idea deleted successfully.');
    }
}
