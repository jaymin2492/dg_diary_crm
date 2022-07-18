<?php
$title = $description = $status = '';
$sorting = 1;
if (isset($item)) {
    $title = $item->title;
    $description = $item->description;
    $status = $item->status;
} else {
    $title = old('title');
    $description = old('description');
    $status = old('status');
}
?>
<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{ $title }}" required>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" id="description" class="form-control" placeholder="Description" required>{{ $description }}</textarea>
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