<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;
/**
 * @OA\Schema(
 *     title="GetPlansSearchRequest",
 *     required={"place", "market"},
 *     @OA\Property(
 *         property="filter",
 *         type="object",
 *         description="Plan search filter",
 *         @OA\Property(property="disease_mgmt_programs", type="array", @OA\Items(type="string", enum={"Asthma", "Heart Disease", "Depression", "Diabetes", "High Blood Pressure and High Cholesterol", "Low Back Pain", "Pain Management", "Pregnancy", "Weight Loss Programs"})),
 *         @OA\Property(property="division", type="string", enum={"HealthCare", "Dental"}),
 *         @OA\Property(property="issuer", type="string", description="Issuer name"),
 *         @OA\Property(property="issuers", type="array", @OA\Items(type="string", description="List of issuer names")),
 *         @OA\Property(property="metal_levels", type="array", @OA\Items(type="string", enum={"Catastrophic", "Silver", "Bronze", "Gold", "Platinum"})),
 *         @OA\Property(property="metal_level", type="string", enum={"Catastrophic", "Silver", "Bronze", "Gold", "Platinum"}),
 *         @OA\Property(property="metal_design_types", type="array", @OA\Items(type="object", @OA\Property(property="metal_level", type="string", enum={"Catastrophic", "Silver", "Bronze", "Gold", "Platinum"}), @OA\Property(property="design_types", type="array", @OA\Items(type="string")))),
 *         @OA\Property(property="design_types", type="array", @OA\Items(type="string")),
 *         @OA\Property(property="premium", type="number", format="float"),
 *         @OA\Property(property="type", type="string", enum={"Indemnity", "PPO", "HMO", "EPO", "POS"}),
 *         @OA\Property(property="types", type="array", @OA\Items(type="string")),
 *         @OA\Property(property="deductible", type="number", format="float"),
 *         @OA\Property(property="hsa", type="boolean"),
 *         @OA\Property(property="oopc", type="number", format="float"),
 *         @OA\Property(property="child_dental_coverage", type="boolean"),
 *         @OA\Property(property="adult_dental_coverage", type="boolean"),
 *         @OA\Property(property="drugs", type="array", @OA\Items(type="string", pattern="^[0-9]{5,7}$")),
 *         @OA\Property(property="providers", type="array", @OA\Items(type="string", pattern="^[0-9]{10}$")),
 *         @OA\Property(property="quality_rating", type="number", format="float"),
 *         @OA\Property(property="simple_choice", type="boolean"),
 *         @OA\Property(property="premium_range", type="object", @OA\Property(property="min", type="number", format="float"), @OA\Property(property="max", type="number", format="float")),
 *         @OA\Property(property="deductible_range", type="object", @OA\Property(property="min", type="number", format="float"), @OA\Property(property="max", type="number", format="float"))
 *     ),
 *     @OA\Property(
 *         property="household",
 *         ref="#/components/schemas/Household",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="place",
 *         ref="#/components/schemas/Place",
 *         nullable=false
 *     ),
 *     @OA\Property(property="market", type="string", enum={"Individual", "SHOP", "Any"}, nullable=false),
 *     @OA\Property(property="year", type="number", format="integer", nullable=true),
 *     @OA\Property(property="aptc_override", type="number", format="float", description="Override the APTC calculation with a specific amount", nullable=true),
 *     @OA\Property(property="csr_override", type="string", enum={"CSR73", "CSR87", "CSR94", "LimitedCSR", "ZeroCSR"}, description="Cost-sharing reduction (CSR) override for requests", nullable=true),
 *     @OA\Property(property="catastrophic_override", type="boolean", description="Force the display (or suppression) of catastrophic plans", nullable=true),
 *     @OA\Property(property="suppressed_plan_ids", type="array", @OA\Items(type="string", pattern="^[0-9]{5}[A-Z]{2}[0-9]{7}(,[0-9]{5}[A-Z]{2}[0-9]{7})*$"), nullable=true),
 * )
 */

 /**
 * @OA\Schema(
 *     schema="Household",
 *     type="object",
 *     description="Household information",
 *     @OA\Property(property="income", type="number", format="float", description="Household's yearly income in dollars"),
 *     @OA\Property(property="unemployment_received", type="string", enum={"Adult", "Dependent", "None"}, description="Specifies whether a taxpayer or tax dependent in the household received unemployment benefits for market year 2021"),
 *     @OA\Property(
 *         property="people",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Person"),
 *         description="People in household applying for coverage"
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="Person",
 *     type="object",
 *     description="Information about a person in the household",
 *     @OA\Property(property="age", type="integer", description="Age of the person, required if dob is not provided"),
 *     @OA\Property(property="dob", type="string", format="date", description="Date of birth (YYYY-MM-DD), required if age is not provided"),
 *     @OA\Property(property="has_mec", type="boolean", description="Indicates if the person has minimum essential coverage"),
 *     @OA\Property(property="is_parent", type="boolean", description="Indicates if the person is a parent"),
 *     @OA\Property(property="is_pregnant", type="boolean", description="Indicates if the person is pregnant"),
 *     @OA\Property(property="pregnant_with", type="integer", description="Number of expected children from the pregnancy"),
 *     @OA\Property(property="uses_tobacco", type="boolean", description="Indicates if the person uses tobacco"),
 *     @OA\Property(property="last_tobacco_use_date", type="string", format="date", description="The last date of regular tobacco use (YYYY-MM-DD)"),
 *     @OA\Property(property="gender", type="string", enum={"Male", "Female"}, description="Gender of the person"),
 *     @OA\Property(property="utilization_level", type="string", enum={"Low", "Medium", "High"}, description="Utilization level of the person"),
 *     @OA\Property(property="relationship", type="string", description="Relationship of the person within the household"),
 *     @OA\Property(property="does_not_cohabitate", type="boolean", description="Indicates if the person does not cohabitate with the subscriber"),
 *     @OA\Property(property="aptc_eligible", type="boolean", description="Indicates if the person is eligible for APTC"),
 *     @OA\Property(
 *         property="current_enrollment",
 *         type="object",
 *         description="Current enrollment information for the person"
 *     )
 * )
 */

/**
 * @OA\Schema(
 *     schema="Place",
 *     type="object",
 *     description="Place information",
 *     @OA\Property(property="countyfips", type="string", description="5-digit county FIPS code", example="12345"),
 *     @OA\Property(property="state", type="string", description="2-letter USPS state abbreviation", example="CA"),
 *     @OA\Property(property="zipcode", type="string", description="5-digit ZIP Code", example="90210")
 * )
 */

class GetPlansSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'filter' => 'nullable|array',
            'filter.disease_mgmt_programs' => 'nullable|array',
            'filter.disease_mgmt_programs.*' => 'string|in:Asthma,Heart Disease,Depression,Diabetes,High Blood Pressure and High Cholesterol,Low Back Pain,Pain Management,Pregnancy,Weight Loss Programs',
            'filter.division' => 'nullable|string|in:HealthCare,Dental',
            'filter.issuer' => 'nullable|string',
            'filter.issuers' => 'nullable|array',
            'filter.issuers.*' => 'string',
            'filter.metal_levels' => 'nullable|array',
            'filter.metal_levels.*' => 'string|in:Catastrophic,Silver,Bronze,Gold,Platinum',
            'filter.metal_level' => 'nullable|string|in:Catastrophic,Silver,Bronze,Gold,Platinum',
            'filter.metal_design_types' => 'nullable|array',
            'filter.metal_design_types.*.metal_level' => 'required|string|in:Catastrophic,Silver,Bronze,Gold,Platinum',
            'filter.metal_design_types.*.design_types' => 'required|array',
            'filter.metal_design_types.*.design_types.*' => 'string|in:DesignType1,DesignType2,DesignType3,DesignType4,DesignType5,DesignType6',
            'filter.design_types' => 'nullable|array',
            'filter.design_types.*' => 'string|in:DesignType1,DesignType2,DesignType3,DesignType4,DesignType5,DesignType6',
            'filter.premium' => 'nullable|numeric',
            'filter.type' => 'nullable|string|in:Indemnity,PPO,HMO,EPO,POS',
            'filter.types' => 'nullable|array',
            'filter.types.*' => 'string|in:Indemnity,PPO,HMO,EPO,POS',
            'filter.deductible' => 'nullable|numeric',
            'filter.hsa' => 'nullable|boolean',
            'filter.oopc' => 'nullable|numeric',
            'filter.child_dental_coverage' => 'nullable|boolean',
            'filter.adult_dental_coverage' => 'nullable|boolean',
            'filter.drugs' => 'nullable|array',
            'filter.drugs.*' => 'string|regex:/^[0-9]{5,7}$/',
            'filter.providers' => 'nullable|array',
            'filter.providers.*' => 'string|regex:/^[0-9]{10}$/',
            'filter.quality_rating' => 'nullable|numeric',
            'filter.simple_choice' => 'nullable|boolean',
            'filter.premium_range.min' => 'nullable|numeric',
            'filter.premium_range.max' => 'nullable|numeric',
            'filter.deductible_range.min' => 'nullable|numeric',
            'filter.deductible_range.max' => 'nullable|numeric',

            'household.income' => 'nullable|numeric',
            'household.unemployment_received' => 'nullable|string|in:Adult,Dependent,None',
            'household.people' => 'nullable|array',
            'household.people.*.age' => 'nullable|integer|required_without:household.people.*.dob',
            'household.people.*.dob' => 'nullable|string|date_format:Y-m-d|required_without:household.people.*.age',
            'household.people.*.has_mec' => 'nullable|boolean',
            'household.people.*.is_parent' => 'nullable|boolean',
            'household.people.*.is_pregnant' => 'nullable|boolean',
            'household.people.*.pregnant_with' => 'nullable|integer',
            'household.people.*.uses_tobacco' => 'nullable|boolean',
            'household.people.*.last_tobacco_use_date' => 'nullable|string|date_format:Y-m-d',
            'household.people.*.gender' => 'nullable|string|in:Male,Female',
            'household.people.*.utilization_level' => 'nullable|string|in:Low,Medium,High',
            'household.people.*.relationship' => 'nullable|string',
            'household.people.*.does_not_cohabitate' => 'nullable|boolean',
            'household.people.*.aptc_eligible' => 'nullable|boolean',
            'household.people.*.current_enrollment' => 'nullable|array',

            // 'place.countyfips' => 'required|string|size:5',
            // 'place.state' => 'required|string|size:2',
            // 'place.zipcode' => 'required|string|size:5',

            'offset' => 'nullable|integer',
            'order' => 'nullable|string|in:asc,desc',
            'sort' => 'nullable|string|in:premium,deductible,oopc,total_costs,quality_rating',
            'year' => 'nullable|integer',
            'market' => 'required|string|in:Individual,SHOP,Any',
            'aptc_override' => 'nullable|numeric',
            'csr_override' => 'nullable|string|in:CSR73,CSR87,CSR94,LimitedCSR,ZeroCSR',
            'catastrophic_override' => 'nullable|boolean',
            'suppressed_plan_ids' => 'nullable|array',
            'suppressed_plan_ids.*' => 'string|regex:/^[0-9]{5}[A-Z]{2}[0-9]{7}(,[0-9]{5}[A-Z]{2}[0-9]{7})*$/',
        ];
    }

    public function messages()
    {
        return [
            // 'place.countyfips.required' => 'County FIPS code is required.',
            // 'place.state.required' => 'State is required.',
            // 'place.zipcode.required' => 'ZIP Code is required.',
            // Add custom messages for other fields as needed
        ];
    }
}
