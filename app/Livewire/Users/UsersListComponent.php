<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersListComponent extends Component
{
    use WithPagination;

    public $users;
    public $search = '';
    public $is_active;
    public $deleteUserId;
    public $deleteUserName;
    public $showDeleteModal = false;

    protected $queryString = ['search', 'perPage'];    

    public function render()
    {
        return view('livewire.users.users-list-component');
    }

    public function mount()
    {
        $this->users = User::orderBy('created_at', 'desc')->get();
    }

    public function updatedSearch()
    {
        $this->users = User::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function updatedIsActive()
    {
        $query = User::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->is_active !== null && $this->is_active !== '' && $this->is_active !== 'all') {
            $query->where('is_active', $this->is_active);
        }

        $this->users = $query->orderBy('created_at', 'desc')->get();
    }

    public function searchUser()
    {
        $query = User::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->is_active !== null && $this->is_active !== '' && $this->is_active !== 'all') {
            $query->where('is_active', $this->is_active);
        }

        $this->users = $query->orderBy('created_at', 'desc')->get();
    }

    public function confirmDelete($userId, $userName)
    {
        $this->deleteUserId = $userId;
        $this->deleteUserName = $userName;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->deleteUserId = null;
        $this->deleteUserName = null;
        $this->showDeleteModal = false;
    }

    public function deleteUser()
    {
        try {
            $user = User::find($this->deleteUserId);
            
            if (!$user) {
                session()->flash('error', 'User not found.');
                $this->showDeleteModal = false;
                return;
            }
            
            // Check if user is super_admin - prevent deletion
            if ($user->role === 'super_admin') {
                session()->flash('error', 'Super Admin users cannot be deleted.');
                $this->showDeleteModal = false;
                return;
            }
            
            // Delete user
            $user->delete();
            
            session()->flash('success', 'User deleted successfully.');
            
            // Refresh users list
            $this->users = $this->users->filter(function($item) {
                return $item->id != $this->deleteUserId;
            });
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting user: ' . $e->getMessage());
        }
        
        $this->showDeleteModal = false;
    }
}