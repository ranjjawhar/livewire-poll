<?php

use Livewire\Component;
use App\Models\Poll;
new class extends Component
{
    public $title;
    public $options = ['First'];

    protected $rules = [
    'title' => 'required|min:3|max:255',
    'options' => 'required|array|min:1|max:10',
    'options.*' => 'required|min:1|max:255'
    ];


    protected $messages = ['options.*' => "The options can't be empty."];

public function addOption(){
    $this->options[] = '';
}

public function removeOption($index){
    unset($this->options[$index]);
    $this->options = array_values($this->options);
}

public function updated($propertyName){
$this->validateOnly($propertyName);
}

public function createPoll(){
    $this->validate();
$poll = Poll::create([
    'title' => $this->title
]);

foreach ($this->options as $optionName) {
$poll->options()->create(['name' => $optionName]);
}
$this->reset(['title','options']);
}

};
?>

<div>
   <form wire:submit.prevent='createPoll'>
    <label>Poll Title</label>
    <input type="text" wire:model.live="title" />
    @error('title')
<div class="text-red-500">{{$message}}</div>
    @enderror

<div class="mt-4 mb-4" >
    <button class="btn" wire:click.prevent="addOption">Add Option</button>
</div>
    <div>
        @foreach ($options as $index => $option )
        <div class="mb-4">
          <label>Option {{$index + 1}}</label>
          <div class="flex gap-2">
            <input type="text" wire:model="options.{{$index}}"/>
            <button class="btn" wire:click.prevent="removeOption({{$index}})">Remove</button>
          </div>
           @error("options.{$index}")
<div class="text-red-500">{{$message}}</div>
    @enderror
        </div>
        @endforeach

    </div>
    <button type="submit" class="btn" >Create Poll</button>
   </form>
</div>
