<!-- Modal -->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="ec-vendor-block-img space-bottom-30">
                        <div class="ec-vendor-block-bg cover-upload">
                            <div class="thumb-upload">
                                <div class="thumb-preview ec-preview">
                                    <div class="image-thumb-preview">
                                        <img class="image-thumb-preview ec-image-preview v-img"
                                            src="{{ url('assets/img/main_banner.png') }}" alt="edit" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="row g-3" action="{{ url('profile') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="ec-vendor-block-detail">
                                <div class="thumb-upload">
                                    <div class="thumb-edit">
                                        <input type='file' id="thumbUpload02" class="ec-image-upload"
                                            accept=".png, .jpg, .jpeg" name="user_image" />
                                        <label><i class="fi-rr-edit"></i></label>
                                    </div>
                                    <div class="thumb-preview ec-preview">
                                        <div class="image-thumb-preview">
                                            <img class="image-thumb-preview ec-image-preview v-img"
                                                src="{{ Avatar::create($user->name)->toBase64() }}" alt="edit" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ec-vendor-upload-detail">
                                <div class="col-md-12 space-t-15">
                                    <label class="form-label user-profile">Full Name</label>
                                    <input type="text" class="form-control"value="{{ $user->name }}"
                                        name="name">
                                </div>
                                <div class="col-md-12 space-t-15">
                                    <label class="form-label user-profile">Address</label>
                                    <input type="text" class="form-control" name="address">
                                </div>
                                <div class="col-md-12 space-t-15">
                                    <label class="form-label user-profile">Email ID</label>
                                    <input type="text" class="form-control" value="{{ $user->email }}"
                                        name="email">
                                </div>
                                <div class="col-md-6 space-t-15">
                                    <label class="form-label user-profile">Primary Phone number</label>
                                    <input type="text" class="form-control" value="{{ $user->phone }}"
                                        name="phone">
                                </div>
                                <div class="col-md-6 space-t-15">
                                    <label class="form-label user-profile">Secondary Phone number</label>
                                    <input type="text" class="form-control" name="secondary_phone">
                                </div>
                                <div class="col-md-12 space-t-15">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="#" class="btn btn-lg btn-secondary qty_close" data-bs-dismiss="modal"
                                        aria-label="Close">Close</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Modal end -->
