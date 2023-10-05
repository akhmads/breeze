<?php

namespace App\Livewire\Post;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use App\Models\Post;

class PostTable extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $sortColumn = "created_at";
    public $sortOrder = "desc";
    public $sortLink = '';
    public $searchKeyword = '';
    public $set_id;

    public function render()
    {
        $post = Post::orderby($this->sortColumn,$this->sortOrder)->select('*');
        if(!empty($this->searchKeyword)){
            $post->orWhere('title','like',"%".$this->searchKeyword."%");
            $post->orWhere('content','like',"%".$this->searchKeyword."%");
        }
        $posts = $post->paginate($this->perPage);

        return view('livewire.post.post-table',['posts' => $posts]);
    }

    public function delete($id)
    {

        Post::destroy($id);
        session()->flash('success', __('User deleted.'));
        return redirect()->to('/post');
    }
}
