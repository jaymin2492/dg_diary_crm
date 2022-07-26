<?php
$notes = $folow_up_date = $status_id = $manager_status_id = $closure_month = $status = '';
$sorting = 1;
if (isset($item)) {
    $notes = $item->notes;
    $folow_up_date = $item->folow_up_date;
    $status_id = $item->status_id;
    $manager_status_id = $item->manager_status_id;
    $closure_month = $item->closure_month;
} else {
    $notes = old('notes');
    $folow_up_date = old('folow_up_date');
    $status_id = old('status_id');
    $manager_status_id = old('manager_status_id');
    $closure_month = old('closure_month');
}
?>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="notes" class="form-label">Notes*</label>
            <input type="text" name="notes" id="notes" class="form-control" placeholder="Notes*" value="{{ $notes }}" required>
        </div>
        <div class="mb-3">
            <label for="folow_up_date" class="form-label">Follow-up Date*</label>
            <input type="text" name="folow_up_date" id="folow_up_date" class="form-control" placeholder="Follow-up Date*" value="{{ $folow_up_date }}" required>
        </div>
        <div class="mb-3">
            <label for="status_id" class="form-label">Current Status*</label>
            <select class="form-select" name="status_id" id="status_id" required>
<!--                 <option value="">Please Select</option>
 -->                @foreach($fieldItems['statuses'] as $key => $value)
                <option value="{{ $key }}" @if($status_id==$key ) selected="selected" @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="manager_status_id" class="form-label">Current Status By Manager*</label>
            <select class="form-select" name="manager_status_id" id="manager_status_id" required>
<!--                 <option value="">Please Select</option>
 -->                @foreach($fieldItems['statuses'] as $key => $value)
                <option value="{{ $key }}" @if($manager_status_id==$key ) selected="selected" @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <?php $months = array("January","February","March","April","May","June","July","August","September","October","November","December");?>
        <div class="mb-3">
            <label for="closure_month" class="form-label">Closure Month*</label>
            <select class="form-select" name="closure_month" id="closure_month" required>
                <option value="">Please Select</option>
                @foreach($months as $value)
                <option value="{{ $value }}" @if($closure_month==$value ) selected="selected" @endif>{{ $value }}</option>
                @endforeach
            </select>
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
        jQuery("#folow_up_date").flatpickr();
    })
</script>