@extends('layouts.layout')

@section('content')
<pre><?php //echo var_dump($publichealthcentres) ?></pre>
<div class="content">
    <div class="title m-b-md">
        Public Health Centres
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Number of Health Workers</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Website</th>
                <th scope="col">Type</th>
                <th scope="col">Drive Through</th>
                <th scope="col">Appointment Type</th>
                <th scope="col" colspan=2>Actions</th>
            </tr>
        </thead>
        <form action="data/publichealthcentres" method="GET">
            <tr>
                <td scope="row"><input type="text" class="form-control form-control-sm" name="name" placeholder="Name" value="<?= $_GET["name"] ?? '' ?>" /></td>
                <td><input type="text" class="form-control form-control-sm" name="address" placeholder="Address" value="<?= $_GET["address"] ?? '' ?>" /></td>
                <td><input type="text" class="form-control form-control-sm" name="numberofhealthworkers" placeholder="Number of Health Workers" value="<?= $_GET["numberofhealthworkers"] ?? '' ?>" /></td>
                <td><input type="text" class="form-control form-control-sm" name="phonenumber" placeholder="Phone Number" value="<?= $_GET["phonenumber"] ?? '' ?>" /></td>
                <td><input type="text" class="form-control form-control-sm" name="website" placeholder="Website" value="<?= $_GET["website"] ?? '' ?>" /></td>
                <td>
                    <select class="form-control form-control-sm" name='type' value="<?= $_GET["type"] ?? '' ?>">
                        <option value=''>Select</option>
                        <option value='c'>Clinic</option>
                        <option value='h'>Hospital</option>
                        <option value='s'>Special</option>
                    </select>
                </td>
                <td>
                    <select class="form-control form-control-sm" name='drivethrough' value="<?= $_GET["drivethrough"] ?? '' ?>">
                        <option value=''>Select</option>
                        <option value='0'>No</option>
                        <option value='1'>Yes</option>
                    </select>
                </td>
                <td>
                    <select class="form-control form-control-sm" name='appointmenttype' value="<?= $_GET["appointmenttype"] ?? '' ?>">
                        <option value=''>Select</option>
                        <option value='0'>Appointment only</option>
                        <option value='1'>Walk-in</option>
                        <option value='2'>Appointment and walk-in</option>
                    </select>
                </td>
                <td colspan=2><button type="submit" class="btn btn-primary btn-sm w-100">Search</button></td>
            </tr>
        </form>
        <form action="data/publichealthcentres/new" method="POST">
        @csrf
            <tr>
                <td scope="row"><input type="text" class="form-control form-control-sm" name="name" placeholder="Name" /></td>
                <td><input type="text" class="form-control form-control-sm" name="address" placeholder="Address"/></td>
                <td></td>
                <td><input type="text" class="form-control form-control-sm" name="phonenumber" placeholder="Phone Number" /></td>
                <td><input type="text" class="form-control form-control-sm" name="website" placeholder="Website" /></td>
                <td>
                    <select class="form-control form-control-sm" name='type' value="<?= $_GET["type"] ?? '' ?>">
                        <option value='c'>Clinic</option>
                        <option value='h'>Hospital</option>
                        <option value='s'>Special</option>
                    </select>
                </td>
                <td>
                    <select class="form-control form-control-sm" name='drivethrough' value="<?= $_GET["drivethrough"] ?? '' ?>">
                        <option value='0'>No</option>
                        <option value='1'>Yes</option>
                    </select>
                </td>
                <td>
                    <select class="form-control form-control-sm" name='appointmenttype' value="<?= $_GET["appointmenttype"] ?? '' ?>">
                        <option value='0'>Appointment only</option>
                        <option value='1'>Walk-in</option>
                        <option value='2'>Appointment and walk-in</option>
                    </select>
                </td>
                <td colspan=2><button type="submit" class="btn btn-success btn-sm w-100">Add New</a></td>
            </tr>
        </form>
        <?php foreach($publichealthcentres as $publichealthcentre) : ?>
            <tr id="publichealthcentre_<?= $publichealthcentre->ID ?>">
                <td scope="row"><?= $publichealthcentre->Name ?></td>
                <td><?= $publichealthcentre->Address ?></td>
                <td><?= $publichealthcentre->NumberOfHealthWorkers ?? 0?></td>
                <td><?= $publichealthcentre->PhoneNumber ?></td>
                <td><?= $publichealthcentre->Website ?></td>
                @if ($publichealthcentre->Type == 'c')
                <td>Clinic</td>
                @endif
                @if ($publichealthcentre->Type == 'h')
                <td>Hospital</td>
                @endif
                @if ($publichealthcentre->Type == 's')
                <td>Special</td>
                @endif
                @if ($publichealthcentre->DriveThrough == '0')
                <td>No</td>
                @endif
                @if ($publichealthcentre->DriveThrough == '1')
                <td>Yes</td>
                @endif
                @if ($publichealthcentre->AppointmentType == '0')
                <td>Appointment only</td>
                @endif
                @if ($publichealthcentre->AppointmentType == '1')
                <td>Walk-in</td>
                @endif
                @if ($publichealthcentre->AppointmentType == '2')
                <td>Appointment and walk-in</td>
                @endif
                <td><button class="btn btn-warning btn-sm w-100" onclick="Edit(<?= $publichealthcentre->ID ?>)">Edit</button></td>
                <td>
                    <button id="delete_<?= $publichealthcentre->ID ?>" class="btn btn-danger btn-sm w-100" onClick="Delete(<?= $publichealthcentre->ID ?>)">Delete</button>
                    <a id="confirm_<?= $publichealthcentre->ID ?>" href="data/publichealthcentres/delete/<?= $publichealthcentre->ID ?>" class="btn btn-danger btn-sm w-100" style="display:none">Are you sure?</a>
                </td>
            </tr>
            <form action="data/publichealthcentres/edit" method="POST">
            @csrf
                <tr id="editing_<?= $publichealthcentre->ID ?>" style="display:none">
                    <td scope="row">
                        <input type="hidden" name="id" value="<?= $publichealthcentre->ID ?>" />
                        <input type="text" class="form-control form-control-sm" name="name" placeholder="Name" value="<?= $publichealthcentre->Name ?>" />
                    </td>
                    <td><input type="text" class="form-control form-control-sm" name="address" placeholder="Address" value="<?= $publichealthcentre->Address ?>" /></td>
                    <td></td>
                    <td><input type="text" class="form-control form-control-sm" name="phonenumber" placeholder="Phone Number" value="<?= $publichealthcentre->PhoneNumber ?>" /></td>
                    <td><input type="text" class="form-control form-control-sm" name="website" placeholder="Website" value="<?= $publichealthcentre->Website ?>" /></td>
                    <td>
                        <select class="form-control form-control-sm" name='type' value="<?= $_GET["type"] ?? '' ?>">
                            @if ($publichealthcentre->Type == 'c')
                            <option value='c' selected=selected>Clinic</option>
                            <option value='h'>Hospital</option>
                            <option value='s'>Special</option>
                            @endif
                            @if ($publichealthcentre->Type == 'h')
                            <option value='c'>Clinic</option>
                            <option value='h' selected=selected>Hospital</option>
                            <option value='s'>Special</option>
                            @endif
                            @if ($publichealthcentre->Type == 's')
                            <option value='c'>Clinic</option>
                            <option value='h'>Hospital</option>
                            <option value='s' selected=selected>Special</option>
                            @endif
                        </select>
                    </td>
                    <td>
                        <select class="form-control form-control-sm" name='drivethrough' value="<?= $_GET["drivethrough"] ?? '' ?>">
                            @if ($publichealthcentre->DriveThrough == 0)
                            <option value='0' selected=selected>No</option>
                            <option value='1'>Yes</option>
                            @endif
                            @if ($publichealthcentre->DriveThrough == 1)
                            <option value='0'>No</option>
                            <option value='1'selected=selected>Yes</option>
                            @endif
                        </select>
                    </td>
                    <td>
                        <select class="form-control form-control-sm" name='appointmenttype' value="<?= $_GET["appointmenttype"] ?? '' ?>">
                            @if ($publichealthcentre->AppointmentType == 0)
                            <option value='0' selected=selected>Appointment only</option>
                            <option value='1'>Walk-in</option>
                            <option value='2'>Appointment and walk-in</option>
                            @endif
                            @if ($publichealthcentre->AppointmentType == 1)
                            <option value='0'>Appointment only</option>
                            <option value='1'selected=selected>Walk-in</option>
                            <option value='2'>Appointment and walk-in</option>
                            @endif
                            @if ($publichealthcentre->AppointmentType == 2)
                            <option value='0'>Appointment only</option>
                            <option value='1'>Walk-in</option>
                            <option value='2' selected=selected>Appointment and walk-in</option> 
                            @endif   
                        </select>
                    </td>
                    <td><button type="button" class="btn btn-warning btn-sm w-100" onclick="Cancel(<?= $publichealthcentre->ID ?>)">Cancel</button></td>
                    <td><button type="submit" class="btn btn-success btn-sm w-100">Save</button></td>
                </tr>
            </form>
       
        <?php endforeach; ?>
    </table>
</div>

<script>
function Edit(id) {
    $('#editing_' + id).show();
    $('#publichealthcentre_' + id).hide();
}

function Cancel(id) {
    $('#editing_' + id).hide();
    $('#publichealthcentre_' + id).show();
}

function Delete(id) {
    $('#delete_' + id).hide();
    $('#confirm_' + id).show();
}
</script>
@endsection