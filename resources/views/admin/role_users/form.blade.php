<?php
$user_name = $role_id = $status = '';
$sorting = 1;
if (isset($item)) {
    $user_name = $item->user_name;
    $role_id = $item->role_id;
    $status = $item->status;
} else {
    $user_name = old('user_name');
    $role_id = old('role_id');
    $status = old('status');
}
?>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="title" class="form-label">User Name</label>
            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Name" value="{{ $user_name }}" required>
        </div>

        <div class="mb-3">
            <label for="role_id" class="form-label">Select Role</label>
            <select name="role_id" id="role_id" class="form-select">
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