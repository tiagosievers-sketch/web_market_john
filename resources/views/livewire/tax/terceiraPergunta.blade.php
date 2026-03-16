        {{-- Are you filing taxes jointly with your spouse for 2024? --}}
        
        <div class="row row-sm" id="impostoConjugetwo" style="display: none;">
                        <label class="col-form-label">@lang('labels.householdDeclaracaoImpostoConjugetwo', ['year' => date('Y')])</label>
                        <div class="col-lg-12 mb-3">
                            <div class="d-flex">
                                <!-- Yes button -->
                                <div class="input-group me-3"> <!-- Use 'me-3' para adicionar margem entre os botões -->
                                    <div class="input-group-text">
                                        <label class="rdiobox wd-16 mg-b-0">
                                            <input class="mg-0" type="radio" name="taxedspouse"
                                                id="showHouseholdConjugeYestwo" value="1">
                                            <span></span>
                                        </label>
                                    </div>
                                    <input type="hidden" name="taxedspouse" id="taxedspouseYes" value="1">
                                    <div class="form-control">
                                        @lang('labels.checkYes')
                                    </div>
                                </div>

                                <!-- No button -->
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <label class="rdiobox wd-16 mg-b-0">
                                            <input class="mg-0" type="radio" name="taxedspouse"
                                                id="showHouseholdConjugeNotwo" value="0">
                                            <span></span>
                                        </label>
                                    </div>
                                    <input type="hidden" name="taxedspouse" id="taxedspouseNo" value="0">
                                    <div class="form-control">
                                        @lang('labels.checkNo')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- fim 3 pergunta --}}
