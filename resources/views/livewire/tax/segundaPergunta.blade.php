
               {{-- Do you plan to file a federal income tax return for 2024?
You don't have to file taxes to apply for coverage, but you'll need to file next year if you want to get a premium tax credit to help pay for coverage now. --}}
               
                <div class="card-body">
                    {{-- pergunta 2  --}}
                    <div class="row row-sm">
                        <label class="col-form-label">
                            @lang('labels.householdDeclaracaoImposto', ['year' => date('Y')]) <br>
                            @lang('labels.householdDeclaracaoAlerta')
                        </label>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="incomeTax" id="showHouseholdYes"
                                            value="1">
                                        <span></span>
                                    </label>
                                </div>
                                <input type="hidden" name="incomeTax" id="incomeTaxYes" value="1">
                                <div class="form-control">
                                    @lang('labels.checkYes')
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="incomeTax" id="showHouseholdNo"
                                            value="0">
                                        <span></span>
                                    </label>
                                </div>
                                <input type="hidden" name="incomeTax" id="incomeTaxNo" value="0">
                                <div class="form-control">
                                    @lang('labels.checkNo')
                                </div>
                            </div>
                        </div>
                    </div>
