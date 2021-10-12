<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {!! Form::model(null, ['method' => 'PATCH','class'=>'form-horizontal','id'=>'form-approve','route' => ['employee_loans.update', 0] ,'enctype'=>'multipart/form-data']) !!}
                <input type="hidden" name="eid" id="eid" required="required" /> 
                <input type="hidden" name="is_approved" id="is_approved" required="required" /> 
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Form Persetujuan Pinjaman</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">No Pegawai</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="_no_pegawai" readonly="readonly" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Nama Pegawai</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="_nama_pegawai" readonly="readonly" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Divisi</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="_divisi" readonly="readonly" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Posisi</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="_posisi" readonly="readonly" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Total Pinjaman</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="_total" readonly="readonly" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Alasan Pinjaman</label>
                        <div class="col-md-9">
                            <textarea class="form-control" id="_alasan" rows="5" readonly="readonly" ></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Catatan Atasan</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="manager_notes" id="manager_notes" rows="5" placeholder="Isi catatan di isi oleh atasan"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:vodi(0);" data-value="1" class="btn btn-success waves-effect waves-light btn-submit-approve">
                        <i class="fa fa-check"></i>&nbsp; Setujui
                    </a>
                    <a href="javascript:vodi(0);" data-value="2" class="btn btn-danger waves-effect waves-light btn-submit-approve">
                        <i class="fa fa-times"></i>&nbsp; Tolak
                    </a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>