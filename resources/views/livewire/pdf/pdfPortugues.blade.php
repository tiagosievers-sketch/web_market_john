<!doctype html>
<!-- <html lang="pt"> -->
<html lang="{{ app()->getLocale() }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('pdf.css') }}" type="text/css">
    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet">
    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    <title> @lang('labels.planoSaude')</title>
    <style>
        .per-person-value {
            font-size: 0.8em;
            color: #666;
            margin-left: 4px;
        }
    </style>
</head>

<body>

    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(($profileImagePath ?? null) && file_exists($profileImagePath) ? $profileImagePath : public_path('img/Cotacao.png'))) }}"
        class="full-screen-img" alt="img">


    <div class="margin-top">
        <!-- Informações em duas colunas -->
        <div class="info-container">
            <div class="info-left">
                <p><strong>{{ $nomeCliente }}</strong></p>
                <p><strong>@lang('labels.rendaDeclarada')</strong> {{ $income }}</p>
                <p><strong>@lang('labels.member'):</strong> {{ $membersNumber }}</p>
                @isset($agentPhone)
                    <p><strong>@lang('labels.telefone'):</strong> {{ $agentPhone }}</p>
                @endisset
            </div>
            <div class="info-right">
                <p><strong>@lang('labels.enderecoCEP')</strong>{{ $zipcode }}</p>
                <p><strong>@lang('labels.campoCounty'):</strong> {{ $county }}</p>
                <p><strong>@lang('labels.data'):</strong> {{ $dataCompletaLocalizada }}</p>
            </div>
        </div>

        <table>
            <tbody>
                <tr>
                    <th>@lang('labels.seguradora')</th>
                    <td>{{ $issuerCompany1 }}</td>
                    <td>{{ $issuerCompany2 }}</td>
                    <td>{{ $issuerCompany3 }}</td>
                </tr>
                <tr>
                    <th>@lang('labels.tipoSeguro')</th>
                    <td>{{ $typeOfInsurance1 }}</td>
                    <td>{{ $typeOfInsurance2 }}</td>
                    <td>{{ $typeOfInsurance3 }}</td>
                </tr>
                <tr>
                    <th>@lang('labels.mensalidade')</th>
                    <td>{{ $monthlyPremium1 }}</td>
                    <td>{{ $monthlyPremium2 }}</td>
                    <td>{{ $monthlyPremium3 }}</td>
                </tr>
                <tr>
                    <th>@lang('labels.franquia')</th>
                    <td>
                        {{ $deductible1 }}
                        @php $perPerson1 = (float) preg_replace('/[^\d.]/', '', $deductible1) / $membersNumber; @endphp
                        @if ($perPerson1 > 0)
                            <span class="per-person-value">
                                (${{ number_format($perPerson1, 2) }}/person)
                            </span>
                        @endif
                    </td>
                    <td>
                        {{ $deductible2 }}
                        @php $perPerson2 = (float) preg_replace('/[^\d.]/', '', $deductible2) / $membersNumber; @endphp
                        @if ($perPerson2 > 0)
                            <span class="per-person-value">
                                (${{ number_format($perPerson2, 2) }}/person)
                            </span>
                        @endif
                    </td>
                    <td>
                        {{ $deductible3 }}
                        @php $perPerson3 = (float) preg_replace('/[^\d.]/', '', $deductible3) / $membersNumber; @endphp
                        @if ($perPerson3 > 0)
                            <span class="per-person-value">
                                (${{ number_format($perPerson3, 2) }}/person)
                            </span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>@lang('labels.maximoDesembolso')</th>
                    <td>{{ $outOfPocketMax1 }}</td>
                    <td>{{ $outOfPocketMax2 }}</td>
                    <td>{{ $outOfPocketMax3 }}</td>
                </tr>
                <tr>
                    <th>@lang('labels.networ')</th>
                    <td>{{ $network1 }}</td>
                    <td>{{ $network2 }}</td>
                    <td>{{ $network3 }}</td>
                </tr>
                <tr>
                    <th>@lang('labels.atendimentoPrimario')</th>
                    <td>{{ $primaryCare1 }}</td>
                    <td>{{ $primaryCare2 }}</td>
                    <td>{{ $primaryCare3 }}</td>
                </tr>
                <tr>
                    <th>@lang('labels.especialista')</th>
                    <td>{{ $specialist1 }}</td>
                    <td>{{ $specialist2 }}</td>
                    <td>{{ $specialist3 }}</td>
                </tr>
                <tr>
                    <th>@lang('labels.medicamentos')</th>
                    <td>{{ $genericDrugs1 }}</td>
                    <td>{{ $genericDrugs2 }}</td>
                    <td>{{ $genericDrugs3 }}</td>
                </tr>
                <tr>
                    <th>@lang('labels.emergencia')</th>
                    <td>{{ $emergencyRoom1 }}</td>
                    <td>{{ $emergencyRoom2 }}</td>
                    <td>{{ $emergencyRoom3 }}</td>
                </tr>
                <tr>
                    <th>@lang('labels.valorUrgencia')</th>
                    <td>{{ $emergencyRoomValue1 }}</td>
                    <td>{{ $emergencyRoomValue2 }}</td>
                    <td>{{ $emergencyRoomValue3 }}</td>
                </tr>
                <tr>
                    <th>@lang('labels.radiografias')</th>
                    <td>{{ $radiography1 }}</td>
                    <td>{{ $radiography2 }}</td>
                    <td>{{ $radiography3 }}</td>
                </tr>
                <tr>
                    <th>@lang('labels.examesImagem')</th>
                    <td>{{ $imagingExams1 }}</td>
                    <td>{{ $imagingExams2 }}</td>
                    <td>{{ $imagingExams3 }}</td>
                </tr>
                <tr>
                    <th>@lang('labels.examesSangue')</th>
                    <td>{{ $bloodtests1 }}</td>
                    <td>{{ $bloodtests2 }}</td>
                    <td>{{ $bloodtests3 }}</td>
                </tr>
                <tr>
                    <th>@lang('labels.beneficios')</th>
                    <td><a href="{{ $benefitsLink1 }}" target="_blank">@lang('labels.beneficios')</a></td>
                    <td><a href="{{ $benefitsLink2 }}" target="_blank">@lang('labels.beneficios')</a></td>
                    <td><a href="{{ $benefitsLink3 }}" target="_blank">@lang('labels.beneficios')</a></td>
                </tr>
                <tr>
                    <th>@lang('labels.informacao')</th>
                    <td><a href="{{ $informationLink1 }}" target="_blank">@lang('labels.informacao')</a></td>
                    <td><a href="{{ $informationLink2 }}" target="_blank">@lang('labels.informacao')</a></td>
                    <td><a href="{{ $informationLink3 }}" target="_blank">@lang('labels.informacao')</a></td>
                </tr>
                <tr>
                    <th>@lang('labels.formularios')</th>
                    <td><a href="{{ $formLink1 }}" target="_blank">@lang('labels.formularios')</a></td>
                    <td><a href="{{ $formLink2 }}" target="_blank">@lang('labels.formularios')</a></td>
                    <td><a href="{{ $formLink3 }}" target="_blank">@lang('labels.formularios')</a></td>
                </tr>
            </tbody>
        </table>

        <!-- Quebra de página para o rodapé -->
        <div class="page-break"></div>

        <div class="footer">
            <p style="text-align: center;"><strong>@lang('labels.termosUtilizados')</strong></p>
            <p><strong>@lang('labels.mensalidade'):</strong> @lang('labels.valorMensalidade')</p>
            <p><strong>@lang('labels.franquia'):</strong> @lang('labels.pagarValorFranquia')</p>
            <p><strong>@lang('labels.maximoDesembolso'):</strong> @lang('labels.valorParticipacao')</p>
            <p><strong>@lang('labels.redeCategoria'):</strong></p>
            <ul>
                <li><strong>@lang('labels.EPO'):</strong> @lang('labels.especialistaDaRede')</li>
                <li><strong>@lang('labels.HMO'):</strong> @lang('labels.clinicoGeral')</li>
            </ul>
            <p><strong>@lang('labels.coPay'):</strong> @lang('labels.servicoMedico')</p>
            <ul>
                <li><strong>@lang('labels.atendimentoPrimario'):</strong> @lang('labels.clinicoGeralCo')</li>
                <li><strong>@lang('labels.especialista'):</strong> @lang('labels.especialistaCo')</li>
                <li><strong>@lang('labels.medicamentos'):</strong> @lang('labels.medicamentoGenricoCo')</li>
                <li><strong>@lang('labels.emergencia'):</strong> @lang('labels.emergicaHospitalarCo')</li>
                <li><strong>@lang('labels.atendimentoUrgencia'):</strong>@lang('labels.clinicaUrgencia')</li>
                <li><strong>@lang('labels.radiografias'):</strong></strong>@lang('labels.raioxCo')</li>
                <li><strong>@lang('labels.examesImagem'):</strong> @lang('labels.examesImagemValor')</li>
                <li><strong>@lang('labels.examesSangue'):</strong> @lang('labels.examesSnagueCo')</li>
            </ul>
            <div style="text-align: center;">
                @if (public_path('img/Cotacao.png') === $profileImagePath)
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/2Easy.jpeg'))) }}"
                        class="centered-img" alt="imagem">
                @endif
            </div>

        </div>
    </div>

</body>

</html>
