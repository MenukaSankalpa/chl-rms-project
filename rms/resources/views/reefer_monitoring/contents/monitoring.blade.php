<!-- Collapsable Card Example -->
<div class="card shadow mb-4">
    <form name="schedule_by_date">
        <!-- Card Header - Accordion -->
        <a href="#cc" class="d-block card-header py-3" data-toggle="collapse" role="button"
           aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Date</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse {{--show--}} hide" name="collapseCardExample" id="cc">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label>04:00</label>
                            <input type="number" step="0.00" class="form-control"
                                   name="schedule_4"
                                   placeholder="04:00 Temp"
                                   >
                        </div>
                        <div class="form-group">
                            <label>16:00</label>
                            <input type="number" step="0.00" class="form-control"
                                   name="schedule_16"
                                   placeholder="16:00 Temp"
                                   >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>08:00</label>
                            <input type="number" step="0.00" class="form-control"
                                   name="schedule_8"
                                   placeholder="08:00 Temp"
                                   >
                        </div>
                        <div class="form-group">
                            <label>20:00</label>
                            <input type="number" step="0.00" class="form-control"
                                   name="schedule_20"
                                   placeholder="20:00 Temp"
                                   >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>12:00</label>
                            <input type="number" step="0.00" class="form-control"
                                   name="schedule_12"
                                   placeholder="12:00 Temp"
                                   >
                        </div>
                        <div class="form-group">
                            <label>24:00</label>
                            <input type="number" step="0.00" class="form-control"
                                   name="schedule_24"
                                   placeholder="24:00 Temp"
                                   >
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary btn-sm" type="submit" name="update">
                            <i class="fa fa-edit"></i> Update
                        </button>
                        <button class="btn btn-danger btn-sm" type="submit" name="delete">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </div>
                </div>


            </div>
        </div>
    </form>
</div>