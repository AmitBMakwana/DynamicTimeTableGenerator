@extends("layouts.visitor")

@section("title")
Dynamic Time Table
@endsection

@section("style")
<style>
</style>
<link href="{{ asset('bootstrap/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('bootstrap/css/select2-bootstrap4.min.css') }}" rel="stylesheet" />
<script src="{{ asset('bootstrap/js/select2.full.min.js') }}"></script>
@endsection

@section("content")
<br/>
<div class="row stdcrudtitle">
    <div class="col-lg-6 col-md-6">
        <h4 class="stdtextcolor">
            <span class="fa fa-receipt"></span>
            Dynamic Time Table
        </h4>
    </div>
</div>
<div class="d-block d-md-none"><br /></div>
<small class="text-danger">
    * Denotes compulsory fields
</small>
@if($errors->any())
<br />
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(session()->has("result"))
<div class="alert {{ session()->get("result")['status'] == "1" ? "alert-success" : "alert-danger" }}  alert-dismissible fade show" style="margin-top: 10px;">
    <div>{!! session()->get("result")['message'] !!}</div>
    <button class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif

<form action="{{ route('dynamictimetable.store') }}" method="POST" id="frmdynamictimetable">
    
    @csrf
    
    <div class="row">
        
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <label> No. Of Working Days <span class="text-danger">*</span></label>
            <input type="text" name="bi_nNoOfDays" required id="bi_nNoOfDays" maxlength="1" pattern="[0-9]{1,7}" value="{{ old('bi_nNoOfDays') }}" placeholder="No. Of Working Days" class="stdtextbox form-control">
            @error("bi_nNoOfDays")
            <div class="text-right"><small class="text-danger">{{ $message }}</small></div>
            @enderror
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <label> No. Of Subject Per Days <span class="text-danger">*</span></label>
            <input type="text" name="bi_nNoOfSubject" required id="bi_nNoOfSubject" maxlength="1" pattern="[0-9]{1,8}" value="{{ old('bi_nNoOfSubject') }}" placeholder="No. Of Subject Per Days" class="stdtextbox form-control">
            @error("bi_nNoOfSubject")
            <div class="text-right"><small class="text-danger">{{ $message }}</small></div>
            @enderror
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <label> Total Subjects <span class="text-danger">*</span></label>
            <input type="text" name="bi_nTotalSubject" required id="bi_nTotalSubject" maxlength="1" pattern="[0-9]{1,10}" value="{{ old('bi_nTotalSubject') }}" placeholder="Total Subjects" class="stdtextbox form-control">
            @error("bi_nTotalSubject")
            <div class="text-right"><small class="text-danger">{{ $message }}</small></div>
            @enderror
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <label> Total Hours </label>
            <input type="text" name="bi_nTotalHours" readonly tabindex="-1" id="bi_nTotalHours" maxlength="1" pattern="[0-9]{1,10}" value="{{ old('bi_nTotalHours') }}" placeholder="Total Hours" class="stdtextbox form-control">
            @error("bi_nTotalHours")
            <div class="text-right"><small class="text-danger">{{ $message }}</small></div>
            @enderror
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 offset-md-9"><br />
            <button class="btn stdbutton btn-block btn-lg btnSave">
                <span class="fa fa-save"></span>
                Save
            </button>
        </div>
    </div>
</form>
<br /><br />

@endsection

@section("script") 
<script>
    $(document).ready(function() {
        
        $("#frmdynamictimetable").submit(function(event) {
            event.preventDefault();
            $(".btnSave").prop("disabled", true);
            $(".btnSave").html("Please Wait...");
            document.getElementById("frmdynamictimetable").submit();
        });

        $(document).on('change input foucsout', '#bi_nNoOfDays,#bi_nNoOfSubject', function () {
            var bi_nNoOfDays = $("#bi_nNoOfDays").val();
            var bi_nNoOfSubject = $("#bi_nNoOfSubject").val();
            var bi_nTotalHours = 0;
            
            if(bi_nNoOfDays==""){bi_nNoOfDays=0;}
            if(bi_nNoOfSubject==""){bi_nNoOfSubject=0;}
 
            bi_nTotalHours = Number(bi_nNoOfDays) * Number(bi_nNoOfSubject);

            console.log("bi_nNoOfDays:"+bi_nNoOfDays);
            console.log("bi_nNoOfSubject:"+bi_nNoOfSubject);
            console.log("bi_nTotalHours:"+bi_nTotalHours);

            $("#bi_nTotalHours").val(bi_nTotalHours);
        });
    });
</script>
@endsection