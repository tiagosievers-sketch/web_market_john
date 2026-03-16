@extends('layouts.app')

@section('styles')

@endsection

@section('content')

<!-- BREADCRUMB -->
<div class="breadcrumb-header justify-content-between">
	<div class="my-auto">
		<h4 class="page-title">@lang('labels.iniciarAplicativo')</h4>
	</div>

	<div class="mb-xl-0">
		<div class="btn-group dropdown">
			<a href="#" class="custom-link">
				@lang('labels.startRedirecionamento') <i class="fas fa-share"></i>
			</a>
		</div>
	</div>
</div>


<!-- END BREADCRUMB -->
<div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
	<div class="card">
		<div class="card-body">
			<div class="form-group row align-items-center">
				<label class="col-form-label ">@lang('labels.start')</label>
			</div>
		</div>
		<div class="card-body">
			<div class="row row-sm">
				<div class="col-lg-6 mb-3">
					<div class="input-group">
						<div class="input-group-text">
							@lang('labels.nome'):
						</div>
						<input type="text" class="form-control" id="startName" name="startName" placeholder="@lang('labels.nome')">
					</div>
				</div>
				<div class="col-lg-6 mb-3">
					<div class="input-group">
						<div class="input-group-text">
							@lang('labels.sobreNome'):
						</div>
						<input type="text" class="form-control" id="startLastname" name="startLastname" placeholder="@lang('labels.sobreNome')">
					</div>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div class="row row-sm">
				<div class="col-lg-6 mb-3">
					<div class="input-group">
						<div class="input-group-text">
							@lang('labels.dataNascimento'):
						</div>
						<input class="form-control" id="startDate" name="startDate" placeholder="MM/DD/YYYY" type="text">

					</div>
				</div>
				<div class="col-lg-6 mb-3">
					<div class="input-group ">
						<span class="input-group-text">@lang('labels.estadoDeCobertura'): <i class="fas fa-question"></i></span>
						<select class="form-select">
							<option value="" selected>@lang('labels.campoSelecao')</option>
                            @foreach($states as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
						</select>
					</div>
				</div>

			</div>

		</div>

		<div class="card-body">
			<div class="row row-sm">
				<div class="col-lg-12">
					<div class="input-group">
						<div class="input-group-text">
							<label class="ckbox wd-16 mg-b-0">
								<input class="mg-0" type="checkbox" name="ckbox-formStart">
								<span></span>
							</label>
						</div>
						<input type="hidden" name="ckbox-formStart" value="0">
						<div class="form-control">
							@lang('labels.ckbox-formStart')
						</div>

					</div>
					<label class="col-form-label ">@lang('labels.startConsentimento')</label><a href="#" class="custom-link">
						@lang('labels.startFormConsentimento') <i class="fas fa-share"></i>
					</a>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div class="row row-sm justify-content-center">
				<div class="col-lg-6 text-center">
					<button type="button" class="btn btn-primary btn-lg btn-block">@lang('labels.procurar')</button>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div class="col-lg-6 mg-t-20 mg-lg-t-0">
				<div class="col-lg-6 mb-3 mt-4">
					<div class="input-group ">
						<a href="#" class="btn btn-outline-secondary btn-lg" id="ssnToggle">@lang('labels.pesquise-SSN')</a>
					</div>
				</div>
				<div class="input-group" id="ssnMaskContainer" style="display:none;">
					<div class="input-group-text">
						@lang('labels.cpf'):
						<input class="form-control" id="ssnMask" placeholder="000-00-0000" type="text">
					</div>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div class="form-group row align-items-center">
				<label class="col-form-label ">@lang('labels.resultado')</label>
				<div class="col-lg-6">
					<a href="{{ route('livewire.privacy-information') }}" class="btn btn-secondary btn-lg">@lang("labels.novaAplicacao")</a>
				</div>
			</div>
		</div>

	</div>
</div>

<!-- END ROW -->

@endsection

@section('scripts')

<!-- INTERNAL DATEPICKER JS -->
<script src="{{asset('build/assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>

<!-- INTERNAL JQUERY.MASKEDINPUT JS -->
<script src="{{asset('build/assets/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>

<!-- INTERNAL SPECTRUM-COLORPICKER JS -->
<script src="{{asset('build/assets/plugins/spectrum-colorpicker/spectrum.js')}}"></script>

<!--  INTERNAL SELECT2 JS -->
<script src="{{asset('build/assets/plugins/select2/js/select2.min.js')}}"></script>

<!-- INTERNAL ION-RANGESLIDER JS -->
<script src="{{asset('build/assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>

<!-- INTERNAL JQUERY-AMAZEUI DATETIMEPICKER JS -->
<script src="{{asset('build/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>

<!-- INTERNAL JQUERY-SIMPLE DATETIMEPICKER JS -->
<script src="{{asset('build/assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>

<!-- INTERNAL PICKER JS -->
<script src="{{asset('build/assets/plugins/pickerjs/picker.min.js')}}"></script>

<!-- INTERNAL COLORPICKER JS -->
<script src="{{asset('build/assets/plugins/colorpicker/pickr.es5.min.js')}}"></script>
@vite('resources/assets/js/colorpicker.js')


<!-- BOOTSTRAP-DATEPICKER JS -->
<script src="{{asset('build/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>

<!-- INTERNAL FORM-ELEMENTS JS -->
@vite('resources/assets/js/form-elements.js')

<!--    ESCONDER CAMPO JS -->
<script src="{{ asset('js/mostrarCampo.js') }}"></script>
@endsection
