<?php

namespace App\Http\Livewire;

use App\Actions\ApplicationActions;
use App\Actions\DomainValueActions;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class QuickQuotation extends Component
{
    public function render()
    {
        $data = [];


        $data['sexes'] = DomainValueActions::domainValuesOptions('sex', true);
        $spouseValue = DomainValueActions::getDomainValueByAlias('relacaoEsposa');
        $data['spouse'] = $spouseValue->id;
        $data['relationships'] = DomainValueActions::domainValuesOptions('relationship', true, 'relacaoEsposa');
        $data['language'] = self::getLanguageIdFromLocale();
        $data['years'] = array_map('intval', config('years.available_years'));


        return view('livewire.quick-quotation', $data);
    }



    public static function getLanguageIdFromLocale(): ?int
    {
        $locale = App::getLocale();
    
        $localeToAliasMap = [
            'en' => 'english',
            'pt' => 'portuguese',
        ];
    
        $alias = $localeToAliasMap[$locale] ?? null;
    
        if ($alias) {
            $language = DomainValueActions::getDomainValueByAlias($alias);
            return $language->id ?? null; 
        }
    
        return null; 
    }
    
}
