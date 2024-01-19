<div>

    <div class="profile-tab height-100-p">
        <div class="tab height-100-p">
            <ul class="nav nav-tabs customtab"role="tablist">
                <li class="nav-item">
                    <a wire:click.prevent='selectTab("personal_details")' class="nav-link {{ $tab == 'personal_details'?'active':''}}" href="#personal_details" data-toggle="tab" class="nav-link" role="tab">Personal Details</a>
                </li>
                <li class="nav-item">
                    <a wire:click.prevent='selectTab("update_password")' class="nav-link {{ $tab == 'update_password'?'active':''}}" href="#update_password" data-toggle="tab" class="nav-link" role="tab">Update Password</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade {{ $tab == 'personal_details'?'active show':''}}" id="personal_details" role="tabpanel">
                    <div class="pd-20">
                        <form wire:submit.prevent='updateSellerProfileDetails'>
                            <div class="row px-4 ">
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="" >Name</label>
                                        <input type="text" name="" wire:model="name" placeholder="Enter User Name"  class="form-control">
                                        @error('name')
                                            <spam class="text-danger">{{ $message }}</spam>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="" >Email</label>
                                        <input type="email" name="" wire:model="email" placeholder="Enter User email"  class="form-control">
                                        @error('email')
                                            <spam class="text-danger">{{ $message }}</spam>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="" >Username</label>
                                        <input type="text" name="" wire:model="username" placeholder="Enter User Name" class="form-control">
                                        @error('username')
                                            <spam class="text-danger">{{ $message }}</spam>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade {{ $tab == 'update_password'?'active show':''}} " id="update_password" role="tabpanel">
                    <div class="pd-20 profile-task-warp">
                        <form wire:submit.prevent='updateSellerPassword'>
                            <div class="row px-4 ">
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="" >Current Password</label>
                                        <input type="text" name="" wire:model="currentPassword" autocomplete="off" placeholder="Enter User Current Password" id="password" class="form-control">
                                        @error('currentPassword')
                                            <spam class="text-danger">{{ $message }}</spam>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="" >New Password</label>
                                        <input type="password" name="" wire:model="newPassword" autocomplete="off" placeholder="Enter User New Password" id="newpassword" class="form-control">
                                        @error('newPassword')
                                            <spam class="text-danger">{{ $message }}</spam>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="" >New Password</label>
                                        <input type="password" name="" wire:model="confirmPassword" autocomplete="off" placeholder="Enter User New Password" id="confirmpassword" class="form-control">
                                        @error('confirmPassword')
                                            <spam class="text-danger">{{ $message }}</spam>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
