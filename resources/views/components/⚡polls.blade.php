<?php

use Livewire\Component;
use App\Models\Poll;
use Livewire\Attributes\On;

new class extends Component
{
    public $polls = [];

    #[On('pollCreated')]

    public function mount()
    {
        $this->polls = Poll::with('options.votes')
            ->latest()
            ->get();
    }

public function vote($optionId){
$option = App\Models\Option::findOrfail($optionId);
$option->votes()->create();
}

};
?>

<div>
    @forelse ($polls as $poll)
        <div class="mb-4">
            <h3 class="mb-4 text-xl">
                {{ $poll->title }}
            </h3>

            @foreach ($poll->options as $option)
                <div class="mb-2">
                    <button class="btn" wire:click = "vote({{$option->id}})">Vote</button>
                    {{ $option->name }}
                    ({{ $option->votes->count() }})
                </div>
            @endforeach
        </div>
    @empty
        <div class="text-gray-500">No Polls Available</div>
    @endforelse
</div>
