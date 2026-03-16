 <div class="card-body">
                    <div class="row row-sm">
                        <label class="col-form-label">
                            @lang('labels.householdCasado')
                            <i class="fas fa-question custom-tooltip" data-bs-toggle="modal" data-bs-target="#alertModal"
                                title="@lang('labels.msgClicar')"></i>
                        </label>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="householdOptionMarried"
                                            id="checkYesMarried" value="1">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkYes')</div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="householdOptionMarried"
                                            id="checkNoMarried" value="0">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkNo')</div>
                            </div>
                        </div>
                    </div>
                </div>



                