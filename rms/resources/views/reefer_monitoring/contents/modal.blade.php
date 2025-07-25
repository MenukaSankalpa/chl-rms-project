<div class="modal bd-example-modal-lg" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Upload Excel.</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{url('/upload')}}" enctype="multipart/form-data" method="post">
            @csrf
            <!-- Modal body -->
                <div class="modal-body">
                    <label>file</label>
                    <input type="file" name="upload_file">
                    {{--redirect target contains the path of the reader controller that will read the uploaded file.--}}
                    <input type="hidden" name="redirect_target" value="read/monitoring_data_excel/">
                </div>
            {{--https://handsontable.com/ excel like table--}}
            <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Upload EXCEL</button>
                </div>
            </form>
        </div>
    </div>
</div>
