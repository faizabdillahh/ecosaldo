<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRewardRequest;
use App\Http\Requests\UpdateRewardRequest;
use App\Models\Reward;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RewardController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(): View
    {
        return view('reward.index', [
            'rewards' => Reward::orderBy('nama')->get(),
        ]);
    }

    public function create(): View
    {
        return view('reward.create');
    }

    public function store(StoreRewardRequest $request): RedirectResponse
    {
        Reward::create($request->validated());

        return redirect()
            ->route('reward.index')
            ->with('success', 'Reward berhasil ditambahkan.');
    }

    public function edit(Reward $reward): View
    {
        return view('reward.edit', compact('reward'));
    }

    public function update(UpdateRewardRequest $request, Reward $reward): RedirectResponse
    {
        $reward->update($request->validated());

        return redirect()
            ->route('reward.index')
            ->with('success', 'Reward berhasil diperbarui.');
    }

    public function destroy(Reward $reward): RedirectResponse
    {
        $reward->delete();

        return redirect()
            ->route('reward.index')
            ->with('success', 'Reward berhasil dihapus.');
    }
}