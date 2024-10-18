<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    // search query
    public $search = '';

    // showing how many users per page you want to see
    public $perPage = 5;

    // filter by admin or not
    public $admin = '';

    // sort by name or email
    public $sortBy = 'created_at';

    // sort direction
    public $sortDirection = 'DESC';

    // sort users by asc or desc
    public function setSortBy($sortByField)
    {

        if ($this->sortBy === $sortByField) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'DESC' : 'asc';
            return;
        }
        $this->sortBy = $sortByField;
        $this->sortDirection = 'DESC';
    }


    // delete users
    public function delete(User $user)
    {
        $user->delete();
    }

    public function render()
    {
        return view('livewire.user-table', [

            // list all users, search users,
            // by email and name, and pagination
            // Filter users by admin or not
            'users' => User::search($this->search)
                ->when($this->admin !== '', function ($query) {
                    $query->where('is_admin', $this->admin);
                })
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->perPage),
        ]);
    }
}
