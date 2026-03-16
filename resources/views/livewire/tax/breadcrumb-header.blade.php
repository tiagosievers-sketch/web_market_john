    <!-- BREADCRUMB -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <h4 class="page-title">@lang('labels.householdTitulo')</h4>
            {{-- <span id="currentMemberName">Membro: <strong>{{ $current_member['firstname'] ?? 'N/A' }} {{ $current_member['lastname'] ?? '' }}</strong></span>  --}}
        </div>
    </div>
    <!-- END BREADCRUMB -->

    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="tab">
                    <button id="tabTaxHousehold" class="tablinks"
                        onclick="openTab(event, 'taxHousehold')">@lang('labels.householdFamilia')</button>
                </div>
            </div>
        </div>
    </div>
