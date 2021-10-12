<div id="crop-avatar">

        <div class="avatar-view">
            <img class="profile-user-img img-responsive img-thumbnail" src="{{ \App\Helpers\UserHelper::getCompanyLogo() }}" alt="User profile picture">
            <p></p>
            <a href="javascript:void(0);" class="btn btn-primary btn-block btn-sm"><b><i class="fa fa-upload"></i> Ganti Logo</b></a>
        </div>
    
        <!-- Cropping modal -->
        <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog"
            tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form class="avatar-form" action="{{ route('api.upload.company') }}"  enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" id="avatar-modal-label">Logo Perusahaan</h4>
                        </div>
                        <div class="modal-body">
                            <div class="avatar-body">
    
                                <!-- Upload image and data -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="avatar-upload">
                                            <input type="hidden" class="avatar-src" name="avatar_src">
                                            <input type="hidden" class="avatar-data" name="avatar_data">
                                            <input type="file" class="avatar-input filestyle" data-placeholder="Pilih file" data-iconname="fa fa-upload" data-input="false" data-size="sm" data-buttonname="btn-primary" id="avatarInput" name="avatar_file" accept="image/x-png,image/gif,image/jpeg">
                                        </div>
                                    </div>
                                </div>
    
                                <!-- Crop and preview -->
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="avatar-wrapper"></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="avatar-preview preview-lg"></div>
                                        <div class="avatar-preview preview-md"></div>
                                        <div class="avatar-preview preview-sm"></div>
                                    </div>
                                </div>
    
                                <div class="row avatar-btns">
                                    <div class="col-md-9">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm" data-method="rotate"
                                                data-option="-90" title="Rotate -90 degrees">Putar Kiri</button>
                                            <button type="button" class="btn btn-primary btn-sm" data-method="rotate"
                                                data-option="-15">-15deg</button>
                                            <button type="button" class="btn btn-primary btn-sm" data-method="rotate"
                                                data-option="-30">-30deg</button>
                                            <button type="button" class="btn btn-primary btn-sm" data-method="rotate"
                                                data-option="-45">-45deg</button>
                                        </div>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm" data-method="rotate"
                                                data-option="90" title="Rotate 90 degrees">Putar Kanan</button>
                                            <button type="button" class="btn btn-primary btn-sm" data-method="rotate"
                                                data-option="15">15deg</button>
                                            <button type="button" class="btn btn-primary btn-sm" data-method="rotate"
                                                data-option="30">30deg</button>
                                            <button type="button" class="btn btn-primary btn-sm" data-method="rotate"
                                                data-option="45">45deg</button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary btn-block avatar-save btn-sm">
                                            <i class="fa fa-save"></i>&nbsp;Selesai
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal -->
    
        <!-- Loading state -->
        <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
    
    
    </div>