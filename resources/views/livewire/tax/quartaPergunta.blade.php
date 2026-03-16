{{-- Are you and your spouse claiming any dependents on your taxes for 2024? --}}

<div class="row row-sm" id="impostoConjugethree" style="display: none;">
                        <label class="col-form-label">@lang('labels.householdDeclaracaoImpostoConjugethree', ['year' => date('Y')])</label>
                        <div class="col-lg-12 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="showHouseholdConjugeThree"
                                            id="showHouseholdConjugeYesthree" value="1">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkYes')</div>

                                <div class="input-group-text" style="margin-left: 10px">
                                    <label class="rdiobox wd-16 mg-b-0">
                                        <input class="mg-0" type="radio" name="showHouseholdConjugeThree"
                                            id="showHouseholdConjugeNothree" value="0">
                                        <span></span>
                                    </label>
                                </div>
                                <div class="form-control">@lang('labels.checkNo')</div>
                            </div>
                        </div>
                    </div>
                    {{-- fim pergunta 4 --}}