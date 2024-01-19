<?php

// app/Livewire/AdminProfileTabs.php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Admin;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminProfileTabs extends Component
{
    use WithFileUploads;

    private $tabname = "personal_details";
    protected $queryString = ['tab'];

    // Properties are now protected
    public $tab = null;
    public $name;
    public $email;
    public $admin_id;
    public $username;
    public $currentPassword;
    public $newPassword;
    public $confirmPassword;

    public function selectTab($selectedTab)
    {
        $this->tab = $selectedTab;
    }

    public function mount()
    {
        $this->tab = request()->tab ? request()->tab : $this->tabname;

        // Error handling for the case where an admin with the specified ID is not found
        try {
            $admin = Admin::findOrFail(auth()->id());
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the exception as needed
            // For now, throw a 404
            abort(404);
        }

        $this->admin_id = $admin->id;
        $this->name = $admin->name;
        $this->username = $admin->username;
        $this->email = $admin->email;
    }

    public function updateAdminProfileDetails()
    {
        $this->validate([
            'name' => 'required|min:5',
            'email' => 'required|email|unique:admins,email,' . $this->admin_id,
            'username' => 'required|min:3|unique:admins,username,' . $this->admin_id,
        ]);

        $this->dispatch('updateAdminSellerHeaderInfo');

        $this->dispatch('updateAdminInfo', [
            'adminName' => $this->name,
            'adminEmail' => $this->email,
        ]);
       // $this->dispatch('alert', ['type' => 'success', 'message' => 'User Created Successfully!',]);

        Admin::find($this->admin_id)
            ->update([
                'name' => $this->name,
                'email' => $this->email,
                'username' => $this->username,
            ]);

        $this->showToastr('success', 'Your personal details have been updated');
    }

    // The method is now protected
    public function showToastr($type, $message)
    {
        $this->dispatch('showToastr', [
            'type' => $type,
            'message' => $message,
        ]);
    }


    public function updateAdminPassword()
    {
        $this->validate([
            'currentPassword' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Retrieve the hashed password from the database
                    $admin = Admin::find($this->admin_id);

                    // Check if the provided current password matches the hashed password
                    if (!Hash::check($value, $admin->password)) {
                        $fail('The selected current password is invalid.');
                    }
                },
            ],
            'newPassword' => 'required|min:8|different:currentPassword',
            'confirmPassword' => 'required|same:newPassword',
        ]);

        Admin::find($this->admin_id)
            ->update([
                'password' => Hash::make($this->newPassword),
            ]);

        $this->dispatch('updatePassword', [
            'success' => 'Password Updated',
        ]);
    }



    public function render()
    {
        return view('livewire.admin-profile-tabs');
    }
}
