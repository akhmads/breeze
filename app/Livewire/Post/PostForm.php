<?php

namespace App\Livewire\Post;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Illuminate\Http\Request;
use App\Models\Post;

class PostForm extends Component
{
    public $set_id;

    #[Rule('required|min:3')]
    public $title = '';

    #[Rule('required|min:3')]
    public $content = '';

    #[Rule('required')]
    public $type = '';

    public function render()
    {
        return view('livewire.post.post-form');
    }

    public function mount(Request $request)
    {
        $post = Post::Find($request->id);
        $this->set_id = $post->id ?? '';
        $this->title = $post->title ?? '';
        $this->type = $post->type ?? '';
        $this->content = $post->content ?? '';
    }

    public function store()
    {
        if(empty($this->set_id))
        {
            $valid = $this->validate([
                'title' => 'required|max:255',
                //'type' => 'required',
                'content' => 'required',
            ]);
            Post::create($valid);
        }
        else
        {
            $valid = $this->validate([
                'title' => 'required|max:255',
                //'type' => 'required',
                'content' => 'required',
            ]);
            $code = Post::find($this->set_id);
            $code->update($valid);
        }

        session()->flash('success', __('Post saved'));
    }
}
