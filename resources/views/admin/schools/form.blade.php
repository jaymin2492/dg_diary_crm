<?php
$title = $school_type_id = $school_level_id = $country_id = $population = $system = $online_student_portal = $name_of_the_system = $contract_till = $school_tution = $telemarketing_rep_id = $director_id = $onboarding_rep_id = $onboarding_manager_id = $status = $area_id = $sales_rep_id = $sales_manager_id = '';
$sorting = 1;
if (isset($item)) {
    $title = $item->title;
    $area_id = $item->area_id;
    $school_type_id = $item->school_type_id;
    $school_level_id = $item->school_level_id;
    $country_id = $item->country_id;
    $population = $item->population;
    $system = $item->system;
    $online_student_portal = $item->online_student_portal;
    $name_of_the_system = $item->name_of_the_system;
    $contract_till = $item->contract_till;
    $school_tution = $item->school_tution;
    $sales_rep_id = $item->sales_rep_id;
    $sales_manager_id = $item->sales_manager_id;
    $telemarketing_rep_id = $item->telemarketing_rep_id;
    $director_id = $item->director_id;
    $onboarding_rep_id = $item->onboarding_rep_id;
    $onboarding_manager_id = $item->onboarding_manager_id;
    $status = $item->status;
} else {
    $title = old('title');
    $area_id = old('area_id');
    $school_type_id = old('school_type_id');
    $school_level_id = old('school_level_id');
    $country_id = old('country_id');
    $population = old('population');
    $system = old('system');
    $online_student_portal = old('online_student_portal');
    $name_of_the_system = old('name_of_the_system');
    $contract_till = old('contract_till');
    $school_tution = old('school_tution');
    $sales_rep_id = old('sales_rep_id');
    $sales_manager_id = old('sales_manager_id');
    $telemarketing_rep_id = old('telemarketing_rep_id');
    $director_id = old('director_id');
    $onboarding_rep_id = old('onboarding_rep_id');
    $onboarding_manager_id = old('onboarding_manager_id');
    $status = old('status');
}
?>
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="title" class="form-label">Title*</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Name*" value="{{ $title }}" required>
        </div>

        <div class="mb-3">
            <label for="school_type_id" class="form-label">School Type</label>
            <select class="form-select" name="school_type_id" id="school_type_id" required>
                <option value="">Please Select</option>
                @foreach($fieldItems['schoolTypes'] as $key => $value)
                <option value="{{ $key }}" @if($school_type_id==$key ) selected="selected" @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="school_level_id" class="form-label">School Level</label>
            <select class="form-select" name="school_level_id" id="school_level_id" required>
                <option value="">Please Select</option>
                @foreach($fieldItems['schoolLevels'] as $key => $value)
                <option value="{{ $key }}" @if($school_level_id==$key ) selected="selected" @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="country_id" class="form-label">Country</label>
            <select class="form-select" name="country_id" id="country_id" required>
                <option value="">Please Select</option>
                @foreach($fieldItems['countries'] as $key => $value)
                <option value="{{ $key }}" @if($country_id==$key ) selected="selected" @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="area_id" class="form-label">Area</label>
            <select class="form-select" name="area_id" id="area_id" required>
                <option value="">Please Select</option>
                @foreach($fieldItems['areas'] as $key => $value)
                <option value="{{ $key }}" @if($country_id==$key ) selected="selected" @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="population" class="form-label">Population*</label>
            <input type="number" name="population" id="population" class="form-control" placeholder="Population*" value="{{ $population }}" required>
        </div>

        <div class="mb-3">
            <label for="system" class="form-label">System*</label>
            <select class="form-select" name="system" id="system" required>
                <option value="">Please Select</option>
                <option value="Yes" @if($system=='Yes' ) selected="selected" @endif>Yes</option>
                <option value="No" @if($system=='No' ) selected="selected" @endif>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="online_student_portal" class="form-label">Online Student Portal*</label>
            <select class="form-select" name="online_student_portal" id="online_student_portal" required>
                <option value="">Please Select</option>
                <option value="Yes" @if($online_student_portal=='Yes' ) selected="selected" @endif>Yes</option>
                <option value="No" @if($online_student_portal=='No' ) selected="selected" @endif>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Name of the system*</label>
            <input type="text" name="name_of_the_system" id="name_of_the_system" class="form-control" placeholder="Name of the system*" value="{{ $name_of_the_system }}" required>
        </div>



    </div>

    <div class="col-md-6">
        
        <div class="mb-3">
            <label for="title" class="form-label">Contract Till*</label>
            <input type="text" name="contract_till" id="contract_till" class="form-control" placeholder="Contract Till*" value="{{ $contract_till }}" required>
        </div>
        <div class="mb-3">
            <label for="sales_rep_id" class="form-label">TeleMarketing Rep</label>
            <select class="form-select" name="sales_rep_id" id="sales_rep_id" required>
                <option value="">Please Select</option>
                @foreach($fieldItems['salesReps'] as $key => $value)
                    <option value="{{ $key }}" @if($sales_rep_id==$key ) selected="selected" @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="sales_manager_id" class="form-label">Sales Manager</label>
            <select class="form-select" name="sales_manager_id" id="sales_manager_id" required>
                <option value="">Please Select</option>
                @foreach($fieldItems['salesManagers'] as $key => $value)
                <option value="{{ $key }}" @if($sales_manager_id==$key ) selected="selected" @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="telemarketing_rep_id" class="form-label">TeleMarketing Rep</label>
            <select class="form-select" name="telemarketing_rep_id" id="telemarketing_rep_id" required>
                <option value="">Please Select</option>
                @foreach($fieldItems['teleMarketingReps'] as $key => $value)
                <option value="{{ $key }}" @if($telemarketing_rep_id==$key ) selected="selected" @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="director_id" class="form-label">Director</label>
            <select class="form-select" name="director_id" id="director_id" required>
                <option value="">Please Select</option>
                @foreach($fieldItems['directors'] as $key => $value)
                <option value="{{ $key }}" @if($director_id==$key ) selected="selected" @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="onboarding_rep_id" class="form-label">Onboarding Rep</label>
            <select class="form-select" name="onboarding_rep_id" id="onboarding_rep_id" required>
                <option value="">Please Select</option>
                @foreach($fieldItems['onboardingReps'] as $key => $value)
                <option value="{{ $key }}" @if($onboarding_rep_id==$key ) selected="selected" @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="onboarding_manager_id" class="form-label">Onboarding Manager</label>
            <select class="form-select" name="onboarding_manager_id" id="onboarding_manager_id" required>
                <option value="">Please Select</option>
                @foreach($fieldItems['onboardingManagers'] as $key => $value)
                <option value="{{ $key }}" @if($onboarding_manager_id==$key ) selected="selected" @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="school_tution" class="form-label">School Tution*</label>
            <select class="form-select" name="school_tution" id="school_tution" required>
                <option value="">Please Select</option>
                <option value="Free" @if($school_tution=='Free' ) selected="selected" @endif>Free</option>
                <option value="Paid" @if($school_tution=='Paid' ) selected="selected" @endif>Paid</option>
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