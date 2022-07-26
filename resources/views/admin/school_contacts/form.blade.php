<?php
$name = $department = $title = $email = $phone = $status = '';
$sorting = 1;
if (isset($item)) {
    $name = $item->name;
    $department = $item->department;
    $title = $item->title;
    $email = $item->email;
    $phone = $item->phone;
} else {
    $name = old('name');
    $department = old('department');
    $title = old('title');
    $email = old('email');
    $phone = old('phone');
}
?>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">Name*</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Name*" value="{{ $name }}" required>
        </div>
        <div class="mb-3">
            <label for="department" class="form-label">Department*</label>
            <input type="text" name="department" id="department" class="form-control" placeholder="Department*" value="{{ $department }}" required>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Title*</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Title*" value="{{ $title }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email*</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email*" value="{{ $email }}" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone*</label>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone*" value="{{ $phone }}" required>
        </div>
        <input type="hidden" name="school_id" value="{{ $sid }}">
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