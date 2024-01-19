<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class ClientSellerProfile extends Component
{     use WithFileUploads;

    private $tabname = "personal_details";
    protected $queryString = ['tab'];

    // Properties are now protected
    public $tab = null;
    public $name;
    public $email;
    public $client_id;
    public $username;
    public $currentPassword;
    public $newPassword;
    public $confirmPassword;

    public function selectTab($selectedTab)
    {
        $this->tab = $selectedTab;
    }

    public function mount($id)
    {
        $this->tab = request()->tab ? request()->tab : $this->tabname;

        // Error handling for the case where an admin with the specified ID is not found
        try {
            $client = Client::find($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the exception as needed
            // For now, throw a 404
            abort(404);
        }

        $this->client_id = $client->id;
        $this->name = $client->name;
        $this->username = $client->username;
        $this->email = $client->email;
    }

    public function updateClientProfileDetails()
{
    $this->validate([
        'name' => 'required|min:5',
        'email' => 'required|email|unique:clients,email,' . $this->client_id,
        'username' => 'required|min:3|unique:clients,username,' . $this->client_id,
    ]);

    $this->dispatch('updateAdminSellerHeaderInfo');

    $this->dispatch('updateInfo', [
        'Name' => $this->name,
        'Email' => $this->email,
    ]);

    Client::find($this->client_id)
        ->update([
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
        ]);
}



public function updateClientPassword()
{
    $this->validate([
        'currentPassword' => [
            'required',
            function ($attribute, $value, $fail) {
                // Retrieve the hashed password from the database
                $client = Client::find($this->client_id);

                // Check if the provided current password matches the hashed password
                if (!Hash::check($value, $client->password)) {
                    $fail('The selected current password is invalid.');
                }
            },
        ],
        'newPassword' => 'required|min:8|different:currentPassword',
        'confirmPassword' => 'required|same:newPassword',
    ]);

    Client::find($this->client_id)
        ->update([
            'password' => Hash::make($this->newPassword),
        ]);

    $this->dispatch('updatePassword', [
        'success' => 'Password Updated',
    ]);
}

    public function render()
    {
        return view('livewire.client-profile-tabs');
    }
}
