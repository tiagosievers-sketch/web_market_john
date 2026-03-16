<?php

namespace App\Actions;

use App\Libraries\GatewayHttpLibrary;
use App\Models\DomainValue;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class DomainValueActions
{
    /**
     * @throws Exception
     */
    public static function domainValuesOptions(string $alias, bool $use_alias, string $exclude_alias = ''): array
    {
        $builder = DomainValue::whereHas('domain', function (Builder $query) use ($alias, $exclude_alias) {
            $query->where('alias', '=', $alias);
        });
        if ($exclude_alias != '') {
            $builder->where('alias', '!=', $exclude_alias);
        }
        $values = $builder->get();
        $options = [];
        foreach ($values as $value) {
            if (isset($value->id) && isset($value->alias) && isset($value->name)) {
                $options[$value->id] = ($use_alias) ? $value->alias : $value->name;
            }
        }
        return $options;
    }

    public static function getDomainValueByAlias(string $alias)
    {
        return DomainValue::where('alias', '=', $alias)->first();
    }

    public static function getDomainValuesByDomainId(int $domainId): Collection
    {
        return DomainValue::where('domain_id', $domainId)->get();
    }
    public static function getDomainValuesById(int $Id): Collection
    {
        return DomainValue::where('id', $Id)->get();
    }

    public static function getDomainValuesByIds(array $ids): Collection
    {
        return DomainValue::whereIn('id', $ids)->pluck('name', 'id');
    }
}
