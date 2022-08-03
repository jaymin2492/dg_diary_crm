<?php
$notes = $status = '';
$sorting = 1;
if (isset($item)) {
    $notes = $item->notes;
} else {
    $notes = old('notes');
}
?>
<div class="row">
    <div class="col-md-6">
        
        <div class="mb-3">
            <label for="notes" class="form-label">Notes*</label>
            <small style="display: block;"><?php echo Auth::user()->name;?> - <?php echo date("d/m/Y");?></small>
            <input type="hidden" name="note_by_at" id="note_by_at" class="form-control" value="<?php echo Auth::user()->name;?> - <?php echo date("d/m/Y");?>" required>
            <input type="text" name="notes" id="notes" class="form-control" placeholder="Notes*" value="{{ $notes }}" required>
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