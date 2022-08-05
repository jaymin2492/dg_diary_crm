<?php
$user_name = $role_id = $status = $email = $password = '';
$sorting = 1;
if (isset($item)) {
    $user_name = $item->name;
    $role_id = $item->role->role_id;
    $status = $item->status;
    $email = $item->email;
    $password = $item->password;
} else {
    $user_name = old('user_name');
    $role_id = old('role_id');
    $status = old('status');
    $email = old('email');
    $password = old('password');
}
?>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="title" class="form-label">Name*</label>
            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Name*" value="{{ $user_name }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email*</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email*" value="{{ $email }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password*</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Password*" value="">
        </div>

        <div class="mb-3">
            <label for="role_id" class="form-label">Select Role*</label>
            <select name="role_id" id="role_id" class="form-select" required>
                <option value="">Please Select</option>
                @foreach($roles as $role)
                    <option value="{{ $role['id'] }}" @if($role_id == $role['id']) selected  @endif>{{ $role['title'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<!-- <div class="mb-3">
    <label for="cstatus" class="form-label">Status</label>
    <select class="form-select" name="status" id="cstatus" required>
        <option value="">Please Select</option>
        <option value="Active" @if($status == 'Active') selected="selected" @endif>Active</option>
        <option value="Inactive" @if($status == 'Inactive') selected="selected" @endif>Inactive</option>
    </select>
</div> -->
<button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#create_form,#edit_form").validate();
    })
</script>