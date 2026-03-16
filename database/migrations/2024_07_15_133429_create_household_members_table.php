<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('household_members', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->unsignedBigInteger('suffix')->nullable();
            $table->foreign('suffix')->references('id')->on('domain_values');
            $table->date('birthdate');
            $table->unsignedBigInteger('sex');
            $table->foreign('sex')->references('id')->on('domain_values');
            $table->boolean('tax_form')->default(false);
            $table->unsignedBigInteger('lives_with')->nullable();
            $table->foreign('lives_with')->references('id')->on('household_members');
            $table->boolean('tax_filler')->default(false);
            $table->unsignedBigInteger('tax_claimant')->nullable();
            $table->foreign('tax_claimant')->references('id')->on('household_members');
            $table->boolean('provide_tax_filler_information')->default(false);
            $table->integer('field_type');
            $table->boolean('applying_coverage')->default(false);
            $table->boolean('eligible_cost_saving')->default(false);
            $table->boolean('married')->default(false);
            $table->boolean('fed_tax_income_return')->default(false);
            $table->boolean('is_dependent')->default(false);
            $table->boolean('jointly_taxed_spouse')->default(false);
            $table->boolean('has_ssn')->default(false);
            $table->string('ssn')->nullable();
            $table->boolean('has_perm_address')->default(false);
            $table->unsignedBigInteger('application_id');
            $table->foreign('application_id')->references('id')->on('applications');
            //
            $table->boolean('live_someone_under_nineteen')->default(false);
            $table->boolean('taking_care_under_nineteen')->default(false);
            $table->boolean('live_any_other_family')->default(false);
            $table->boolean('live_son_daughter')->default(false);
            $table->boolean('use_tobacco')->default(false);
            $table->date('last_tobacco_usage')->nullable();
            $table->boolean('is_us_citizen')->default(false);
            $table->unsignedBigInteger('eligible_immigration_status')->nullable();
            $table->unsignedBigInteger('document_type')->nullable();
            $table->string('document_number', 50)->nullable();
            $table->unsignedBigInteger('document_number_type')->nullable();
            $table->string('document_complement_number', 50)->nullable();
            $table->date('document_expiration_date')->nullable();
            $table->unsignedBigInteger('document_country_issuance')->nullable();
            $table->string('document_category_code', 50)->nullable();
            $table->boolean('has_sevis')->default(false);
            $table->string('sevis_number', 50)->nullable();
            $table->boolean('is_federally_recognized_indian_tribe')->default(false);
            $table->boolean('has_hhs_or_refugee_resettlement_cert')->default(false);
            $table->boolean('has_orr_eligibility_letter')->default(false);
            $table->boolean('is_cuban_haitian_entrant')->default(false);
            $table->boolean('is_lawfully_present_american_samoa')->default(false);
            $table->boolean('is_battered_spouse_child_parent_vawa')->default(false);
            $table->boolean('has_another_document_or_alien_number')->default(false);
            $table->boolean('none_of_these_document')->default(false);
            $table->boolean('is_incarcerated')->default(false);
            $table->boolean('is_ai_aln')->default(false);
            $table->boolean('is_hip_lat_spanish')->default(false);
            $table->unsignedBigInteger('hip_lat_spanish_specific')->nullable();
            $table->unsignedBigInteger('race')->nullable();
            $table->boolean('declined_race')->default(false);
            $table->unsignedBigInteger('birth_sex')->nullable();
            $table->unsignedBigInteger('gender_identity')->nullable();
            $table->unsignedBigInteger('sexual_orientation')->nullable();
            $table->boolean('same_document_name')->default(false);
            $table->string('document_first_name', 200)->nullable();
            $table->string('document_middle_name', 200)->nullable();
            $table->string('document_last_name', 200)->nullable();
            $table->unsignedBigInteger('document_suffix')->nullable();
            $table->boolean('is_pregnant')->default(false);
            $table->integer('babies_expected')->nullable();
            // Add foreign key constraints if needed
            $table->foreign('eligible_immigration_status')->references('id')->on('domain_values');
            $table->foreign('document_type')->references('id')->on('domain_values');
            $table->foreign('document_number_type')->references('id')->on('domain_values');
            $table->foreign('document_country_issuance')->references('id')->on('domain_values');
            $table->foreign('hip_lat_spanish_specific')->references('id')->on('domain_values');
            $table->foreign('race')->references('id')->on('domain_values');
            $table->foreign('birth_sex')->references('id')->on('domain_values');
            $table->foreign('gender_identity')->references('id')->on('domain_values');
            $table->foreign('sexual_orientation')->references('id')->on('domain_values');
            $table->foreign('document_suffix')->references('id')->on('domain_values');
            //
            $table->boolean('has_income')->default(false);
            $table->boolean('has_deduction_current_year')->default(false);
            $table->boolean('income_confirmed')->default(false);
            $table->boolean('income_predictable')->default(false);
            $table->decimal('income_predicted_amount', 14, 2)->nullable();
            //
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('household_members');
    }
};
