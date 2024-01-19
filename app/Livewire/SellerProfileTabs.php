<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Seller;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class SellerProfileTabs extends Component
{
    use WithFileUploads;

    private $tabname = "personal_details";
    protected $queryString = ['tab'];

    // Properties are now protected
    public $tab = null;
    public $name;
    public $email;    public $seller_id;
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
            $seller = Seller::findOrFail(auth()->id());
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the exception as needed
            // For now, throw a 404
            abort(404);
        }

        $this->seller_id= $seller->id;
        $this->name = $seller->name;
        $this->username = $seller->username;
        $this->email = $seller->email;
    }

    public function updateSellerProfileDetails()
{
    $this->validate([
        'name' => 'required|min:5',
        'email' => 'required|email|unique:sellers,email,' . $this->seller_id,
        'username' => 'required|min:3|unique:sellers,username,' . $this->seller_id,
    ]);

    $this->dispatch('updateAdminSellerHeaderInfo');

    $this->dispatch('updateInfo', [
        'Name' => $this->name,
        'Email' => $this->email,
    ]);

    Seller::find($this->seller_id)
        ->update([
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
        ]);
}



public function updateSellerPassword()
{
    $this->validate([
        'currentPassword' => [
            'required',
            function ($attribute, $value, $fail) {
                // Retrieve the hashed password from the database
                $seller = Seller::find($this->seller_id);

                // Check if the provided current password matches the hashed password
                if (!Hash::check($value, $seller->password)) {
                    $fail('The selected current password is invalid.');
                }
            },
        ],
        'newPassword' => 'required|min:8|different:currentPassword',
        'confirmPassword' => 'required|same:newPassword',
    ]);

    Seller::find($this->seller_id)
        ->update([
            'password' => Hash::make($this->newPassword),
        ]);

    $this->dispatch('updatePassword', [
        'success' => 'Password Updated',
    ]);
}

    public function render()
    {
        return view('livewire.seller-profile-tabs');
    }
}
