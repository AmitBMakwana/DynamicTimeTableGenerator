@extends("layouts.visitor")

@section("title")
Generate Time Table
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
            Generate Time Table
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

<form action="" method="POST" id="frmdynamictimetable">
    
    @csrf
    @method("PATCH")

    <div class="row">
        <input type="hidden" name="bi_iId" value="{{ $result->bi_iId }}" />

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <label> No. Of Working Days <span class="text-danger">*</span></label>
            <input type="text" name="bi_nNoOfDays" readonly id="bi_nNoOfDays" maxlength="1" pattern="[0-9]{1,7}" value="{{ old('bi_nNoOfDays',$result->bi_nNoOfDays) }}" placeholder="No. Of Working Days" class="stdtextbox form-control">
            @error("bi_nNoOfDays")
            <div class="text-right"><small class="text-danger">{{ $message }}</small></div>
            @enderror
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <label> No. Of Subject Per Days <span class="text-danger">*</span></label>
            <input type="text" name="bi_nNoOfSubject" readonly id="bi_nNoOfSubject" maxlength="1" pattern="[0-9]{1,8}" value="{{ old('bi_nNoOfSubject',$result->bi_nNoOfSubject) }}" placeholder="No. Of Subject Per Days" class="stdtextbox form-control">
            @error("bi_nNoOfSubject")
            <div class="text-right"><small class="text-danger">{{ $message }}</small></div>
            @enderror
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <label> Total Subjects <span class="text-danger">*</span></label>
            <input type="text" name="bi_nTotalSubject" readonly id="bi_nTotalSubject" maxlength="1" pattern="[0-9]{1,10}" value="{{ old('bi_nTotalSubject',$result->bi_nTotalSubject) }}" placeholder="Total Subjects" class="stdtextbox form-control">
            @error("bi_nTotalSubject")
            <div class="text-right"><small class="text-danger">{{ $message }}</small></div>
            @enderror
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <label> Total Hours </label>
            <input type="text" name="bi_nTotalHours" readonly tabindex="-1" id="bi_nTotalHours" maxlength="1" pattern="[0-9]{1,10}" value="{{ old('bi_nTotalHours',$result->bi_nTotalHours) }}" placeholder="Total Hours" class="stdtextbox form-control">
            @error("bi_nTotalHours")
            <div class="text-right"><small class="text-danger">{{ $message }}</small></div>
            @enderror
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive" id="tableEnterSubjectNames" style="display: none;">
                <table class="table table-bordered table-striped table-hover table-sm" id="t_EnterSubjectNames" width="100%">
                    <thead>
                        <tr>
                            <th class="small" width="30%"><b>Enter Subjects</b></th>
                            <th class="small" width="15%"><b>Enter Hours</b></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 small"></div>
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 small"></div>
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 small"></div>
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 small"></div>
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 small"></div>

        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 small">
            <button type="button" class="btn btn-block  stdbutton btnSave">
                <span class="far fa-file-alt"></span>
                Generate
            </button>
        </div>
    </div>

    <br/>
    <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 cl-xs-12">
                <div class="table-responsive" id="productTable">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover table-sm" id="DynamicTimeTable" style="width: 100%;">
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br/>
</form>
<br /><br />

@endsection

@section("script") 
<script>
    $(document).ready(function() {
        
        var bi_nNoOfDays=$("#bi_nNoOfDays").val();
        var bi_nNoOfSubject=$("#bi_nNoOfSubject").val();
        var bi_nTotalSubject=$("#bi_nTotalSubject").val();
        var bi_nTotalHours=$("#bi_nTotalHours").val();
        var subjectarr = new Array();
        display_subjectgrid(bi_nTotalSubject);

        // $("#frmdynamictimetable").submit(function(event) {
        //     event.preventDefault();
        //     $(".btnSave").prop("disabled", true);
        //     $(".btnSave").html("Please Wait...");
        //     document.getElementById("frmdynamictimetable").submit();
        // });

        function getlength(obj) {
            var c = 0;
            for (var key in obj) {
                if (obj.hasOwnProperty(key)) ++c;
            }
            return c;
        }

        $('.isDecimal').keypress(function(eve) {
            if ((eve.which != 46 || $(this).val().indexOf('.') != -1) && (eve.which < 48 || eve.which > 57)) {
                eve.preventDefault();
            }
            $('.isDecimal').keyup(function(eve) {
                if($(this).val().indexOf('.') == 0) {    $(this).val($(this).val().substring(1));
                }
            });
        });

        function display_subjectgrid(bi_nTotalSubject){
            $('#t_EnterSubjectNames tbody').html('');
            var tableRow='';
            for(i=0;i<bi_nTotalSubject;i++){
                tableRow += '<tr>\
                        <td>\
                        <input type="text" data-index="' + i + '" data-column="subjectName" name="subjectName' + i + '" id="subjectName' + i + '" maxlength="11" value="" class="form-control stdtextbox gridproduct" autocomplete="off">\
                        </td>\
                        <td>\
                        <input type="text" data-index="' + i + '" data-column="subjectHours" name="subjectHours' + i + '" id="subjectHours' + i + '" maxlength="11" value="" class="form-control stdtextbox gridproduct isDecimal" autocomplete="off">\
                        </td>\
                    </tr>';
            }
            $('#t_EnterSubjectNames tbody').html(tableRow);
            $("#tableEnterSubjectNames").show();
        }

        $(document).on('click', '.btnSave', function () {
            var bi_nNoOfDays=$("#bi_nNoOfDays").val();
            var bi_nNoOfSubject=$("#bi_nNoOfSubject").val();
            var bi_nTotalSubject=$("#bi_nTotalSubject").val();
            var bi_nTotalHours=$("#bi_nTotalHours").val();

            var subName=false;
            var totaHours = 0;
            // var subjectarr= new Array();
            var no=0;
            for(i=0;i<bi_nTotalSubject;i++){
                if($("#subjectName"+i).val()==""){
                    subName=true;
                }
                totaHours += Number($("#subjectHours"+i).val());
                for(j=0;j<Number($("#subjectHours"+i).val());j++){
                    subjectarr[no]=$("#subjectName"+i).val();
                    no = Number(no) + 1;
                }
            }

            if(bi_nTotalHours!=totaHours){
                $("#DynamicTimeTable").empty();
                alert("Enter Proper Hours\nTotal Hours Must Be " + bi_nTotalHours +"Hours!!!");
            }else if(subName){
                $("#DynamicTimeTable").empty();
                alert("Enter Proper Subjects!!!");
            }else{
                generateTimeTable(bi_nNoOfDays,bi_nNoOfSubject);
            }
        });

        function generateTimeTable(bi_nNoOfDays,bi_nNoOfSubject){
            $("#DynamicTimeTable").empty();
            var tableRow='';

            tableRow +='<tr>'; 
            for(i=1;i<=bi_nNoOfDays;i++){
                tableRow += '<td>Day'+ i+'</td>';
            }
            tableRow +='</tr>'; 

            for(i=1;i<=bi_nTotalSubject;i++){
                tableRow +='<tr>'; 
                for(j=1;j<=bi_nNoOfDays;j++){
                    var random = Math.floor(Math.random() * subjectarr.length);
                    var key = random;
                    tableRow += '<td>'+subjectarr[random]+'</td>';
                    const index = subjectarr.indexOf(subjectarr[random]);
                    if (index > -1) { // only splice array when item is found
                        subjectarr.splice(index, 1); // 2nd parameter means remove one item only
                    }
                }
                tableRow +='</tr>'; 
            }
            $("#DynamicTimeTable").append(tableRow);
        }
    });
</script>
@endsection